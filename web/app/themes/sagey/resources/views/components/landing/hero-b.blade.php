{{-- Hero Variation B — Typographic Brutalist --}}

<section class="relative min-h-screen overflow-hidden bg-dark-bg">

  {{-- Background decorative elements --}}
  <div class="pointer-events-none absolute inset-0">
    {{-- Subtle gradient shapes --}}
    <div class="absolute right-0 top-0 h-[500px] w-[500px] translate-x-1/4 rotate-[25deg] bg-gradient-to-b from-sage-green/[0.07] to-transparent"></div>
    <div class="absolute bottom-0 right-1/4 h-[500px] w-[500px] rounded-full bg-gradient-radial from-emerald-800/[0.06] to-transparent"></div>

    {{-- Horizontal lines --}}
    <div class="absolute left-0 top-[180px] h-px w-full bg-dark-card/20"></div>
    <div class="absolute left-0 top-[720px] h-px w-full bg-dark-card/30"></div>

    {{-- Geometric accents --}}
    <div class="absolute left-[620px] top-[200px] h-[180px] w-[180px] rounded-full border-2 border-sage-green/[0.12] hidden lg:block"></div>
    <div class="absolute right-[160px] top-[100px] h-[60px] w-[60px] rounded-full bg-sage-green/[0.06] hidden lg:block"></div>
    <div class="absolute bottom-[150px] left-[700px] h-10 w-10 rotate-45 border border-sage-green/[0.18] bg-sage-green/[0.09] hidden lg:block"></div>
    <div class="absolute right-[90px] bottom-[300px] h-6 w-6 bg-sage-green/[0.12] hidden lg:block"></div>

    {{-- Scattered dots --}}
    <div class="absolute left-[260px] bottom-[130px] h-3 w-3 rounded-full bg-sage-green/[0.18] hidden lg:block"></div>
    <div class="absolute right-[100px] top-[150px] h-[18px] w-[18px] rounded-full bg-sage-green/[0.12] hidden lg:block"></div>
    <div class="absolute bottom-[170px] left-[640px] h-2 w-2 rounded-full bg-sage-green/[0.12] hidden lg:block"></div>
    <div class="absolute right-[140px] top-[600px] h-2.5 w-2.5 rounded-full bg-sage-green/[0.15] hidden lg:block"></div>

    {{-- Crosshair --}}
    <span class="absolute left-[680px] top-[430px] font-mono text-2xl font-light text-sage-green/[0.18] hidden lg:block">+</span>
  </div>

  {{-- Nav Bar --}}
  <nav class="relative z-10 flex h-[72px] items-center justify-between px-16">
    <a href="{{ home_url('/') }}" class="flex items-center gap-2.5">
      <svg class="h-5 w-5 text-sage-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.9C15.5 4.9 17 3.5 19 2c1 2 2 4.5 1 8-1 3.5-3 5-5.5 7"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
      <span class="font-mono text-lg font-bold text-white">sagey</span>
    </a>
    <div class="flex items-center gap-8">
      <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Docs</a>
      <a href="#stack" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Stack</a>
      <a href="#agent" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Agents</a>
      <a href="https://github.com" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">GitHub</a>
      <a href="#get-started" class="rounded bg-sage-green px-4 py-2 font-mono text-[11px] font-bold text-dark-bg transition-colors duration-150 hover:bg-sage-green/90">Get Started</a>
    </div>
  </nav>

  {{-- Corner label --}}
  <div class="absolute left-16 top-[100px] z-10 hidden lg:block">
    <span class="font-mono text-sm font-bold text-dark-border">//</span>
    <span class="ml-1 text-xs text-muted-darker">starter theme for humans & robots</span>
  </div>

  {{-- Giant Typography --}}
  <div class="relative z-10 px-16 pt-16 lg:pt-24">
    <div class="select-none" aria-hidden="true">
      <p class="text-[clamp(80px,14vw,200px)] font-black leading-[0.85] tracking-[-0.04em] text-dark-border/60" style="text-stroke: 2px #475569; -webkit-text-stroke: 2px #475569;">WORD</p>
      <p class="text-[clamp(80px,14vw,200px)] font-black leading-[0.85] tracking-[-0.04em]">
        <span class="bg-gradient-to-b from-sage-green to-emerald-700 bg-clip-text text-transparent">PRESS</span><span class="text-sage-green">.</span>
      </p>
    </div>
  </div>

  {{-- Tagline + CTAs --}}
  <div class="relative z-10 flex flex-col gap-5 px-16 pt-12 lg:pt-16">
    <p class="max-w-lg text-[22px] font-light leading-relaxed text-muted">
      Sage + AI agents. Your WordPress just got a brain.
    </p>

    <div class="flex items-center gap-4">
      <a href="#get-started" class="bg-sage-green px-7 py-3.5 font-mono text-sm font-bold text-dark-bg transition-colors duration-150 hover:bg-sage-green/90">
        npx create-sagey
      </a>
      <a href="#" class="border border-dark-border px-7 py-3.5 text-sm font-medium text-muted transition-colors duration-150 hover:border-muted-dark hover:text-white">
        Read the docs &rarr;
      </a>
    </div>
  </div>

  {{-- Floating Terminal Card --}}
  <div class="absolute right-[calc(50%-180px)] top-[250px] z-20 hidden w-[440px] rounded-md border border-dark-card bg-[#070B14]/90 px-[18px] py-3.5 shadow-2xl shadow-black/50 lg:block xl:right-[200px]">
    <div class="flex flex-col gap-1.5">
      <code class="font-mono text-xs font-semibold leading-relaxed text-sage-green">$ npx create-sagey my-theme</code>
      <code class="font-mono text-[11px] leading-relaxed text-muted-dark">&#10003; Scaffolded Sage 11 + Tailwind v4</code>
      <code class="font-mono text-[11px] leading-relaxed text-muted-dark">&#10003; Configured Acorn service container</code>
      <code class="font-mono text-[11px] leading-relaxed text-muted-dark">&#10003; AI agent pipeline initialized</code>
      <code class="font-mono text-[11px] leading-relaxed text-amber-500">&#9680; Waking up your robot friend...</code>
    </div>
  </div>

  {{-- Floating Code Card --}}
  <div class="absolute right-[calc(50%-280px)] top-[480px] z-20 hidden w-[380px] rounded-lg border border-sage-green/[0.18] bg-dark-surface/90 p-5 shadow-2xl shadow-black/60 backdrop-blur-sm lg:block xl:right-[100px]">
    <div class="flex flex-col gap-2.5">
      {{-- File header --}}
      <div class="flex items-center gap-2">
        <span class="h-2 w-2 rounded-full bg-dark-border"></span>
        <span class="h-2 w-2 rounded-full bg-dark-border"></span>
        <span class="h-2 w-2 rounded-full bg-dark-border"></span>
        <span class="ml-2 font-mono text-[10px] text-muted-darker">hero.blade.php</span>
      </div>
      <div class="h-px w-full bg-dark-card"></div>

      {{-- Code lines --}}
      <div class="flex flex-col gap-0.5">
        <code class="font-mono text-[11px] leading-relaxed text-amber-500">@verbatim@extends('layouts.app')@endverbatim</code>
        <code class="font-mono text-[11px] leading-relaxed text-amber-500">@verbatim@section('content')@endverbatim</code>
        <code class="font-mono text-[11px] leading-relaxed text-muted">&nbsp;&nbsp;&lt;x-hero :title="$title"</code>
        <code class="font-mono text-[11px] leading-relaxed text-sage-green">&nbsp;&nbsp;&nbsp;&nbsp;class="from-sage to-emerald"</code>
        <code class="font-mono text-[11px] leading-relaxed text-muted">&nbsp;&nbsp;&nbsp;&nbsp;:agent="$sageyBot" /&gt;</code>
        <code class="font-mono text-[11px] leading-relaxed text-amber-500">@verbatim@endsection@endverbatim</code>
      </div>
    </div>
  </div>

  {{-- Horizontal divider --}}
  <div class="relative z-10 mx-16 mt-16 h-px bg-dark-card/50"></div>

  {{-- Bottom accent label --}}
  <div class="relative z-10 flex items-center gap-3 px-16 py-8">
    <span class="h-1.5 w-1.5 rounded-full bg-sage-green"></span>
    <span class="font-mono text-[11px] font-medium text-muted-darker">Sage 11 &middot; Blade &middot; Tailwind v4 &middot; Acorn &middot; AI Agents</span>
    <span class="ml-auto font-mono text-[10px] text-dark-border">v1.0.0</span>
  </div>

</section>
