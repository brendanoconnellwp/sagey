<?php

namespace App\Blocks;

class Section
{
    public static function register(): void
    {
        register_block_type(get_theme_file_path('resources/blocks/section/block.json'));
    }

    public static function registerFields(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key' => 'group_block_section',
            'title' => 'Section Block',
            'fields' => [
                [
                    'key' => 'field_section_width',
                    'label' => 'Width',
                    'name' => 'width',
                    'type' => 'button_group',
                    'choices' => [
                        'narrow' => 'Narrow',
                        'default' => 'Default',
                        'wide' => 'Wide',
                        'full' => 'Full Bleed',
                    ],
                    'default_value' => 'default',
                ],
                [
                    'key' => 'field_section_background',
                    'label' => 'Background',
                    'name' => 'background',
                    'type' => 'button_group',
                    'choices' => [
                        'default' => 'Default',
                        'subtle' => 'Subtle',
                        'muted' => 'Muted',
                        'inverse' => 'Inverse (dark)',
                    ],
                    'default_value' => 'default',
                ],
                [
                    'key' => 'field_section_padding',
                    'label' => 'Vertical Padding',
                    'name' => 'padding',
                    'type' => 'button_group',
                    'choices' => [
                        'none' => 'None',
                        'sm' => 'Small',
                        'md' => 'Medium',
                        'lg' => 'Large',
                    ],
                    'default_value' => 'lg',
                ],
            ],
            'location' => [[
                ['param' => 'block', 'operator' => '==', 'value' => 'sage/section'],
            ]],
        ]);
    }

    public static function render($block, $content = '', $is_preview = false, $post_id = 0): void
    {
        $allowedWidth = ['narrow', 'default', 'wide', 'full'];
        $allowedBg = ['default', 'subtle', 'muted', 'inverse'];
        $allowedPadding = ['none', 'sm', 'md', 'lg'];

        $width = get_field('width');
        $background = get_field('background');
        $padding = get_field('padding');

        echo view('blocks.section', [
            'block' => $block,
            'content' => $content,
            'is_preview' => $is_preview,
            'post_id' => $post_id,
            'width' => in_array($width, $allowedWidth, true) ? $width : 'default',
            'background' => in_array($background, $allowedBg, true) ? $background : 'default',
            'padding' => in_array($padding, $allowedPadding, true) ? $padding : 'lg',
        ])->render();
    }
}
