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
  // to start with. Empty array allows full freedom; this opinion can be relaxed.
  $template = [
      ['sage/hero', []],
  ];
  $templateAttr = htmlspecialchars(wp_json_encode($template), ENT_QUOTES, 'UTF-8');
@endphp

<section {!! $anchor !!} class="{{ $classes }}">
  <div class="section__inner">
    <InnerBlocks template="{{ $templateAttr }}" />
  </div>
</section>
