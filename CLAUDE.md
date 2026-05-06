# Sagey — project root

WordPress site on **Bedrock** + **Sage 11**, configured for agentic development. The interesting code lives in the theme; this file orients you at the project root.

## Layout

```
/home/br_oc/projects/sagey/
├── composer.json, composer.lock     # PHP dependencies (WP core, plugins, theme)
├── auth.json                        # ACF Pro Composer credentials — gitignored
├── .env, .env.example               # Runtime env (WP_HOME, DB, ACF_PRO_LICENSE)
├── .ddev/                           # Local container config — generally don't edit
├── .claude/
│   ├── skills/                      # openskills WordPress skill pack (15 skills)
│   └── settings.local.json          # Per-session permission allowlist
├── config/
│   ├── application.php              # Bedrock site config (Config::define + env())
│   └── environments/                # WP_ENV-keyed overrides
├── web/                             # ★ docroot — points DDEV/nginx here
│   ├── wp/                          # WP core (Composer-managed; DO NOT edit)
│   ├── wp-config.php                # bootstraps Bedrock config — DO NOT edit
│   └── app/                         # WP "wp-content" (renamed via Bedrock)
│       ├── plugins/                 # Composer-installed (gitignored)
│       ├── mu-plugins/              # bedrock-autoloader + Composer-installed (dirs gitignored)
│       ├── themes/
│       │   ├── sagey/               # ← active theme; see web/app/themes/sagey/CLAUDE.md
│       │   └── twentytwentyfive/    # fallback (gitignored)
│       └── uploads/                 # gitignored
└── tests/                           # Pest
```

**Where to look:**
- Anything about Blade, SCSS, ACF blocks, theme commands → `web/app/themes/sagey/CLAUDE.md`
- Anything about Bedrock structure, plugins, env, DDEV, deployment → here
- WordPress-core mechanics (REST, blocks, WP-CLI, performance) → `.claude/skills/wp-*`

## Local environment — DDEV only

The host has no PHP and no Composer; both run inside the DDEV web container. **Always prefix with `ddev`:**

```bash
ddev describe                              # container status, URLs, ports
ddev composer require <vendor/package>     # add a PHP dependency (root composer.json)
ddev composer remove <vendor/package>
ddev wp <args>                             # WP-CLI inside the container
ddev exec <cmd>                            # arbitrary shell in the web container
ddev restart                               # picks up .env / config changes
```

Site URL: `https://sagey.ddev.site` (DDEV-managed; do NOT hardcode).

PHP 8.4, Node 24, MariaDB 11.8.

## Plugins — Composer only, never wp-admin

Bedrock pins WP, plugins, and themes through Composer; `web/app/plugins/*` is gitignored. Two repositories are wired up in `composer.json`:

| Repo | URL | What it serves |
|---|---|---|
| `wp-packages` | `https://repo.wp-packages.org` | `wp-plugin/*`, `wp-theme/*` (free WordPress.org plugins/themes) |
| `acf-pro` | `https://connect.advancedcustomfields.com` | `wpengine/advanced-custom-fields-pro` only — auth via `auth.json` |

```bash
# Free plugin from wordpress.org (mirrored on wp-packages.org)
ddev composer require wp-plugin/wp-mail-smtp

# Activate via WP-CLI (do NOT use the wp-admin UI)
ddev wp plugin activate wp-mail-smtp
```

## Env and config

Two layers:

1. **`.env`** — secrets and per-environment values (DB, salts, `WP_HOME`, `ACF_PRO_LICENSE`). Loaded by `vlucas/phpdotenv` from `config/application.php`. **Gitignored.**
2. **`config/application.php`** — declares which env vars become WP constants via `Config::define()`. This is the only place to declare new constants; never `define()` directly.

To add a new constant:

```php
// in .env
MY_FEATURE_FLAG=true

// in config/application.php (already imports use function Env\env;)
Config::define('MY_FEATURE_FLAG', env('MY_FEATURE_FLAG'));
```

Per-environment overrides go in `config/environments/{development,staging,production}.php`.

## ACF Pro license

Lives in two places — both required:

- **`auth.json`** — Composer HTTP-basic credentials (`connect.advancedcustomfields.com`, username = license key, password = site URL). Gitignored. Used at `composer install` / `require` time to download the plugin.
- **`.env` → `ACF_PRO_LICENSE`** — runtime activation, surfaced as a constant in `config/application.php`.

**Custom Blocks require ACF Pro.** The Free plugin does not provide block rendering. Switching to Free will leave blocks "registered" but with `render_callback = NULL`.

