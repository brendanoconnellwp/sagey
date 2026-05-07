<?php

/*
 * CardGrid block render test.
 *
 * Verifies the block forwards heading, columns choice, and the cards
 * repeater to the blocks.card-grid Blade view. Also covers the column
 * whitelist (must default to '3' when ACF returns something unexpected).
 */

use App\Blocks\CardGrid;
use Brain\Monkey\Functions;

it('passes ACF fields including the cards repeater to the view', function (): void {
    $sampleCards = [
        ['title' => 'First', 'body' => 'One', 'image' => null, 'link_text' => '', 'link_url' => ''],
        ['title' => 'Second', 'body' => 'Two', 'image' => null, 'link_text' => 'More', 'link_url' => 'https://example.test'],
    ];

    Functions\expect('get_field')
        ->andReturnUsing(fn(string $name) => match ($name) {
            'heading' => 'Our services',
            'columns' => '4',
            'cards' => $sampleCards,
            default => null,
        });

    mockView('blocks.card-grid', function (array $data) use ($sampleCards): void {
        expect($data)
            ->toHaveKey('heading', 'Our services')
            ->toHaveKey('columns', '4')
            ->toHaveKey('cards', $sampleCards)
            ->toHaveKey('block')
            ->toHaveKey('is_preview', false);
    });

    ob_start();
    CardGrid::render(['name' => 'acf/card-grid'], '', false, 0);
    ob_end_clean();
});

it('falls back to safe defaults when ACF returns null or invalid values', function (): void {
    Functions\expect('get_field')
        ->andReturnUsing(fn(string $name) => match ($name) {
            'columns' => 'eleven', // invalid — not in whitelist
            default => null,
        });

    mockView('blocks.card-grid', function (array $data): void {
        expect($data['heading'])->toBe('');
        expect($data['columns'])->toBe('3'); // whitelisted default
        expect($data['cards'])->toBe([]);
    });

    ob_start();
    CardGrid::render([], '', false, 0);
    ob_end_clean();
});

it('registers the block', function (): void {
    Functions\expect('get_theme_file_path')
        ->once()
        ->with('resources/blocks/card-grid/block.json')
        ->andReturn('/dev/null/block.json');

    Functions\expect('register_block_type')
        ->once()
        ->with('/dev/null/block.json');

    CardGrid::register();

    expect(true)->toBeTrue();
});
