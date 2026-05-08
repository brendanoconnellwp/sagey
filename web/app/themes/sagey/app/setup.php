<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/scss/editor.scss');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_action('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    if (! Vite::isRunningHot()) {
        $dependencies = json_decode(Vite::content('editor.deps.json'));

        foreach ($dependencies as $dependency) {
            if (! wp_script_is($dependency)) {
                wp_enqueue_script($dependency);
            }
        }
    }
    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Disable on-demand block asset loading.
 *
 * @link https://core.trac.wordpress.org/ticket/61965
 */
add_filter('should_load_separate_core_block_assets', '__return_false');

/**
 * Register a custom block category for Sagey blocks.
 * Prepended so it appears at the top of the editor inserter.
 */
add_filter('block_categories_all', function ($categories) {
    return array_merge(
        [['slug' => 'sagey', 'title' => __('Sagey', 'sage'), 'icon' => null]],
        $categories
    );
});

/**
 * Register custom blocks.
 *
 * Each entry must expose static register() and registerFields() methods
 * (the canonical pattern in app/Blocks/Hero.php). Add new blocks above
 * the marker comment — `npm run make:block` does this automatically.
 */
$blocks = [
    \App\Blocks\Hero::class,
    \App\Blocks\Section::class,
    \App\Blocks\CardGrid::class,
    // {{ make:block insertion point — do not remove }}
];

foreach ($blocks as $block) {
    add_action('init', fn() => $block::register());
    add_action('acf/init', fn() => $block::registerFields());
}

/**
 * Register custom post types.
 *
 * Same convention as $blocks above. Each entry must expose static
 * register() and registerFields() methods. `npm run make:cpt` inserts
 * new entries before the marker.
 */
/** @var list<class-string> $postTypes — populated by `npm run make:cpt` */
$postTypes = [
    // {{ make:cpt insertion point — do not remove }}
];

foreach ($postTypes as $postType) {
    add_action('init', fn() => $postType::register());
    add_action('acf/init', fn() => $postType::registerFields());
}

/**
 * Constrain the editor inserter to a curated set: every sage/* block we
 * register, plus the core blocks editors actually need for marketing pages.
 * Keeps the inserter focused and prevents unsupported core blocks from
 * landing in client content.
 *
 * To allow another core block, add it to $coreAllowed below.
 * To open the inserter back up everywhere (e.g. for a custom CPT), add
 * a check on $editor_context->post->post_type before applying the filter.
 */
add_filter('allowed_block_types_all', function ($allowed, $editor_context) {
    // Outside a post-edit context (widget editor, navigation, etc.), leave defaults alone.
    if (empty($editor_context->post)) {
        return $allowed;
    }

    $coreAllowed = [
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/image',
        'core/gallery',
        'core/video',
        'core/buttons',
        'core/button',
        'core/columns',
        'core/column',
        'core/group',
        'core/separator',
        'core/spacer',
        'core/quote',
        'core/html',
    ];

    $sageBlocks = array_filter(
        array_keys(\WP_Block_Type_Registry::get_instance()->get_all_registered()),
        fn(string $name) => str_starts_with($name, 'sage/'),
    );

    return array_values(array_unique(array_merge($coreAllowed, $sageBlocks)));
}, 10, 2);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});
