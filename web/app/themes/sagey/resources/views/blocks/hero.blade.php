@php
  $anchor = ! empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
  $align = in_array($alignment, ['left', 'center'], true) ? $alignment : 'center';
  $classes = trim('hero hero--align-' . $align . ' ' . ($block['className'] ?? ''));
@endphp

<section {!! $anchor !!} class="{{ $classes }}">
  <div class="hero__inner">
    @if ($heading)
      <h1 class="hero__heading">{{ $heading }}</h1>
    @endif

    @if ($subheading)
      <p class="hero__subheading">{{ $subheading }}</p>
    @endif

    @if ($button_text && $button_url)
      <div class="hero__actions">
        <a class="btn btn--primary" href="{{ esc_url($button_url) }}">
          {{ $button_text }}
        </a>
      </div>
    @endif
  </div>
</section>
