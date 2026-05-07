<?php

/*
 * Test bootstrap.
 *
 * Loads the root Composer autoloader (Pest, Brain Monkey, stubs) and the
 * theme's Composer autoloader (Acorn, App\ namespace under web/app/themes/sagey/app).
 * Tests under tests/Theme/ exercise theme code, so its autoloader must
 * be on the chain.
 */

declare(strict_types=1);

$root = dirname(__DIR__);

// Patchwork must load BEFORE any code that defines functions we want to mock —
// notably Acorn's view() helper. Brain Monkey relies on Patchwork to redefine
// global functions at runtime. Loading it first lets us mock view() etc.
require $root . '/vendor/antecedent/patchwork/Patchwork.php';

require $root . '/vendor/autoload.php';

$themeAutoload = $root . '/web/app/themes/sagey/vendor/autoload.php';
if (file_exists($themeAutoload)) {
    require $themeAutoload;
} else {
    fwrite(
        STDERR,
        "[bootstrap] theme autoloader missing — run `composer install` in web/app/themes/sagey first.\n",
    );
    exit(1);
}
