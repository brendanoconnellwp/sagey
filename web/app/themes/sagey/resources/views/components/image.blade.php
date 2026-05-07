@props([
    'image' => null,         // ACF image array, attachment ID, or direct URL
    'size' => 'large',       // WP image size; ignored for URL fallback
    'alt' => null,           // override; falls back to ACF alt or empty
    'sizes' => null,         // sizes attribute (responsive); leave null to use WP default
    'loading' => 'lazy',     // 'lazy' (default) or 'eager' for above-fold
    'fetchpriority' => null, // 'high' for the LCP image, otherwise leave null
])

@php
    /*
     * Resolve $image into an attachment ID. ACF image fields can return any of
     * three shapes depending on the field's "Return Format":
     *   - Array (recommended): ['ID' => 123, 'alt' => '...', 'sizes' => [...]]
     *   - ID: 123
     *   - URL: 'https://.../image.jpg'
     */
    $id = 0;
    $url = null;
    $altFallback = '';

    if (is_array($image) && ! empty($image['ID'])) {
        $id = (int) $image['ID'];
        $altFallback = (string) ($image['alt'] ?? '');
    } elseif (is_int($image) || (is_string($image) && ctype_digit($image))) {
        $id = (int) $image;
    } elseif (is_string($image) && filter_var($image, FILTER_VALIDATE_URL)) {
        $url = $image;
    }

    $finalAlt = $alt ?? $altFallback;

    $imgAtts = array_filter([
        'alt' => $finalAlt,
        'loading' => $loading,
        'decoding' => 'async',
        'sizes' => $sizes,
        'fetchpriority' => $fetchpriority,
        'class' => $attributes->get('class'),
    ], fn ($v) => $v !== null && $v !== '');
@endphp

@if ($id)
    {{-- WordPress builds the full <img> with srcset, width, height, and the merged attrs --}}
    {!! wp_get_attachment_image($id, $size, false, $imgAtts) !!}
@elseif ($url)
    {{-- Plain URL fallback — no srcset/dimensions metadata available --}}
    <img
        src="{{ esc_url($url) }}"
        alt="{{ esc_attr($finalAlt) }}"
        loading="{{ esc_attr($loading) }}"
        decoding="async"
        @if ($fetchpriority) fetchpriority="{{ esc_attr($fetchpriority) }}" @endif
        {{ $attributes->only('class') }}
    />
@endif
