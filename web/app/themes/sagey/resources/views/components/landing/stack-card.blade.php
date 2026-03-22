@props([
  'icon' => 'layers',
  'title' => '',
  'description' => '',
  'highlighted' => false,
])

@php
$borderClass = $highlighted ? 'border border-sage-green' : '';
$iconBg = $highlighted ? 'bg-sage-green-dim' : 'bg-dark-surface';
$titleColor = $highlighted ? 'text-sage-green' : 'text-white';
@endphp

<div {{ $attributes->merge(['class' => "flex flex-col gap-3 rounded-xl bg-dark-card p-5 {$borderClass}"]) }}>
  <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ $iconBg }}">
    <x-landing.lucide-icon :name="$icon" class="h-5 w-5 text-sage-green" />
  </div>
  <h3 class="text-base font-semibold {{ $titleColor }}">{{ $title }}</h3>
  <p class="text-[13px] leading-relaxed text-muted-dark">{{ $description }}</p>
</div>
