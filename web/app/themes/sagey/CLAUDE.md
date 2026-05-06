# Sagey — Sage 11 theme on Bedrock

## What this is

A **code-first** WordPress build deliberately structured for agentic development:

- Bedrock at the project root (`/home/br_oc/projects/sagey/`); this theme lives at `web/app/themes/sagey/`.
- Sage 11 + Acorn 5 (Laravel container in WP), Blade templates, Vite 7.
- **SCSS** (sass-embedded) — not Tailwind. Tailwind was removed deliberately.
- **ACF Pro Blocks** rendered via Blade — not native Gutenberg block authoring (no JS edit.js, no JSX).
- Local dev via **DDEV** (PHP 8.4, Node 24). PHP and Composer are not on the host — always go through `ddev`.
- Block themes / FSE are **off** (`remove_theme_support('block-templates')` in `app/setup.php`). All templating lives in `resources/views/`.

## Commands

All commands run from the project root unless noted.

```bash
# PHP / Composer
ddev composer require <pkg>
ddev composer remove <pkg>
ddev wp <wp-cli args>

# Theme JS / build (from inside the container, theme dir)
ddev exec --dir /var/www/html/web/app/themes/sagey npm install
ddev exec --dir /var/www/html/web/app/themes/sagey npm run build
ddev exec --dir /var/www/html/web/app/themes/sagey npm run dev   # Vite dev w/ HMR

# Lint
ddev composer lint        # Pint --test (project root)
ddev composer lint:fix
```

Site URL: `https://sagey.ddev.site` (do NOT hardcode this anywhere — use `home_url()`).

## Critical rules

