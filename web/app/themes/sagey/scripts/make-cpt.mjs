#!/usr/bin/env node
/**
 * Scaffold a new custom post type following the canonical pattern.
 *
 * Usage:
 *   npm run make:cpt -- <kebab-name> [--singular "Singular"] [--plural "Plural"]
 *
 * Examples:
 *   npm run make:cpt -- project
 *   npm run make:cpt -- case-study --singular "Case Study" --plural "Case Studies"
 *
 * Generates:
 *   app/PostTypes/{Pascal}.php                            ← register + ACF fields
 *   resources/views/single-{kebab}.blade.php              ← single template
 *   resources/views/archive-{kebab}.blade.php             ← archive template
 *   resources/views/partials/content-{kebab}.blade.php    ← archive list item
 *   resources/scss/components/_{kebab}-archive.scss       ← archive styles
 *   tests/Theme/PostTypes/{Pascal}Test.php                ← Pest test
 *
 * Mutates:
 *   resources/scss/components/_index.scss                 ← appends @forward
 *   app/setup.php                                         ← inserts class into $postTypes array
 *
 * Idempotent: skips files that already exist.
 * Lint after: `npm run format && npm run lint && ddev composer lint && ddev composer test`.
 */

import { existsSync, readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, resolve } from 'node:path';

const here = dirname(fileURLToPath(import.meta.url));
const themeRoot = resolve(here, '..');
const projectRoot = resolve(themeRoot, '../../../..');

// ---- Argv ------------------------------------------------------------------

const args = process.argv.slice(2);
const positional = [];
const flags = {};
for (let i = 0; i < args.length; i++) {
  const a = args[i];
  if (!a.startsWith('--')) {
    positional.push(a);
    continue;
  }
  const [k, inline] = a.replace(/^--/, '').split('=');
  if (inline !== undefined) {
    flags[k] = inline;
  } else if (args[i + 1] !== undefined && !args[i + 1].startsWith('--')) {
    flags[k] = args[++i];
  } else {
    flags[k] = true;
  }
}

const kebab = positional[0];
if (!kebab || !/^[a-z][a-z0-9]*(-[a-z0-9]+)*$/.test(kebab)) {
  console.error('Usage: npm run make:cpt -- <kebab-name> [--singular "Singular"] [--plural "Plural"]');
  console.error('CPT name must be kebab-case, e.g. "project", "case-study".');
  process.exit(1);
}

const pascal = kebab
  .split('-')
  .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
  .join('');
const snake = kebab.replace(/-/g, '_');
const titleCased = kebab
  .split('-')
  .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
  .join(' ');
const singular = flags.singular ?? titleCased;
const plural = flags.plural ?? `${singular}s`;

// ---- Templates -------------------------------------------------------------

const phpClass = `<?php

namespace App\\PostTypes;

class ${pascal}
{
    public const SLUG = '${kebab}';

    public static function register(): void
    {
        register_post_type(self::SLUG, [
            'labels' => [
                'name' => __('${plural}', 'sage'),
                'singular_name' => __('${singular}', 'sage'),
                'menu_name' => __('${plural}', 'sage'),
                'add_new' => __('Add New', 'sage'),
                'add_new_item' => __('Add New ${singular}', 'sage'),
                'edit_item' => __('Edit ${singular}', 'sage'),
                'view_item' => __('View ${singular}', 'sage'),
                'all_items' => __('All ${plural}', 'sage'),
                'search_items' => __('Search ${plural}', 'sage'),
                'not_found' => __('No ${plural} found.', 'sage'),
            ],
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-portfolio',
            'menu_position' => 20,
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
            'rewrite' => ['slug' => '${kebab}', 'with_front' => false],
        ]);
    }

    public static function registerFields(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key' => 'group_post_type_${snake}',
            'title' => '${singular} Details',
            'fields' => [
                [
                    'key' => 'field_${snake}_summary',
                    'label' => 'Summary',
                    'name' => 'summary',
                    'type' => 'textarea',
                    'rows' => 3,
                    'instructions' => 'Short summary shown on archive listings and meta tags.',
                    'new_lines' => '',
                ],
                // Add additional fields here. Field keys must stay unique within
                // the field group — prefix with field_${snake}_.
            ],
            'location' => [[
                ['param' => 'post_type', 'operator' => '==', 'value' => self::SLUG],
            ]],
        ]);
    }
}
`;

const singleTemplate = `@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article @php(post_class('${kebab}-single'))>
      <header class="${kebab}-single__header">
        <h1 class="${kebab}-single__title">{{ get_the_title() }}</h1>

        @if ($summary = get_field('summary'))
          <p class="${kebab}-single__summary">{{ $summary }}</p>
        @endif
      </header>

      @if (has_post_thumbnail())
        <div class="${kebab}-single__media">
          <x-image :image="get_post_thumbnail_id()" loading="eager" sizes="(min-width: 1024px) 80vw, 100vw" />
        </div>
      @endif

      <div class="${kebab}-single__content">
        @php(the_content())
      </div>
    </article>
  @endwhile
@endsection
`;

const archiveTemplate = `@extends('layouts.app')

@section('content')
  <header class="${kebab}-archive__header">
    <h1>{{ post_type_archive_title('', false) }}</h1>
  </header>

  @if (have_posts())
    <ul class="${kebab}-archive" role="list">
      @while(have_posts()) @php(the_post())
        @include('partials.content-${kebab}')
      @endwhile
    </ul>

    {!! get_the_posts_navigation() !!}
  @else
    <p class="${kebab}-archive__empty">{{ __('No ${plural.toLowerCase()} yet.', 'sage') }}</p>
  @endif
@endsection
`;

