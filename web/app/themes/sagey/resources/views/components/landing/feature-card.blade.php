@props([
  'icon' => 'zap',
  'title' => '',
  'description' => '',
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-3 rounded-xl bg-dark-card p-5']) }}>
  <x-landing.lucide-icon :name="$icon" class="h-[22px] w-[22px] text-sage-green" />
  <h3 class="text-[15px] font-semibold text-white">{{ $title }}</h3>
  <p class="text-[13px] leading-relaxed text-muted-dark">{{ $description }}</p>
</div>