1. **Never** edit `public/build/` — Vite-generated; will be wiped.
2. **Never** put logic in `functions.php`. Use `app/setup.php`, `app/filters.php`, or new classes under `app/` (PSR-4 → `App\`).
3. **Never** use `@import` in SCSS — use `@use` / `@forward`. `@import` is deprecated and slated for removal.
4. **Never** add Tailwind back without explicit instruction; the styling answer is always SCSS.
5. **Never** echo HTML directly from PHP. Use Blade. Always escape: `{{ $var }}` for data, `{!! $html !!}` only for trusted WP core output.
6. **Never** enable ACF JSON sync (`acf-json/`). Field groups are PHP-registered next to their blocks under `app/Blocks/{Name}.php` so the schema stays in version control.
7. **Never** install plugins via wp-admin. Always `ddev composer require wp-plugin/<name>` (Bedrock workflow). Plugins under `web/app/plugins/*` are gitignored.
8. **Never** commit `auth.json` or `.env` — already gitignored. ACF Pro license lives in both (auth.json for Composer downloads, `.env` → `ACF_PRO_LICENSE` for runtime activation).
9. **Always** prefer Blade-rendered ACF Pro Blocks over hand-rolled native Gutenberg blocks. ACF Free does NOT support custom blocks — that's a Pro feature.

## File structure (only the parts that matter)

```
web/app/themes/sagey/
├── app/                              # PSR-4: App\
│   ├── Blocks/                       # One class per ACF block (register + fields + render)
│   │   └── Hero.php
│   ├── Providers/ThemeServiceProvider.php
│   ├── View/Composers/               # Auto-discovered, inject vars into Blade views
│   ├── setup.php                     # Theme supports, menus, sidebars, block registration
│   └── filters.php                   # WP filters
├── resources/
│   ├── blocks/                       # ACF block.json files (one dir per block)
│   │   └── hero/block.json
│   ├── scss/                         # SCSS sources — see "SCSS" below
│   ├── views/
│   │   ├── blocks/                   # Blade views for ACF blocks (one .blade.php per block)
│   │   ├── layouts/app.blade.php     # Master layout
│   │   ├── sections/                 # header.blade.php, footer.blade.php
│   │   ├── partials/                 # Content partials (auto-routed via @includeFirst)
│   │   ├── components/               # <x-name> Blade components
│   │   └── *.blade.php               # WP template hierarchy (page, single, index, search, 404, template-*)
│   ├── js/{app,editor}.js
│   ├── fonts/, images/               # Auto-globbed by app.js
│   └── lang/
├── public/build/                     # Vite output — DO NOT EDIT
├── functions.php                     # Boot only — no logic
├── style.css                         # Theme metadata only
├── theme.json                        # Source; preprocessed into public/build/assets/theme.json
└── vite.config.js
```

## SCSS

Sass module syntax (`@use`/`@forward`). Tree:

```
resources/scss/
├── app.scss                  # @use abstracts; @use base; @use layouts; @use components;
├── editor.scss               # block-editor styles
├── abstracts/
│   ├── _variables.scss       # SCSS tokens — primitives + semantic aliases
│   ├── _tokens.scss          # mirrors variables to :root CSS custom properties
│   ├── _mixins.scss          # respond-to, container, focus-ring, visually-hidden
│   └── _index.scss           # @forward variables, mixins, tokens
├── base/                     # _reset, _typography, _index
├── layouts/                  # _container, _header, _footer, _index
└── components/               # _button, _hero, _index — one partial per UI thing
```

### Design tokens (dual-layer)

Tokens are defined **once** in `abstracts/_variables.scss` (Sass scalars) and **mirrored** to `:root` CSS custom properties by `abstracts/_tokens.scss`. SCSS variables are the source of truth.

**Two layers of tokens:**

- **Primitive tokens** — raw scales:
  - Color: `$neutral-0…$neutral-950`, `$accent-50…$accent-950`
  - Spacing: `$space-0`, `$space-px`, `$space-0_5`, `$space-1`…`$space-48`
  - Type: `$text-xs`…`$text-6xl`, `$leading-{none,tight,snug,normal,relaxed,loose}`
  - Radius: `$radius-{none,sm,md,lg,xl,2xl,full}`
  - Shadows: `$shadow-{sm,md,lg,xl}`
  - Motion: `$duration-{fast,base,slow}`, `$ease-{out,in-out}`
  - Z-index: `$z-{base,raised,dropdown,sticky,overlay,modal,toast}`
  - Layout: `$container-{narrow,width,wide}`, `$container-padding`
  - Breakpoints: `$bp-{sm,md,lg,xl}` — **SCSS only**, can't be CSS custom properties (media queries don't accept them)

- **Semantic tokens** — the component API; alias to primitives:
  - Surface: `$color-bg`, `$color-bg-subtle`, `$color-bg-muted`
  - Text: `$color-fg`, `$color-fg-strong`, `$color-muted`, `$color-muted-soft`
  - Borders: `$color-border`, `$color-border-strong`
  - Accent: `$color-accent`, `$color-accent-fg`, `$color-accent-hover`
  - Type: `$font-sans`, `$font-mono`, `$font-heading`, `$font-body`

**Brand changes happen at the semantic layer** — to rebrand, edit `$color-accent` (or point it at `$accent-600` instead of `$neutral-950`); leave primitives alone.

### When to use SCSS variable vs CSS custom property

- **In SCSS partials** — prefer `$color-fg`. Compile-time, supports Sass color functions (e.g. `color.adjust($color-accent, $lightness: 5%)`), survives static analysis.
- **In runtime contexts** (block editor JS, dark-mode toggle, theme.json bridge, ad-hoc inline styles) — use `var(--color-fg)`. Same value, queryable and overridable at runtime.
- **Components default to SCSS variables** — drop down to `var(--token)` only when runtime override is the actual goal.

### Adding a new token

1. Declare in `abstracts/_variables.scss` (in the right section — primitive or semantic).
2. Mirror in `abstracts/_tokens.scss` — `--my-token: #{$my-token};` inside `:root`.
3. Done — both `$my-token` and `var(--my-token)` are available.

Skip step 2 only for breakpoints (don't work in `@media`) and SCSS-only constructs.

### SCSS rules

- One partial per component, named after it. Use BEM (`.hero`, `.hero__inner`, `.hero--align-center`).
- Import shared tokens with `@use '../abstracts' as *;` — gives flat access to variables and mixins.
- Breakpoints: use the `respond-to($name)` mixin (`sm`/`md`/`lg`/`xl`), not raw media queries.
- Container widths: use the `container($width)` mixin or `.container` / `.container--narrow` / `.container--wide` classes.
- **Never hardcode** hex/px/rem values when a token exists. If no token fits, add one (see above) — don't reach for raw values.
- No CSS-in-PHP, no inline `style="..."`, no `<style>` blocks in Blade.

## ACF Pro Block pattern (canonical: Hero)

Every block has **four files**:

```
app/Blocks/Hero.php                    # PHP: register + fields + render
resources/blocks/hero/block.json       # block metadata; ACF renderCallback points to Hero::render
resources/views/blocks/hero.blade.php  # the actual HTML
resources/scss/components/_hero.scss   # styles, forwarded by components/_index.scss
```

Registration (in `app/setup.php`):

```php
add_action('init', fn () => \App\Blocks\Hero::register());
add_action('acf/init', fn () => \App\Blocks\Hero::registerFields());
```

The Hero block is the canonical example. To add a new block, copy its four files, rename, and adjust fields. Do not invent a new pattern.

### Block render method

```php
public static function render($block, $content = '', $is_preview = false, $post_id = 0): void
{
    echo view('blocks.{name}', [
        'block' => $block,
        'is_preview' => $is_preview,
        // Pull each ACF field with a safe default — never rely on get_field() returning the right shape
        'heading' => get_field('heading') ?: '',
        // ...
    ])->render();
}
```

### Why this pattern

- Field schema lives next to the block code in PHP (no `acf-json/` sync; no out-of-band JSON files).
- Blade view is the single source of markup; SCSS partial is the single source of styles.
- Adding a block = 4 files + 2 lines in setup.php. Removing a block = delete those files. Easy to grep, easy to diff.

### ACF Pro setup gotchas

- **License lives in two places**: `auth.json` (Composer download auth — username = key, password = site URL) and `ACF_PRO_LICENSE` env var (read in `config/application.php` → `Config::define('ACF_PRO_LICENSE', ...)` for runtime activation). Both are required.
- The Composer package is `wpengine/advanced-custom-fields-pro`, served from the private repo `https://connect.advancedcustomfields.com` (already configured in root `composer.json`).
- Custom Blocks **require ACF Pro**. The Free plugin (`wp-plugin/advanced-custom-fields`) registers fields fine but provides no block rendering — the block will appear registered yet have a NULL render_callback.

## Blade conventions

- Every page template `@extends('layouts.app')` and defines `@section('content')`.
- Loop guard: `@while(have_posts()) @php(the_post()) ... @endwhile`.
- Reusable UI: `<x-{name}>` components in `resources/views/components/`. Use `@props([...])`.
- Page sections (header/footer/sidebar) in `resources/views/sections/` — included from the layout.
- View Composers (auto-discovered under `app/View/Composers/`) inject data — keep DB queries out of Blade.

## DO NOT

1. Hardcode `https://sagey.ddev.site` — use `home_url()`, `get_permalink()`, `Vite::asset()`.
2. Commit `web/app/plugins/*` (gitignored — plugins are Composer-managed).
3. Reintroduce Tailwind, FSE, block.json + JSX block authoring, or `acf-json/` without explicit user direction. Each was deliberately rejected.
4. Use `get_template_directory_uri()` for assets — use `Vite::asset('resources/...')`.
5. Run `composer` or `npm` outside of `ddev` — host PHP isn't installed.

## Verification after changes

```bash
ddev exec --dir /var/www/html/web/app/themes/sagey npm run build
```

Check:
- `public/build/manifest.json` lists `resources/scss/app.scss` and `resources/scss/editor.scss` as entries with `.css` outputs.
- For block changes: `ddev wp eval 'var_dump(WP_Block_Type_Registry::get_instance()->is_registered("sage/{name}"));'` returns `bool(true)`.
- Page loads at `https://sagey.ddev.site/` without errors.

## Agent skills available

This project ships with the openskills WordPress skill pack at `.claude/skills/`:

- `wp-block-development` — block.json, dynamic rendering, attributes
- `wp-rest-api`, `wp-wpcli-and-ops`, `wp-performance`, `wp-phpstan`
- `wp-abilities-api`, `wp-interactivity-api`, `wp-playground`, `wp-block-themes`
- `wp-plugin-development`, `wp-plugin-directory-guidelines`
- `wp-project-triage`, `wordpress-router`, `wpds`, `blueprint`

These auto-load when relevant. Caveat: many target native Gutenberg / FSE workflows that this project explicitly does not use. Apply the **ACF Pro Block + Blade** pattern above first; consult the skills for underlying WP-core mechanics, REST shape, WP-CLI, performance, etc.

## Background reading

- The "why Sage+Bedrock instead of FSE" decision is recorded in user-level project memory; this project is a deliberate bet on code-first templating for agentic development.
- The Hero block was the canonical first block; replicate its pattern.
