#!/usr/bin/env node
/**
 * Bridge SCSS design tokens into theme.json.
 *
 * Reads `resources/scss/abstracts/_variables.scss` and emits matching
 * settings into `theme.json`:
 *   - settings.color.palette    ← semantic + neutral + accent tokens
 *   - settings.spacing.spacingSizes ← $space-* scale
 *   - settings.typography.fontSizes ← $text-* scale
 *
 * Run via `npm run prebuild` (auto-fired before `vite build`) or directly.
 * SCSS variables remain the source of truth — this script writes derived
 * config into theme.json so the WordPress editor's color/spacing pickers
 * and font-size dropdown match the SCSS scale.
 */

import { readFileSync, writeFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, resolve } from 'node:path';
import { format } from 'prettier';

const here = dirname(fileURLToPath(import.meta.url));
const themeRoot = resolve(here, '..');
const VARS_PATH = resolve(themeRoot, 'resources/scss/abstracts/_variables.scss');
const THEME_JSON_PATH = resolve(themeRoot, 'theme.json');

// Match `$name: value;` (single line). Captures trailing-comment-stripped value.
const SCALAR_RE = /^\s*\$([a-z0-9][a-z0-9_-]*?)\s*:\s*([^;]+?)\s*;\s*(?:\/\/.*)?$/gim;

function parseTokens(scss) {
  const tokens = {};
  for (const match of scss.matchAll(SCALAR_RE)) {
    const [, name, raw] = match;
    let value = raw.trim();
    // Resolve simple aliases ($foo). Multi-step aliasing is fine — we make
    // multiple passes below.
    tokens[name] = value;
  }
  // Resolve aliases (up to 5 passes — enough for our two-layer system)
  for (let pass = 0; pass < 5; pass++) {
    let changed = false;
    for (const [name, value] of Object.entries(tokens)) {
      if (value.startsWith('$')) {
        const ref = value.slice(1);
        if (tokens[ref] && tokens[ref] !== value) {
          tokens[name] = tokens[ref];
          changed = true;
        }
      }
    }
    if (!changed) break;
  }
  return tokens;
}

function pick(tokens, names) {
  return names
    .filter((n) => tokens[n] !== undefined)
    .map((n) => [n, tokens[n]]);
}

function titleCase(slug) {
  return slug
    .split(/[-_]/)
    .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
    .join(' ');
}

function buildColorPalette(tokens) {
  const palette = [];

  // Semantic colors — listed explicitly so editor pickers show meaningful names
  const semantics = [
    ['fg', 'Foreground'],
    ['fg-strong', 'Foreground Strong'],
    ['bg', 'Background'],
    ['bg-subtle', 'Background Subtle'],
    ['bg-muted', 'Background Muted'],
    ['muted', 'Muted'],
    ['muted-soft', 'Muted Soft'],
    ['border', 'Border'],
    ['border-strong', 'Border Strong'],
    ['accent', 'Accent'],
    ['accent-fg', 'Accent Foreground'],
  ];
  for (const [slug, name] of semantics) {
    const value = tokens[`color-${slug}`];
    if (value) {
      palette.push({ slug: `color-${slug}`, name, color: value });
    }
  }

  // Primitive scales
  for (const [name] of pick(tokens, [
    'neutral-0', 'neutral-50', 'neutral-100', 'neutral-200', 'neutral-300',
    'neutral-400', 'neutral-500', 'neutral-600', 'neutral-700', 'neutral-800',
    'neutral-900', 'neutral-950',
  ])) {
    palette.push({ slug: name, name: titleCase(name), color: tokens[name] });
  }
  for (const [name] of pick(tokens, [
    'accent-50', 'accent-100', 'accent-200', 'accent-300', 'accent-400',
    'accent-500', 'accent-600', 'accent-700', 'accent-800', 'accent-900',
    'accent-950',
  ])) {
    palette.push({ slug: name, name: titleCase(name), color: tokens[name] });
  }

  return palette;
}

function buildSpacingSizes(tokens) {
  const slugs = [
    'space-1', 'space-2', 'space-3', 'space-4', 'space-5', 'space-6',
    'space-8', 'space-10', 'space-12', 'space-16', 'space-20', 'space-24',
    'space-32', 'space-40', 'space-48',
  ];
  return slugs
    .filter((s) => tokens[s])
    .map((slug) => ({ slug, name: titleCase(slug), size: tokens[slug] }));
}

function buildFontSizes(tokens) {
  const slugs = [
    'text-xs', 'text-sm', 'text-base', 'text-lg', 'text-xl',
    'text-2xl', 'text-3xl', 'text-4xl', 'text-5xl', 'text-6xl',
  ];
  return slugs
    .filter((s) => tokens[s])
    .map((slug) => ({
      slug: slug.replace(/^text-/, ''),
      name: slug.replace(/^text-/, '').toUpperCase(),
      size: tokens[slug],
    }));
}

// ---- Run --------------------------------------------------------------------

const scss = readFileSync(VARS_PATH, 'utf8');
const tokens = parseTokens(scss);

const palette = buildColorPalette(tokens);
const spacingSizes = buildSpacingSizes(tokens);
const fontSizes = buildFontSizes(tokens);

const themeJson = JSON.parse(readFileSync(THEME_JSON_PATH, 'utf8'));

themeJson.settings ??= {};
themeJson.settings.color ??= {};
themeJson.settings.color.palette = palette;
themeJson.settings.spacing ??= {};
themeJson.settings.spacing.spacingSizes = spacingSizes;
themeJson.settings.typography ??= {};
themeJson.settings.typography.fontSizes = fontSizes;

themeJson.__preprocessed__ =
  'Generated from resources/scss/abstracts/_variables.scss by scripts/build-theme-json.mjs. Run `npm run build` (or `npm run prebuild`) to regenerate.';

const formatted = await format(JSON.stringify(themeJson), {
  parser: 'json',
  filepath: THEME_JSON_PATH,
});
writeFileSync(THEME_JSON_PATH, formatted);

console.log(
  `[build-theme-json] wrote theme.json — ${palette.length} colors, ${spacingSizes.length} spacing sizes, ${fontSizes.length} font sizes`,
);
