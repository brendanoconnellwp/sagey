{{-- Hero Variation A — Split Diagonal --}}

<section class="relative min-h-screen overflow-hidden bg-dark-bg">

  {{-- Diagonal Gradient --}}
  <div class="pointer-events-none absolute inset-0">
    <div class="absolute -left-[200px] -top-[300px] h-[1600px] w-[1100px] origin-center rotate-[15deg] bg-gradient-to-b from-sage-green to-emerald-700"></div>
  </div>

  {{-- Decorative circle --}}
  <div class="pointer-events-none absolute left-[28%] top-[31%] hidden lg:block">
    <div class="h-[300px] w-[300px] rounded-full bg-sage-green/[0.18]"></div>
    <div class="absolute left-[10px] top-[10px] h-[280px] w-[280px] rounded-full border-2 border-sage-green/[0.3]"></div>
  </div>

  {{-- Accent dots and squares --}}
  <div class="pointer-events-none absolute inset-0 hidden lg:block">
    <div class="absolute left-[370px] top-[130px] h-3.5 w-3.5 rotate-45 bg-sage-green/[0.15]"></div>
    <div class="absolute right-[220px] bottom-[220px] h-2.5 w-2.5 rotate-[20deg] bg-sage-green/[0.09]"></div>
    <div class="absolute right-[340px] top-[260px] h-5 w-5 rotate-[30deg] border border-sage-green/[0.15]"></div>
    <div class="absolute left-[350px] top-[120px] h-2.5 w-2.5 rotate-[15deg] bg-white/[0.08]"></div>
    <div class="absolute left-[720px] top-[100px] h-1.5 w-1.5 rounded-full bg-sage-green/[0.18]"></div>
    <div class="absolute right-[120px] top-[480px] h-2 w-2 rounded-full bg-sage-green/[0.12]"></div>
    <div class="absolute left-[880px] bottom-[180px] h-2.5 w-2.5 rounded-full bg-sage-green/[0.15]"></div>
    <div class="absolute right-[130px] bottom-[100px] h-3 w-3 rounded-full bg-sage-green/[0.11]"></div>
    <div class="absolute left-[260px] bottom-[100px] h-3 w-3 rounded-full bg-sage-green/[0.18]"></div>
    <div class="absolute right-[90px] top-[440px] h-2.5 w-2.5 rounded-full border-[1.5px] border-sage-green/[0.2]"></div>
    <div class="absolute left-[450px] bottom-[90px] h-3 w-3 rounded-full bg-sage-green/[0.11]"></div>
    <div class="absolute right-[300px] bottom-[120px] h-3.5 w-3.5 rounded-full bg-sage-green/[0.11]"></div>
    <div class="absolute left-[920px] bottom-[280px] h-4 w-4 rotate-[30deg] bg-sage-green/[0.09]"></div>
    <div class="absolute right-[340px] top-[150px] h-[18px] w-[18px] rotate-[60deg] border border-sage-green/[0.12]"></div>
    <div class="absolute right-[100px] top-[190px] h-[18px] w-[18px] rounded-full bg-sage-green/[0.12]"></div>
  </div>

  {{-- Nav Bar --}}
  <nav class="relative z-10 flex h-[72px] items-center justify-between px-12">
    <a href="{{ home_url('/') }}" class="flex items-center gap-2.5">
      <svg class="h-[26px] w-[26px] text-sage-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.9C15.5 4.9 17 3.5 19 2c1 2 2 4.5 1 8-1 3.5-3 5-5.5 7"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
      <span class="text-[22px] font-bold text-white">sagey</span>
    </a>

    <div class="hidden items-center gap-8 md:flex">
      <a href="#features" class="text-[15px] text-white/70 transition-colors duration-150 hover:text-white">Features</a>
      <a href="#" class="text-[15px] text-white/70 transition-colors duration-150 hover:text-white">Docs</a>
      <a href="#" class="text-[15px] text-white/70 transition-colors duration-150 hover:text-white">Pricing</a>
      <a href="#" class="text-[15px] text-white/70 transition-colors duration-150 hover:text-white">Blog</a>
    </div>

    <div class="hidden items-center gap-4 md:flex">
      <a href="#" class="text-[15px] font-medium text-white/80 transition-colors duration-150 hover:text-white">Sign In</a>
      <a href="#get-started" class="rounded-md bg-sage-green px-6 py-2.5 text-[15px] font-semibold text-dark-bg transition-colors duration-150 hover:bg-sage-green/90">Get Started</a>
    </div>
  </nav>

  {{-- Giant Vertical S A G E --}}
  <div class="pointer-events-none relative z-10 select-none px-16 pt-8 lg:px-24" aria-hidden="true">
    <div class="flex flex-col">
      <span class="text-[clamp(100px,11vw,160px)] font-black leading-[0.85] text-white">S</span>
      <span class="text-[clamp(100px,11vw,160px)] font-black leading-[0.85] text-white">A</span>
      <span class="text-[clamp(100px,11vw,160px)] font-black leading-[0.85] text-white">G</span>
      <span class="text-[clamp(100px,11vw,160px)] font-black leading-[0.85] text-white">E</span>
    </div>
  </div>

  {{-- Right side content --}}
  <div class="absolute right-12 top-[280px] z-20 hidden max-w-md flex-col gap-5 lg:flex xl:right-20">

    {{-- Badge --}}
    <div class="flex w-fit items-center gap-2 rounded-full border border-sage-green/[0.27] px-3.5 py-1.5">
      <span class="h-2 w-2 rounded-full bg-sage-green"></span>
      <span class="text-xs font-medium text-sage-green/80">v1.0 — Now in Beta</span>
    </div>

    {{-- Tagline --}}
    <h1 class="text-[26px] font-light leading-snug text-white/80">
      WordPress, reimagined<br>with AI agents.
    </h1>

    {{-- Terminal block --}}
    <div class="flex items-center rounded-lg border-[1.5px] border-sage-green bg-[#0D1321] px-5 py-3.5">
      <code class="font-mono text-base text-sage-green">$ npx create-sagey my-site</code>
    </div>

    {{-- Subtitle --}}
    <p class="text-[15px] leading-relaxed text-white/[0.33]">
      AI-powered scaffolding for the modern<br>WordPress developer.
    </p>
  </div>

</section>