const contentPartial = `<li class="${kebab}-archive__item">
  <article>
    @if (has_post_thumbnail())
      <a href="{{ get_permalink() }}" class="${kebab}-archive__media">
        <x-image :image="get_post_thumbnail_id()" sizes="(min-width: 768px) 50vw, 100vw" />
      </a>
    @endif

    <h2 class="${kebab}-archive__title">
      <a href="{{ get_permalink() }}">{{ get_the_title() }}</a>
    </h2>

    @if ($summary = get_field('summary'))
      <p class="${kebab}-archive__summary">{{ $summary }}</p>
    @endif
  </article>
</li>
`;

const scssPartial = `@use "../abstracts" as *;

.${kebab}-archive {
  @include container;

  display: grid;
  gap: $space-8;
  list-style: none;
  margin: 0;
  padding: 0;

  @include respond-to(md) {
    grid-template-columns: repeat(2, 1fr);
  }

  &__header {
    @include container;

    padding-block: $space-12 $space-8;
  }

  &__item {
    display: flex;
    flex-direction: column;
    gap: $space-3;
  }

  &__media {
    aspect-ratio: 16 / 9;
    overflow: hidden;
    border-radius: $radius-md;
    background: var(--color-bg-muted);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__title {
    font-size: $text-xl;
    margin: 0;

    a {
      color: var(--color-fg);
      text-decoration: none;
    }
  }

  &__summary {
    color: var(--color-muted);
    margin: 0;
  }

  &__empty {
    @include container;

    color: var(--color-muted);
  }
}
`;

const pestTest = `<?php

/*
 * ${pascal} CPT registration test.
 *
 * Verifies the post type registers with the expected slug and that the
 * ACF field group binds to it. Add new field assertions as you extend
 * registerFields().
 */

use App\\PostTypes\\${pascal};
use Brain\\Monkey\\Functions;

it('registers the ${kebab} post type', function (): void {
    Functions\\expect('__')->andReturnFirstArg();
    Functions\\expect('register_post_type')
        ->once()
        ->with('${kebab}', Mockery::on(function (array $args): bool {
            expect($args)
                ->toHaveKey('public', true)
                ->toHaveKey('has_archive', true)
                ->toHaveKey('show_in_rest', true);
            expect($args['supports'])->toContain('title', 'editor', 'thumbnail');
            expect($args['rewrite']['slug'])->toBe('${kebab}');
            return true;
        }));

    ${pascal}::register();

    expect(true)->toBeTrue();
});

it('registers an ACF field group bound to the post type', function (): void {
    Functions\\expect('acf_add_local_field_group')
        ->once()
        ->with(Mockery::on(function (array $group): bool {
            expect($group['key'])->toBe('group_post_type_${snake}');
            expect($group['location'][0][0])->toBe([
                'param' => 'post_type',
                'operator' => '==',
                'value' => '${kebab}',
            ]);
            return true;
        }));

    ${pascal}::registerFields();

    expect(true)->toBeTrue();
});
`;

// ---- Write files -----------------------------------------------------------

const targets = [
  { root: themeRoot, path: `app/PostTypes/${pascal}.php`, contents: phpClass },
  { root: themeRoot, path: `resources/views/single-${kebab}.blade.php`, contents: singleTemplate },
  { root: themeRoot, path: `resources/views/archive-${kebab}.blade.php`, contents: archiveTemplate },
  { root: themeRoot, path: `resources/views/partials/content-${kebab}.blade.php`, contents: contentPartial },
  { root: themeRoot, path: `resources/scss/components/_${kebab}-archive.scss`, contents: scssPartial },
  { root: projectRoot, path: `tests/Theme/PostTypes/${pascal}Test.php`, contents: pestTest },
];

const created = [];
const skipped = [];

for (const { root, path, contents } of targets) {
  const full = resolve(root, path);
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
const forwardLine = `@forward "${kebab}-archive";\n`;
let componentsIndexUpdated = false;
if (!componentsIndexContents.includes(forwardLine.trim())) {
  writeFileSync(componentsIndex, componentsIndexContents + forwardLine);
  componentsIndexUpdated = true;
}

// ---- Mutate app/setup.php --------------------------------------------------

const setupPath = resolve(themeRoot, 'app/setup.php');
const setupContents = readFileSync(setupPath, 'utf8');
const marker = '// {{ make:cpt insertion point — do not remove }}';
const cptEntry = `\\App\\PostTypes\\${pascal}::class,`;
let setupUpdated = false;
if (!setupContents.includes(marker)) {
  console.warn(
    `[make:cpt] WARNING: marker "${marker}" not found in app/setup.php — add the registration line manually:`,
  );
  console.warn(`             ${cptEntry}`);
} else if (setupContents.includes(cptEntry)) {
  // already registered, nothing to do
} else {
  const updated = setupContents.replace(marker, `${cptEntry}\n    ${marker}`);
  writeFileSync(setupPath, updated);
  setupUpdated = true;
}

// ---- Report ----------------------------------------------------------------

console.log(`\n[make:cpt] ${kebab} (${singular} / ${plural})`);
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
console.log('    2. ddev composer lint:fix && ddev composer analyse && ddev composer test');
console.log('    3. flush rewrites: ddev wp rewrite flush');
console.log(`    4. visit /${kebab}/ and the admin → ${plural}`);
