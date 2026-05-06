<?php

namespace App\Blocks;

class Hero
{
    public static function register(): void
    {
        register_block_type(get_theme_file_path('resources/blocks/hero/block.json'));
    }

    public static function registerFields(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key' => 'group_block_hero',
            'title' => 'Hero Block',
            'fields' => [
                [
                    'key' => 'field_hero_heading',
                    'label' => 'Heading',
                    'name' => 'heading',
                    'type' => 'text',
                    'required' => 1,
                    'default_value' => 'Build with intention.',
                ],
                [
                    'key' => 'field_hero_subheading',
                    'label' => 'Subheading',
                    'name' => 'subheading',
                    'type' => 'textarea',
                    'rows' => 3,
                    'new_lines' => '',
                ],
                [
                    'key' => 'field_hero_button_text',
                    'label' => 'Button Text',
                    'name' => 'button_text',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_hero_button_url',
                    'label' => 'Button URL',
                    'name' => 'button_url',
                    'type' => 'url',
                    'conditional_logic' => [[
                        ['field' => 'field_hero_button_text', 'operator' => '!=', 'value' => ''],
                    ]],
                ],
                [
                    'key' => 'field_hero_alignment',
                    'label' => 'Alignment',
                    'name' => 'alignment',
                    'type' => 'button_group',
                    'choices' => ['left' => 'Left', 'center' => 'Center'],
                    'default_value' => 'center',
                ],
            ],
            'location' => [[
                ['param' => 'block', 'operator' => '==', 'value' => 'sage/hero'],
            ]],
        ]);
    }

    public static function render($block, $content = '', $is_preview = false, $post_id = 0): void
    {
        echo view('blocks.hero', [
            'block' => $block,
            'content' => $content,
            'is_preview' => $is_preview,
            'post_id' => $post_id,
            'heading' => get_field('heading') ?: '',
            'subheading' => get_field('subheading') ?: '',
            'button_text' => get_field('button_text') ?: '',
            'button_url' => get_field('button_url') ?: '',
            'alignment' => get_field('alignment') ?: 'center',
        ])->render();
    }
}
