{{--
  Template Name: Brutalist Landing Page
--}}

@extends('layouts.landing')

@section('content')

  {{-- Hero (Typographic Brutalist) --}}
  <x-landing.hero-b />

  {{-- Trust Bar --}}
  <div class="relative flex h-[100px] items-center justify-between bg-[#070B14] px-28">
    <div class="absolute left-0 top-0 h-px w-full bg-dark-card/25"></div>
    <span class="font-mono text-[11px] font-semibold text-dark-border">// trusted_stack</span>
    <div class="flex items-center gap-2"><x-landing.lucide-icon name="wind" class="h-4 w-4 text-muted-darker" /><span class="font-mono text-xs font-medium text-muted-dark">Tailwind v4</span></div>
    <div class="flex items-center gap-2"><x-landing.lucide-icon name="code" class="h-4 w-4 text-muted-darker" /><span class="font-mono text-xs font-medium text-muted-dark">Blade</span></div>
    <div class="flex items-center gap-2"><x-landing.lucide-icon name="zap" class="h-4 w-4 text-muted-darker" /><span class="font-mono text-xs font-medium text-muted-dark">Vite</span></div>
    <div class="flex items-center gap-2"><x-landing.lucide-icon name="box" class="h-4 w-4 text-muted-darker" /><span class="font-mono text-xs font-medium text-muted-dark">Acorn</span></div>
    <div class="flex items-center gap-2"><x-landing.lucide-icon name="bot" class="h-4 w-4 text-muted-darker" /><span class="font-mono text-xs font-medium text-muted-dark">AI Agents</span></div>
    <div class="flex items-center gap-2"><x-landing.lucide-icon name="leaf" class="h-4 w-4 text-sage-green" /><span class="font-mono text-xs font-medium text-muted-dark">Sage 11</span></div>
    <div class="absolute bottom-0 left-0 h-px w-full bg-dark-card/25"></div>
  </div>

  {{-- Problem / Solution --}}
  <section class="bg-dark-bg px-28 py-24">
    <div class="flex gap-0">
      {{-- Problem --}}
      <div class="flex flex-1 flex-col gap-8 pr-12">
        <span class="font-mono text-[13px] text-sage-green">// the_problem</span>
        <h2 class="text-[40px] font-extrabold leading-tight text-white">WordPress development<br>is stuck in 2015</h2>
        <div class="flex flex-col gap-4">
          <p class="font-mono text-sm text-muted">&rarr;&nbsp; Manual templating with no type safety</p>
          <p class="font-mono text-sm text-muted">&rarr;&nbsp; Zero AI integration in your workflow</p>
          <p class="font-mono text-sm text-muted">&rarr;&nbsp; Slow builds, no hot module replacement</p>
          <p class="font-mono text-sm text-muted">&rarr;&nbsp; Legacy PHP patterns everywhere</p>
        </div>
      </div>
      {{-- Solution --}}
      <div class="flex flex-1 flex-col gap-8 pl-12">
        <span class="font-mono text-[13px] text-sage-green">// the_solution</span>
        <h2 class="text-[40px] font-extrabold leading-tight text-sage-green">sagey changes<br>everything</h2>
        <div class="flex flex-col gap-4">
          <p class="font-mono text-sm text-slate-300">&rarr;&nbsp; AI agents that write blocks for you</p>
          <p class="font-mono text-sm text-slate-300">&rarr;&nbsp; Laravel Blade components &amp; type hints</p>
          <p class="font-mono text-sm text-slate-300">&rarr;&nbsp; Vite + Tailwind v4 hot reloading</p>
          <p class="font-mono text-sm text-slate-300">&rarr;&nbsp; Modern PHP 8.2+ with Acorn framework</p>
        </div>
      </div>
    </div>
    <div class="mt-16 h-px w-full bg-sage-green/[0.12]"></div>
  </section>

  {{-- Core Features --}}
  <section class="bg-[#070B14] px-28 py-24">
    <span class="font-mono text-[13px] text-sage-green">// core_features</span>
    <h2 class="mt-4 text-5xl font-extrabold leading-tight text-white">What's under the hood</h2>

    {{-- Feature 1: AI Agents --}}
    <div class="mt-20 flex items-center gap-12">
      <div class="flex flex-1 flex-col gap-4">
        <span class="font-mono text-xs font-semibold text-sage-green">01</span>
        <h3 class="text-[32px] font-bold text-white">AI Agents</h3>
        <p class="font-mono text-sm leading-relaxed text-muted">Autonomous agents that write Gutenberg blocks, generate Blade templates, scaffold components, and run WP-CLI tasks — all from natural language prompts.</p>
      </div>
      <div class="w-[480px] shrink-0 rounded border border-sage-green/[0.18] bg-dark-surface/90 p-6 shadow-2xl shadow-black/60">
        <div class="flex flex-col gap-2">
          <code class="font-mono text-xs text-sage-green">$ sagey agent generate block hero-banner</code>
          <code class="font-mono text-xs text-muted">&nbsp;</code>
          <code class="font-mono text-xs text-muted">&#9656; Analyzing block requirements...</code>
          <code class="font-mono text-xs text-muted">&#9656; Generating block.json schema</code>
          <code class="font-mono text-xs text-muted">&#9656; Writing render.blade.php template</code>
          <code class="font-mono text-xs text-muted">&#9656; Adding Tailwind styles</code>
          <code class="font-mono text-xs text-sage-green">&#10003; Block hero-banner created successfully</code>
        </div>
      </div>
    </div>

    {{-- Feature 2: Blade Components --}}
    <div class="mt-20 flex items-center gap-12">
      <div class="w-[480px] shrink-0 rounded border border-sage-green/[0.18] bg-dark-surface/90 p-6 shadow-2xl shadow-black/60">
        <div class="flex flex-col gap-1">
          <code class="font-mono text-xs text-muted">@verbatim{{-- resources/views/blocks/hero.blade.php --}}@endverbatim</code>
          <code class="font-mono text-xs text-muted">&nbsp;</code>
          <code class="font-mono text-xs text-amber-500">&lt;x-hero :title="$title"&gt;</code>
          <code class="font-mono text-xs text-amber-500">&nbsp;&nbsp;&lt;x-badge variant="green"&gt;</code>
          <code class="font-mono text-xs text-sage-green">&nbsp;&nbsp;&nbsp;&nbsp;@verbatim{{ $slot }}@endverbatim</code>
          <code class="font-mono text-xs text-amber-500">&nbsp;&nbsp;&lt;/x-badge&gt;</code>
          <code class="font-mono text-xs text-amber-500">&lt;/x-hero&gt;</code>
        </div>
      </div>
      <div class="flex flex-1 flex-col gap-4">
        <span class="font-mono text-xs font-semibold text-sage-green">02</span>
        <h3 class="text-[32px] font-bold text-white">Blade Components</h3>
        <p class="font-mono text-sm leading-relaxed text-muted">Modern templating with Laravel Blade. Composable, typed components with slots, props, and directives — replacing the_loop() with elegant, reusable markup.</p>
      </div>
    </div>

    {{-- Feature 3: Modern Toolchain --}}
    <div class="mt-20 flex items-center gap-12">
      <div class="flex flex-1 flex-col gap-4">
        <span class="font-mono text-xs font-semibold text-sage-green">03</span>
        <h3 class="text-[32px] font-bold text-white">Modern Toolchain</h3>
        <p class="font-mono text-sm leading-relaxed text-muted">Tailwind CSS v4 with Vite for instant HMR, Acorn as your application framework, and a fully modern PHP 8.2+ stack — no more webpack configs or jQuery dependencies.</p>
      </div>
      <div class="w-[480px] shrink-0 rounded border border-sage-green/[0.18] bg-dark-surface/90 p-6 shadow-2xl shadow-black/60">
        <div class="flex flex-col gap-1">
          <code class="font-mono text-xs text-muted">// tailwind.config.js &rarr; gone</code>
          <code class="font-mono text-xs text-muted">// webpack.mix.js &nbsp;&rarr; gone</code>
          <code class="font-mono text-xs text-muted">&nbsp;</code>
          <code class="font-mono text-xs text-amber-500">@verbatim@import 'tailwindcss';@endverbatim</code>
          <code class="font-mono text-xs text-sage-green">@verbatim@source '../views/**/*.blade.php';@endverbatim</code>
          <code class="font-mono text-xs text-muted">&nbsp;</code>
          <code class="font-mono text-xs text-white">$ vite dev</code>
          <code class="font-mono text-xs text-sage-green">&nbsp;&nbsp;VITE v6.2 &nbsp;ready in 340ms</code>
        </div>
      </div>
    </div>
  </section>

  {{-- Code Showcase --}}
  <section class="bg-dark-bg px-28 py-24">
    <span class="font-mono text-[13px] text-sage-green">// developer_experience</span>
    <h2 class="mt-4 text-5xl font-extrabold text-white">See it in action</h2>
    <p class="mt-4 font-mono text-sm text-muted">Write a Blade template. Watch the AI agent scaffold the block.</p>

    <div class="mt-12 overflow-hidden rounded border border-sage-green/[0.18] bg-dark-surface shadow-2xl shadow-black/80">
      {{-- Title bar --}}
      <div class="flex items-center gap-3 bg-dark-card px-4 py-3">
        <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
        <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
        <span class="h-2.5 w-2.5 rounded-full bg-sage-green"></span>
        <span class="ml-2 font-mono text-[11px] text-muted">sagey — ~/themes/flavor</span>
      </div>
      {{-- Split panes --}}
      <div class="flex">
        {{-- Left: Blade code --}}
        <div class="flex flex-1 flex-col gap-1 bg-dark-surface p-5">
          <span class="mb-2 font-mono text-[10px] font-semibold tracking-wider text-sage-green">hero.blade.php</span>
          <code class="font-mono text-xs text-amber-500">@verbatim@extends('layouts.app')@endverbatim</code>
          <code class="font-mono text-xs text-muted">&nbsp;</code>
          <code class="font-mono text-xs text-amber-500">@verbatim@section('content')@endverbatim</code>
          <code class="font-mono text-xs text-muted">&nbsp;&nbsp;&lt;section class="hero"&gt;</code>
          <code class="font-mono text-xs text-amber-500">&nbsp;&nbsp;&nbsp;&nbsp;&lt;x-heading level="1"&gt;</code>
          <code class="font-mono text-xs text-sage-green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@verbatim{{ $page->title }}@endverbatim</code>
          <code class="font-mono text-xs text-amber-500">&nbsp;&nbsp;&nbsp;&nbsp;&lt;/x-heading&gt;</code>
          <code class="font-mono text-xs text-amber-500">&nbsp;&nbsp;&nbsp;&nbsp;&lt;x-button href="/start"&gt;</code>
          <code class="font-mono text-xs text-sage-green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Get Started &rarr;</code>
          <code class="font-mono text-xs text-amber-500">&nbsp;&nbsp;&nbsp;&nbsp;&lt;/x-button&gt;</code>
          <code class="font-mono text-xs text-muted">&nbsp;&nbsp;&lt;/section&gt;</code>
          <code class="font-mono text-xs text-amber-500">@verbatim@endsection@endverbatim</code>
        </div>
        {{-- Right: Terminal --}}
        <div class="flex flex-1 flex-col gap-1 bg-dark-bg p-5">
          <span class="mb-2 font-mono text-[10px] font-semibold tracking-wider text-amber-500">TERMINAL</span>
          <code class="font-mono text-xs text-white">$ sagey agent run</code>
          <code class="font-mono text-xs text-muted">&nbsp;</code>
          <code class="font-mono text-xs text-muted">&#9691; Scanning Blade templates...</code>
          <code class="font-mono text-xs text-sage-green">&#10003; Found 3 unregistered blocks</code>
          <code class="font-mono text-xs text-sage-green">&#10003; Generated block: hero-section</code>
          <code class="font-mono text-xs text-sage-green">&#10003; Generated block: feature-grid</code>
          <code class="font-mono text-xs text-sage-green">&#10003; Generated block: cta-banner</code>
          <code class="font-mono text-xs text-muted">&nbsp;</code>
          <code class="font-mono text-xs text-amber-500">&rarr; 3 blocks scaffolded in 2.1s</code>
        </div>
      </div>
    </div>
  </section>

  {{-- Stats --}}
  <div class="flex items-center justify-between bg-[#070B14] px-28 py-20">
    <div class="flex flex-1 flex-col items-center gap-2">
      <span class="text-6xl font-extrabold text-sage-green">0.4s</span>
      <span class="font-mono text-xs tracking-wider text-muted">build time</span>
    </div>
    <div class="h-20 w-px bg-sage-green/[0.12]"></div>
    <div class="flex flex-1 flex-col items-center gap-2">
      <span class="text-6xl font-extrabold text-white">10x</span>
      <span class="font-mono text-xs tracking-wider text-muted">faster development</span>
    </div>
    <div class="h-20 w-px bg-sage-green/[0.12]"></div>
    <div class="flex flex-1 flex-col items-center gap-2">
      <span class="text-6xl font-extrabold text-white">23+</span>
      <span class="font-mono text-xs tracking-wider text-muted">blade components</span>
    </div>
    <div class="h-20 w-px bg-sage-green/[0.12]"></div>
    <div class="flex flex-1 flex-col items-center gap-2">
      <span class="text-6xl font-extrabold text-sage-green">156</span>
      <span class="font-mono text-xs tracking-wider text-muted">AI agent runs</span>
    </div>
  </div>

  {{-- Testimonials --}}
  <section class="bg-dark-bg px-28 py-24">
    <div class="flex items-end justify-between">
      <div class="flex flex-col gap-2">
        <span class="font-mono text-[11px] font-semibold text-dark-border">// what_devs_say</span>
        <h2 class="text-[42px] font-extrabold tracking-tight text-white">Words from the terminal.</h2>
      </div>
      <span class="font-mono text-xs font-semibold text-dark-border">[3/128]</span>
    </div>

    <div class="mt-12 flex gap-6">
      <div class="flex flex-1 flex-col gap-5 border border-dark-card bg-dark-surface p-7">
        <p class="text-[15px] leading-relaxed text-muted">"Sagey's AI agent wrote a custom Blade component in 4 seconds that would've taken me 20 minutes. I just described what I wanted in the terminal."</p>
        <div class="flex items-center gap-3">
          <div class="flex h-9 w-9 items-center justify-center rounded-full bg-sage-green-dim font-mono text-xs font-bold text-sage-green">JC</div>
          <div><p class="text-sm font-medium text-white">Jamie Chen</p><p class="font-mono text-[11px] text-muted-dark">Senior WP Developer</p></div>
        </div>
      </div>
      <div class="flex flex-1 flex-col gap-5 border border-sage-green/[0.18] bg-dark-surface p-7">
        <p class="text-[15px] leading-relaxed text-muted">"The Acorn service container + Blade components changed how I think about WordPress entirely. It's Laravel-grade architecture for themes. No going back."</p>
        <div class="flex items-center gap-3">
          <div class="flex h-9 w-9 items-center justify-center rounded-full bg-sage-green-dim font-mono text-xs font-bold text-sage-green">MR</div>
          <div><p class="text-sm font-medium text-white">Maya Rodriguez</p><p class="font-mono text-[11px] text-muted-dark">Lead Engineer, Flavor Studio</p></div>
        </div>
      </div>
      <div class="flex flex-1 flex-col gap-5 border border-dark-card bg-dark-surface p-7">
        <p class="text-[15px] leading-relaxed text-muted">"0.4 second builds. Zero-config Tailwind v4. AI that actually understands Blade syntax. This is what WordPress development should feel like in 2026."</p>
        <div class="flex items-center gap-3">
          <div class="flex h-9 w-9 items-center justify-center rounded-full bg-sage-green-dim font-mono text-xs font-bold text-sage-green">AK</div>
          <div><p class="text-sm font-medium text-white">Alex Kim</p><p class="font-mono text-[11px] text-muted-dark">Freelance Developer</p></div>
        </div>
      </div>
    </div>
  </section>

  {{-- Pricing --}}
  <section class="bg-[#070B14] px-28 py-24">
    <div class="flex flex-col items-center gap-2">
      <span class="font-mono text-[11px] font-semibold text-dark-border">// pricing</span>
      <h2 class="text-[42px] font-extrabold tracking-tight text-white">Pick your stack.</h2>
      <p class="text-base text-muted-dark">Open source core. Pay only for the AI superpowers.</p>
    </div>

    <div class="mt-12 flex gap-6">
      {{-- Starter --}}
      <div class="flex flex-1 flex-col gap-6 border border-dark-card bg-dark-surface p-8">
        <span class="font-mono text-[10px] font-semibold text-muted-darker">[OPEN SOURCE]</span>
        <h3 class="text-2xl font-bold text-white">Starter</h3>
        <div class="flex items-end gap-1">
          <span class="text-5xl font-extrabold text-white">$0</span>
          <span class="font-mono text-[13px] text-muted-darker">/forever</span>
        </div>
        <p class="text-sm leading-relaxed text-muted-dark">The full Sage 11 stack. Blade, Tailwind v4, Acorn, Vite. Everything you need to build modern WordPress themes.</p>
        <div class="h-px bg-dark-card"></div>
        <div class="flex flex-col gap-3">
          <span class="font-mono text-xs text-muted">+ Sage 11 scaffolding</span>
          <span class="font-mono text-xs text-muted">+ Blade templating engine</span>
          <span class="font-mono text-xs text-muted">+ Tailwind v4 + Vite</span>
          <span class="font-mono text-xs text-muted">+ Acorn service container</span>
          <span class="font-mono text-xs text-muted">+ Community support</span>
        </div>
        <div class="flex items-center justify-center border border-dark-border py-3.5">
          <span class="font-mono text-[13px] font-semibold text-white">npx create-sagey</span>
        </div>
      </div>

      {{-- Pro --}}
      <div class="flex flex-1 flex-col gap-6 border-2 border-sage-green bg-dark-surface p-8">
        <span class="font-mono text-[10px] font-semibold text-sage-green">[RECOMMENDED]</span>
        <h3 class="text-2xl font-bold text-white">Pro</h3>
        <div class="flex items-end gap-1">
          <span class="text-5xl font-extrabold text-sage-green">$19</span>
          <span class="font-mono text-[13px] text-muted-darker">/month</span>
        </div>
        <p class="text-sm leading-relaxed text-muted-dark">Everything in Starter plus AI agents that write Blade components, generate blocks, and automate your workflow.</p>
        <div class="h-px bg-dark-card"></div>
        <div class="flex flex-col gap-3">
          <span class="font-mono text-xs text-muted">+ Everything in Starter</span>
          <span class="font-mono text-xs font-semibold text-sage-green">+ AI Block Builder agent</span>
          <span class="font-mono text-xs font-semibold text-sage-green">+ AI CLI Agent</span>
          <span class="font-mono text-xs text-muted">+ Smart code generation</span>
          <span class="font-mono text-xs text-muted">+ Priority support</span>
          <span class="font-mono text-xs text-muted">+ Theme marketplace access</span>
        </div>
        <div class="flex items-center justify-center bg-sage-green py-3.5">
          <span class="font-mono text-[13px] font-bold text-dark-bg">Start building &rarr;</span>
        </div>
      </div>

      {{-- Team --}}
      <div class="flex flex-1 flex-col gap-6 border border-dark-card bg-dark-surface p-8">
        <span class="font-mono text-[10px] font-semibold text-muted-darker">[ENTERPRISE]</span>
        <h3 class="text-2xl font-bold text-white">Team</h3>
        <div class="flex items-end gap-1">
          <span class="text-5xl font-extrabold text-white">$49</span>
          <span class="font-mono text-[13px] text-muted-darker">/seat/mo</span>
        </div>
        <p class="text-sm leading-relaxed text-muted-dark">For agencies and teams shipping multiple WordPress projects. Custom agents, shared components, and dedicated infrastructure.</p>
        <div class="h-px bg-dark-card"></div>
        <div class="flex flex-col gap-3">
          <span class="font-mono text-xs text-muted">+ Everything in Pro</span>
          <span class="font-mono text-xs text-muted">+ Custom AI agent training</span>
          <span class="font-mono text-xs text-muted">+ Shared component library</span>
          <span class="font-mono text-xs text-muted">+ Team collaboration</span>
          <span class="font-mono text-xs text-muted">+ SLA &amp; dedicated support</span>
          <span class="font-mono text-xs text-muted">+ Self-hosted option</span>
        </div>
        <div class="flex items-center justify-center border border-dark-border py-3.5">
          <span class="font-mono text-[13px] font-semibold text-white">Contact sales</span>
        </div>
      </div>
    </div>
  </section>

  {{-- Final CTA --}}
  <section class="flex flex-col items-center gap-8 bg-dark-bg px-28 py-28">
    <span class="font-mono text-[11px] font-semibold text-dark-border">// ready_to_ship?</span>
    <h2 class="max-w-3xl text-center text-[56px] font-black leading-none tracking-tighter text-white">Stop building WordPress<br>like it's 2015.</h2>
    <p class="text-center text-lg text-muted-dark">One command. Modern stack. AI-powered. Your next theme starts here.</p>
    <div class="flex items-center gap-4">
      <a href="#get-started" class="bg-sage-green px-8 py-4 font-mono text-sm font-bold text-dark-bg transition-colors duration-150 hover:bg-sage-green/90">npx create-sagey</a>
      <a href="https://github.com" class="border border-dark-border px-8 py-4 text-sm font-semibold text-white transition-colors duration-150 hover:border-muted-dark">View on GitHub &rarr;</a>
    </div>
    <div class="flex items-center gap-2">
      <span class="h-2 w-2 rounded-full bg-sage-green"></span>
      <span class="font-mono text-xs text-muted-darker">Ready in under 30 seconds. No config needed.</span>
    </div>
  </section>

  {{-- Footer --}}
  <footer class="relative bg-[#050810] px-28 py-16">
    <div class="absolute left-0 top-0 h-px w-full bg-dark-card/20"></div>

    <div class="flex justify-between">
      {{-- Left col --}}
      <div class="flex w-[300px] flex-col gap-4">
        <div class="flex items-center gap-2.5">
          <svg class="h-5 w-5 text-sage-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.9C15.5 4.9 17 3.5 19 2c1 2 2 4.5 1 8-1 3.5-3 5-5.5 7"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
          <span class="font-mono text-lg font-bold text-white">sagey</span>
        </div>
        <p class="text-[13px] leading-relaxed text-muted-darker">A modern WordPress starter theme built on Roots/Sage with AI-powered development agents.</p>
        <span class="font-mono text-[11px] text-dark-border">v1.0.0 &middot; MIT License</span>
      </div>

      {{-- Link columns --}}
      <div class="flex flex-col gap-3">
        <span class="font-mono text-[10px] font-semibold text-dark-border">// product</span>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Documentation</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Getting Started</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">AI Agents</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Changelog</a>
      </div>
      <div class="flex flex-col gap-3">
        <span class="font-mono text-[10px] font-semibold text-dark-border">// community</span>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">GitHub</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Discord</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Twitter / X</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Contributing</a>
      </div>
      <div class="flex flex-col gap-3">
        <span class="font-mono text-[10px] font-semibold text-dark-border">// resources</span>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Blog</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Roots Ecosystem</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Sage Docs</a>
        <a href="#" class="text-[13px] text-muted-dark transition-colors duration-150 hover:text-white">Privacy</a>
      </div>
    </div>

    <div class="mt-10 flex items-center justify-between">
      <span class="font-mono text-[11px] text-dark-border">&copy; {{ date('Y') }} sagey. Built with Roots.</span>
      <span class="font-mono text-[11px] text-dark-border">Made for humans &amp; robots.</span>
    </div>
  </footer>

@endsection
