{{--
  Template Name: Landing Page
--}}

@extends('layouts.landing')

@section('content')

  {{-- Hero Section (Variant B — Typographic Brutalist) --}}
  <x-landing.hero-b />

  {{-- The Stack Section --}}
  <section id="stack" class="flex flex-col items-center gap-10 px-8 py-16 lg:px-28">
    <div class="flex flex-col items-center gap-3">
      <span class="font-mono text-[11px] font-bold uppercase tracking-[0.15em] text-sage-green">The Stack</span>
      <h2 class="text-center text-4xl font-bold text-white">Built on battle-tested tools.</h2>
      <p class="text-center text-base text-muted">Every layer of your theme is modern, composable, and production-ready.</p>
    </div>

    <div class="grid w-full max-w-5xl grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
      <x-landing.stack-card icon="layers" title="Sage 11" description="Modern WordPress starter theme with a refined development workflow." />
      <x-landing.stack-card icon="code" title="Laravel Blade" description="Expressive templating engine with components, slots, and directives." />
      <x-landing.stack-card icon="palette" title="Tailwind CSS v4" description="Utility-first CSS framework with zero-config, lightning-fast builds." />
      <x-landing.stack-card icon="box" title="Acorn" description="Laravel-powered framework for elegant WordPress plugin & theme development." />
      <x-landing.stack-card icon="bot" title="AI Agents" description="Intelligent assistants that scaffold blocks, write logic, and debug your theme." highlighted="true" />
    </div>
  </section>

  {{-- Meet Your Agent Section --}}
  <section id="agent" class="flex flex-col items-center gap-10 px-8 py-16 lg:px-28">
    <div class="flex flex-col items-center gap-3">
      <span class="font-mono text-[11px] font-bold uppercase tracking-[0.15em] text-sage-green">Meet Your Agent</span>
      <h2 class="text-center text-4xl font-bold text-white">Your AI pair programmer, built in.</h2>
      <p class="max-w-xl text-center text-base text-muted">Ask it to scaffold blocks, generate Blade templates, or debug your theme — right from the CLI.</p>
    </div>

    {{-- Chat Window --}}
    <div class="w-full max-w-2xl overflow-hidden rounded-xl border border-dark-card bg-dark-surface">
      <div class="flex items-center gap-2.5 bg-dark-card px-5 py-3.5">
        <svg class="h-[18px] w-[18px] text-sage-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
        <span class="font-mono text-[13px] font-semibold text-sage-green">sagey-agent</span>
        <span class="font-mono text-[11px] font-medium text-muted-dark">online</span>
      </div>

      <div class="flex flex-col gap-5 px-5 py-6">
        {{-- User message --}}
        <div class="flex justify-end">
          <div class="flex flex-col gap-1 rounded-xl rounded-br-sm bg-dark-card px-4 py-3">
            <p class="max-w-sm text-sm leading-relaxed text-white">Create a hero block with a headline, subline, and CTA button</p>
            <span class="font-mono text-[10px] font-medium text-muted-darker">you &middot; just now</span>
          </div>
        </div>

        {{-- Bot message --}}
        <div class="flex gap-2.5">
          <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-sage-green-dim">
            <svg class="h-4 w-4 text-sage-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
          </div>
          <div class="flex flex-col gap-2.5 rounded-xl rounded-tl-sm bg-dark-card px-4 py-3">
            <p class="text-sm leading-relaxed text-white">Here's your hero block with Blade template:</p>
            <div class="flex flex-col gap-1 rounded-lg bg-dark-bg px-4 py-3.5">
              <code class="font-mono text-xs text-muted-dark">&lt;section class="hero"&gt;</code>
              <code class="font-mono text-xs text-sage-green">&nbsp;&nbsp;&lt;h1&gt;&#123;&#123; $headline &#125;&#125;&lt;/h1&gt;</code>
              <code class="font-mono text-xs text-sage-green">&nbsp;&nbsp;&lt;p&gt;&#123;&#123; $subline &#125;&#125;&lt;/p&gt;</code>
              <code class="font-mono text-xs text-muted">&nbsp;&nbsp;&lt;x-button :href="$cta_url"&gt;</code>
              <code class="font-mono text-xs text-sage-green">&nbsp;&nbsp;&nbsp;&nbsp;&#123;&#123; $cta_label &#125;&#125;</code>
              <code class="font-mono text-xs text-muted">&nbsp;&nbsp;&lt;/x-button&gt;</code>
              <code class="font-mono text-xs text-muted-dark">&lt;/section&gt;</code>
            </div>
            <span class="font-mono text-[10px] font-medium text-muted-darker">sagey-agent &middot; 2s ago</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Features Section --}}
  <section id="features" class="flex flex-col items-center gap-10 px-8 py-16 lg:px-28">
    <div class="flex flex-col items-center gap-3">
      <span class="font-mono text-[11px] font-bold uppercase tracking-[0.15em] text-sage-green">Features</span>
      <h2 class="text-center text-4xl font-bold text-white">Everything you need. Nothing you don't.</h2>
    </div>

    <div class="grid w-full max-w-5xl grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <x-landing.feature-card icon="file-code" title="Blade Templates" description="Expressive, component-driven templates with slots, directives, and inheritance." />
      <x-landing.feature-card icon="paintbrush" title="Tailwind v4" description="Next-gen utility CSS with zero config, cascade layers, and lightning builds." />
      <x-landing.feature-card icon="terminal" title="WP-CLI Ready" description="First-class CLI integration. Manage themes, scaffold blocks, deploy — all terminal-native." />
      <x-landing.feature-card icon="refresh-cw" title="Hot Reload" description="Instant browser refresh on save. See changes in real-time as you code." />
      <x-landing.feature-card icon="sparkles" title="AI Scaffolding" description="Describe what you need, and agents generate blocks, templates, and styles." />
      <x-landing.feature-card icon="zap" title="Zero Config" description="Sensible defaults out of the box. Start building immediately, customize later." />
    </div>
  </section>

  {{-- Footer --}}
  <footer class="flex flex-col gap-6 bg-dark-surface px-8 py-12 lg:px-28">
    <div class="mx-auto flex w-full max-w-5xl items-center justify-between">
      <div class="flex items-center gap-2.5">
        <svg class="h-5 w-5 text-sage-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.9C15.5 4.9 17 3.5 19 2c1 2 2 4.5 1 8-1 3.5-3 5-5.5 7"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
        <span class="font-mono text-lg font-bold text-white">sagey</span>
      </div>
      <div class="flex items-center gap-8">
        <a href="https://github.com" class="text-[13px] font-medium text-muted transition-colors duration-150 hover:text-white">GitHub</a>
        <a href="#" class="text-[13px] font-medium text-muted transition-colors duration-150 hover:text-white">Docs</a>
        <a href="#" class="text-[13px] font-medium text-muted transition-colors duration-150 hover:text-white">Discord</a>
      </div>
    </div>

    <div class="mx-auto h-px w-full max-w-5xl bg-dark-card"></div>

    <div class="mx-auto flex w-full max-w-5xl items-center justify-between">
      <span class="font-mono text-xs font-medium text-muted-dark">Built with &#127807; and robots.</span>
      <span class="font-mono text-[11px] text-muted-darker">&copy; {{ date('Y') }} sagey. Open source under MIT.</span>
    </div>
  </footer>

@endsection
