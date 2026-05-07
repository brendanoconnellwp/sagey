@php
  $anchor = ! empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
  $classes = trim(implode(' ', [
      'card-grid',
      'card-grid--cols-' . $columns,
      $block['className'] ?? '',
  ]));
@endphp

<section {!! $anchor !!} class="{{ $classes }}">
  <div class="card-grid__inner">
    @if ($heading)
      <h2 class="card-grid__heading">{{ $heading }}</h2>
    @endif

    @if (count($cards))
      <ul class="card-grid__list" role="list">
        @foreach ($cards as $card)
          <li class="card-grid__item">
            <article class="card">
              @if (! empty($card['image']))
                <div class="card__media">
                  <x-image :image="$card['image']" sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw" />
                </div>
              @endif

              <div class="card__body">
                <h3 class="card__title">{{ $card['title'] ?? '' }}</h3>

                @if (! empty($card['body']))
                  <p class="card__copy">{{ $card['body'] }}</p>
                @endif

                @if (! empty($card['link_text']) && ! empty($card['link_url']))
                  <a class="card__link" href="{{ esc_url($card['link_url']) }}">
                    {{ $card['link_text'] }}
                    <span aria-hidden="true">&rarr;</span>
                  </a>
                @endif
              </div>
            </article>
          </li>
        @endforeach
      </ul>
    @elseif ($is_preview)
      <p class="card-grid__empty">Add cards in the block sidebar to populate this grid.</p>
    @endif
  </div>
</section>
