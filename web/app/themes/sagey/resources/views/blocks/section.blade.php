@php
  $anchor = ! empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
  $classes = trim(implode(' ', [
      'section',
      'section--width-' . $width,
      'section--bg-' . $background,
      'section--pad-' . $padding,
      $block['className'] ?? '',
  ]));

  // Default template when the section is first inserted — gives editors a Hero
  // to start with. Remove or change to taste; an empty array allows free composition.
  $template = wp_json_encode([['sage/hero', []]]);
@endphp

<section {!! $anchor !!} class="{{ $classes }}">
  <div class="section__inner">
    <InnerBlocks template="{{ $template }}" />
  </div>
</section>
