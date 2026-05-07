<?php

namespace App\Blocks;

class CardGrid
{
    public static function register(): void
    {
        register_block_type(get_theme_file_path('resources/blocks/card-grid/block.json'));
    }

    public static function registerFields(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key' => 'group_block_card_grid',
            'title' => 'Card Grid Block',
            'fields' => [
                [
                    'key' => 'field_card_grid_heading',
                    'label' => 'Heading',
                    'name' => 'heading',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_card_grid_columns',
                    'label' => 'Columns',
                    'name' => 'columns',
                    'type' => 'button_group',
                    'choices' => ['2' => '2', '3' => '3', '4' => '4'],
                    'default_value' => '3',
                ],
                [
                    'key' => 'field_card_grid_cards',
                    'label' => 'Cards',
                    'name' => 'cards',
                    'type' => 'repeater',
                    'min' => 1,
                    'button_label' => 'Add Card',
                    'layout' => 'block',
                    'sub_fields' => [
                        [
                            'key' => 'field_card_grid_card_image',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ],
                        [
                            'key' => 'field_card_grid_card_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                            'required' => 1,
                        ],
                        [
                            'key' => 'field_card_grid_card_body',
                            'label' => 'Body',
                            'name' => 'body',
                            'type' => 'textarea',
                            'rows' => 3,
                            'new_lines' => '',
                        ],
                        [
                            'key' => 'field_card_grid_card_link_text',
                            'label' => 'Link Text',
                            'name' => 'link_text',
                            'type' => 'text',
                        ],
                        [
                            'key' => 'field_card_grid_card_link_url',
                            'label' => 'Link URL',
                            'name' => 'link_url',
                            'type' => 'url',
                        ],
                    ],
                ],
            ],
            'location' => [[
                ['param' => 'block', 'operator' => '==', 'value' => 'sage/card-grid'],
            ]],
        ]);
    }

    public static function render($block, $content = '', $is_preview = false, $post_id = 0): void
    {
        $allowedColumns = ['2', '3', '4'];
        $columns = get_field('columns');

        echo view('blocks.card-grid', [
            'block' => $block,
            'content' => $content,
            'is_preview' => $is_preview,
            'post_id' => $post_id,
            'heading' => get_field('heading') ?: '',
            'columns' => in_array($columns, $allowedColumns, true) ? $columns : '3',
            'cards' => get_field('cards') ?: [],
        ])->render();
    }
}
