<?php

/**
 * Stubs for Acorn / Roots helpers used in this theme.
 * Listed individually to avoid conflicts with WordPress core helpers
 * (notably __() which Laravel and WordPress both define with different signatures).
 */

if (! function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     */
    function public_path(string $path = ''): string {}
}

if (! function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     */
    function asset(string $path, ?bool $secure = null): string {}
}

if (! function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $mergeData
     * @return ($view is null ? \Illuminate\Contracts\View\Factory : \Illuminate\Contracts\View\View)
     */
    function view(?string $view = null, array $data = [], array $mergeData = []): mixed {}
}
