<?php

/*
|--------------------------------------------------------------------------
| Pest configuration
|--------------------------------------------------------------------------
|
| Tests under `tests/Theme/` get Brain Monkey wired automatically — gives
| us mocked WordPress + ACF functions without booting WordPress. Use this
| for fast unit tests of theme code (block renderers, view composers,
| filters). Slow integration tests should live elsewhere.
|
| https://brain-wp.github.io/BrainMonkey/
|
*/

use Brain\Monkey;

uses()
    ->beforeEach(function (): void {
        Monkey\setUp();
    })
    ->afterEach(function (): void {
        Monkey\tearDown();
    })
    ->in('Theme');

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

/**
 * Render a view file's raw output (without booting Acorn/Blade).
 *
 * Used by block render tests — the canonical render() method calls
 * `view('blocks.{name}', [...])->render()`. We mock that view() call
 * so tests focus on the block class's data preparation, not Blade.
 */
function mockView(string $expected, ?callable $assertData = null): void
{
    Monkey\Functions\expect('view')
        ->once()
        ->withArgs(function (string $view, array $data) use ($expected, $assertData): bool {
            if ($view !== $expected) {
                return false;
            }
            if ($assertData) {
                $assertData($data);
            }
            return true;
        })
        ->andReturn(new class {
            public function render(): string
            {
                return '';
            }
        });
}