To rotate the license: regenerate in the wpengine.com customer portal, update both `auth.json` and `.env`, restart DDEV.

## Critical rules

1. **Never** edit anything under `web/wp/` — Composer-managed WordPress core. Lost on `composer install`.
2. **Never** edit `web/wp-config.php` — re-run by Bedrock; site config goes in `config/application.php`.
3. **Never** install plugins or themes via wp-admin. They land in a gitignored directory and disappear.
4. **Never** run `composer` or `php` directly on the host — use `ddev composer` / `ddev wp eval-file` / `ddev exec`.
5. **Never** commit `auth.json`, `.env`, `web/app/plugins/*`, `web/app/uploads/*`, `web/wp/`. All gitignored — but check before `git add -A`.
6. **Never** add `web/check-*.php` debug scripts to commits. Write them to `/tmp/`, copy in, run, delete.
7. **Never** push to a shared branch without confirmation. Default is to commit locally.

## Quality gates

CI (`.github/workflows/ci.yml`) and pre-commit (`lefthook.yml`) enforce the same set of checks. Pre-commit is a fast local mirror of CI; CI is the contract.

| Tool | Scope | Run locally |
|---|---|---|
| **Pint** (PSR-12 +) | All `.php` not under excludes (see `pint.json`) | `ddev composer lint:php` / `ddev composer lint:fix` |
| **PHPStan** (level 5) | `web/app/themes/sagey/app` | `ddev composer analyse` |
| **Pest** | `tests/` | `ddev composer test` |
| **Stylelint** (config-standard-scss + BEM pattern) | `resources/scss/**/*.scss` | `ddev exec --dir /var/www/html/web/app/themes/sagey npm run lint:css` |
| **ESLint** (v9 flat config + recommended) | `resources/js/**/*.js` + `*.config.js` | `npm run lint:js` |
| **Prettier** | SCSS/JS/JSON | `npm run format:check` / `npm run format` |

**Run everything at once:**
```bash
ddev composer lint && \
ddev exec --dir /var/www/html/web/app/themes/sagey npm run lint && \
ddev exec --dir /var/www/html/web/app/themes/sagey npm run build
```

### Pre-commit (Lefthook)

Hooks are wired through `lefthook.yml`. To activate locally (one-time per clone):

```bash
brew install lefthook    # or: npm i -g lefthook  (https://lefthook.dev)
lefthook install
```

Hooks invoke `ddev exec` for everything, so DDEV must be running for commits to pass. Bypass with `git commit --no-verify` when needed (and explain why in the message).

### CI

`.github/workflows/ci.yml` runs on push to `main` and on every PR. Two parallel jobs:
- **PHP** — composer install (uses `ACF_PRO_KEY` repo secret for Pro download), Pint, PHPStan, Pest
- **Frontend** — npm ci, Stylelint, ESLint, Prettier, Vite build

**Required secret:** `ACF_PRO_KEY` (license key only) in repo settings → Secrets and variables → Actions. Without it, CI's PHP job will warn and skip ACF Pro install.

## Common workflows

### Add a Composer-managed plugin

```bash
ddev composer require wp-plugin/<name>
ddev wp plugin activate <name>
```

### Run an ad-hoc PHP diagnostic

```bash
# wp eval-file requires the script live under the project, not /tmp.
# Convention: write to /tmp/check.php, copy to web/, run, delete.
cp /tmp/check.php web/check.php && ddev wp eval-file web/check.php; rm web/check.php
```

### Rebuild the theme

```bash
ddev exec --dir /var/www/html/web/app/themes/sagey npm run build
```

### Lint PHP

```bash
ddev composer lint        # Pint --test
ddev composer lint:fix
```

### Run tests

```bash
ddev composer test        # Pest
```

## Agent skills

Project-scoped skills live under `.claude/skills/` (openskills WordPress pack). They auto-load when relevant. Heads-up: many assume native Gutenberg / FSE / `@wordpress/scripts` workflows that this project deliberately does not use — use the **theme's CLAUDE.md ACF-Pro-Block-via-Blade pattern** as the primary authority and consult the skills for underlying WP-core mechanics.

## Deployment

Most recent baseline commit: "Restructure to Bedrock for production deployment". The structural pieces (gitignored plugins/uploads, env-driven config, separate web docroot) are in place; specific host wiring (Trellis / WP Engine / SpinupWP / etc.) hasn't been chosen yet. Decide before adding host-specific shims.
