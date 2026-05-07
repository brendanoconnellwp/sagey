<?php

/*
 * Hero block render — verifies the block class hands the right data to the
 * Blade view. Demonstrates the canonical block test pattern: mock get_field
 * with brain/monkey, mock view() to capture what was passed, assert on the
 * data array.
 *
 * Copy this file when adding a new block (the make:block scaffolding does
 * this automatically). Update field expectations and assertions for the
 * fields the new block declares.
 */

use App\Blocks\Hero;
use Brain\Monkey\Functions;

it('passes ACF fields to the blocks.hero view', function (): void {
    Functions\expect('get_field')
        ->andReturnUsing(fn(string $name) => match ($name) {
            'heading' => 'Welcome',
            'subheading' => 'A short subhead',
            'button_text' => 'Get started',
            'button_url' => 'https://example.test',
            'alignment' => 'center',
            default => null,
        });

    mockView('blocks.hero', function (array $data): void {
        expect($data)
            ->toHaveKey('heading', 'Welcome')
            ->toHaveKey('subheading', 'A short subhead')
            ->toHaveKey('button_text', 'Get started')
            ->toHaveKey('button_url', 'https://example.test')
            ->toHaveKey('alignment', 'center')
            ->toHaveKey('block')
            ->toHaveKey('is_preview', false);
    });

    ob_start();
    Hero::render(['name' => 'acf/hero'], '', false, 0);
    ob_end_clean();
});

it('coerces null ACF returns to empty strings', function (): void {
    Functions\expect('get_field')->andReturn(null);

    mockView('blocks.hero', function (array $data): void {
        expect($data['heading'])->toBe('');
        expect($data['subheading'])->toBe('');
        expect($data['button_text'])->toBe('');
        expect($data['button_url'])->toBe('');
        // alignment defaults to 'center' when get_field returns falsy
        expect($data['alignment'])->toBe('center');
    });

    ob_start();
    Hero::render([], '', false, 0);
    ob_end_clean();
});

it('registers a block on init', function (): void {
    Functions\expect('get_theme_file_path')
        ->once()
        ->with('resources/blocks/hero/block.json')
        ->andReturn('/dev/null/block.json');

    Functions\expect('register_block_type')
        ->once()
        ->with('/dev/null/block.json');

    Hero::register();

    // Brain Monkey expectations validate on tearDown; this assertion just
    // signals to Pest that the test wasn't risky.
    expect(true)->toBeTrue();
});
