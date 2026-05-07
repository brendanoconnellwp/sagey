#!/usr/bin/env node
/**
 * Scaffold a new ACF Pro block following the Hero canonical pattern.
 *
 * Usage:
 *   npm run make:block -- <kebab-name> [--title "Display Title"]
 *
 * Examples:
 *   npm run make:block -- features
 *   npm run make:block -- two-column-content --title "Two-Column Content"
 *
 * Generates:
 *   app/Blocks/{Pascal}.php                   ← register + fields + render
 *   resources/blocks/{kebab}/block.json       ← block metadata, ACF renderCallback
 *   resources/views/blocks/{kebab}.blade.php  ← template
 *   resources/scss/components/_{kebab}.scss   ← styles
 *
 * Mutates:
 *   resources/scss/components/_index.scss     ← appends @forward
 *   app/setup.php                             ← inserts class into $blocks array
 *
 * Idempotent: skips files that already exist; prints what was created vs skipped.
 * Lint after generation: `npm run format && npm run lint`.
 */

import { existsSync, readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, resolve } from 'node:path';

const here = dirname(fileURLToPath(import.meta.url));
const themeRoot = resolve(here, '..');

// ---- Argv ------------------------------------------------------------------

const args = process.argv.slice(2);
const positional = args.filter((a) => !a.startsWith('--'));
const flags = Object.fromEntries(
  args
    .filter((a) => a.startsWith('--'))
    .map((a, i, arr) => {
      const [k, v] = a.replace(/^--/, '').split('=');
      return v !== undefined ? [k, v] : [k, arr[i + 1] ?? true];
    }),
);

const kebab = positional[0];
if (!kebab || !/^[a-z][a-z0-9]*(-[a-z0-9]+)*$/.test(kebab)) {
  console.error('Usage: npm run make:block -- <kebab-name> [--title "Title"]');
  console.error('Block name must be kebab-case, e.g. "features", "two-column-content".');
  process.exit(1);
}

const pascal = kebab
  .split('-')
  .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
  .join('');
const title =
  flags.title ??
  kebab
    .split('-')
    .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
    .join(' ');
const fieldKeySlug = kebab.replace(/-/g, '_');

// ---- Templates -------------------------------------------------------------

const phpClass = `<?php

namespace App\\Blocks;

class ${pascal}
{
    public static function register(): void
    {
        register_block_type(get_theme_file_path('resources/blocks/${kebab}/block.json'));
    }

    public static function registerFields(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key' => 'group_block_${fieldKeySlug}',
            'title' => '${title} Block',
            'fields' => [
                [
                    'key' => 'field_${fieldKeySlug}_heading',
                    'label' => 'Heading',
                    'name' => 'heading',
                    'type' => 'text',
                    'default_value' => '${title}',
                ],
            ],
            'location' => [[
                ['param' => 'block', 'operator' => '==', 'value' => 'sage/${kebab}'],
            ]],
        ]);
    }

    public static function render($block, $content = '', $is_preview = false, $post_id = 0): void
    {
        echo view('blocks.${kebab}', [
            'block' => $block,
            'content' => $content,
            'is_preview' => $is_preview,
            'post_id' => $post_id,
            'heading' => get_field('heading') ?: '',
        ])->render();
    }
}
`;

const blockJson =
  JSON.stringify(
    {
      $schema: 'https://schemas.wp.org/trunk/block.json',
      apiVersion: 3,
      name: `sage/${kebab}`,
      title,
      description: `${title} block.`,
      category: 'sagey',
      icon: 'block-default',
      keywords: [kebab],
      textdomain: 'sage',
      supports: {
        align: ['wide', 'full'],
        anchor: true,
        html: false,
      },
      acf: {
        mode: 'preview',
        renderCallback: `App\\Blocks\\${pascal}::render`,
      },
    },
    null,
    2,
  ) + '\n';

const bladeView = `@php
  $anchor = ! empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
  $classes = trim('${kebab} ' . ($block['className'] ?? ''));
@endphp

<section {!! $anchor !!} class="{{ $classes }}">
  <div class="${kebab}__inner">
    @if ($heading)
      <h2 class="${kebab}__heading">{{ $heading }}</h2>
    @endif
  </div>
</section>
`;

const scssPartial = `@use "../abstracts" as *;

.${kebab} {
  padding-block: $space-16;

  &__inner {
    @include container;
  }

  &__heading {
    font-size: $text-3xl;
    margin: 0 0 $space-6;
  }
}
`;

// ---- Write files -----------------------------------------------------------

const targets = [
  { path: `app/Blocks/${pascal}.php`, contents: phpClass },
  { path: `resources/blocks/${kebab}/block.json`, contents: blockJson },
  { path: `resources/views/blocks/${kebab}.blade.php`, contents: bladeView },
  { path: `resources/scss/components/_${kebab}.scss`, contents: scssPartial },
];

const created = [];
const skipped = [];

for (const { path, contents } of targets) {
  const full = resolve(themeRoot, path);
  if (existsSync(full)) {
    skipped.push(path);
    continue;
  }
  mkdirSync(dirname(full), { recursive: true });
  writeFileSync(full, contents);
  created.push(path);
}

// ---- Mutate components/_index.scss -----------------------------------------

const componentsIndex = resolve(themeRoot, 'resources/scss/components/_index.scss');
const componentsIndexContents = readFileSync(componentsIndex, 'utf8');
const forwardLine = `@forward "${kebab}";\n`;
let componentsIndexUpdated = false;
if (!componentsIndexContents.includes(forwardLine.trim())) {
  writeFileSync(componentsIndex, componentsIndexContents + forwardLine);
  componentsIndexUpdated = true;
}

// ---- Mutate app/setup.php --------------------------------------------------

const setupPath = resolve(themeRoot, 'app/setup.php');
const setupContents = readFileSync(setupPath, 'utf8');
const marker = '// {{ make:block insertion point — do not remove }}';
const blockEntry = `\\App\\Blocks\\${pascal}::class,`;
let setupUpdated = false;
if (!setupContents.includes(marker)) {
  console.warn(
    `[make:block] WARNING: marker "${marker}" not found in app/setup.php — add the registration line manually:`,
  );
  console.warn(`             ${blockEntry}`);
} else if (setupContents.includes(blockEntry)) {
  // already registered, nothing to do
} else {
  const updated = setupContents.replace(
    marker,
    `${blockEntry}\n    ${marker}`,
  );
  writeFileSync(setupPath, updated);
  setupUpdated = true;
}

// ---- Report ----------------------------------------------------------------

console.log(`\n[make:block] sage/${kebab} (${title})`);
if (created.length) {
  console.log('  created:');
  for (const p of created) console.log(`    + ${p}`);
}
if (skipped.length) {
  console.log('  skipped (already exists):');
  for (const p of skipped) console.log(`    · ${p}`);
}
if (componentsIndexUpdated) console.log(`  appended @forward to components/_index.scss`);
if (setupUpdated) console.log(`  inserted ${pascal}::class into setup.php`);

console.log('\n  next:');
console.log('    1. npm run format && npm run lint');
console.log('    2. ddev composer lint:fix && ddev composer analyse');
console.log('    3. open the editor and search the inserter for "' + title + '"');
