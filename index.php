<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interstellar Prints Global Ltd. — Your Brand, Everywhere</title>
    <meta name="description" content="End-to-End Corporate Supply, Custom Merchandise & General Logistics. Premium customized stationery, apparel production, and nationwide delivery services.">
    <meta property="og:title" content="Interstellar Prints Global Ltd.">
    <meta property="og:description" content="End-to-End Corporate Supply, Custom Merchandise & General Logistics.">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': {
                            950: '#01040a', 900: '#020b1a', 800: '#03162e', 700: '#052045',
                            600: '#0a2d5c', 500: '#0d3a73', 400: '#1a4d8c', 300: '#2d6bb0',
                            200: '#5a9bd4', 100: '#a8cce8', 50: '#e6f0f9',
                        },
                        'cosmic': {
                            500: '#0ea5e9', 400: '#38bdf8', 300: '#7dd3fc',
                            200: '#bae6fd', 100: '#e0f2fe',
                        },
                        'silver': {
                            400: '#9ca3af', 300: '#b8c0cc', 200: '#d1d5db',
                            100: '#e5e7eb', 50: '#f3f4f6',
                        }
                    },
                    fontFamily: {
                        'display': ['Montserrat', 'sans-serif'],
                        'body': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Montserrat', sans-serif; }
        .hero-bg { background: linear-gradient(135deg, #01040a 0%, #03162e 40%, #052045 70%, #0a2d5c 100%); }
        .glass-card { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
        .gradient-text { background: linear-gradient(135deg, #fff 0%, #7dd3fc 50%, #38bdf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-primary { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 40px -10px rgba(14,165,233,0.5); }
        .btn-secondary { border: 1.5px solid rgba(255,255,255,0.3); transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.6); }
        .section-divider { height: 1px; background: linear-gradient(90deg, transparent 0%, rgba(14,165,233,0.3) 50%, transparent 100%); }
        .card-hover { transition: all 0.4s cubic-bezier(0.4,0,0.2,1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(2,11,26,0.25); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: linear-gradient(90deg, #0ea5e9, #38bdf8); transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }
        .floating { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .pulse-glow { animation: pulseGlow 3s ease-in-out infinite; }
        @keyframes pulseGlow { 0%,100% { box-shadow: 0 0 20px rgba(14,165,233,0.2); } 50% { box-shadow: 0 0 40px rgba(14,165,233,0.4); } }
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.4,0,0.2,1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .tab-active { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: white; }
        .tab-inactive { background: transparent; color: #6b7280; border: 1px solid #e5e7eb; }
        .tab-inactive:hover { background: #f3f4f6; color: #1f2937; }
        .form-input { transition: all 0.3s ease; }
        .form-input:focus { border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.15); }
        .service-card { position: relative; overflow: hidden; }
        .service-card::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(14,165,233,0.05), transparent); transition: left 0.6s ease; }
        .service-card:hover::before { left: 100%; }
        .counter-bg { background: linear-gradient(135deg, #020b1a 0%, #03162e 100%); }
        .quote-section { background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); }
        .mobile-menu { display: none; }
        .mobile-menu.open { display: block; }
        @media (max-width: 1024px) { .process-step::after { display: none; } }

        /* ─── X FAB ─────────────────────────────────────────────────── */
        .x-fab { position: fixed; bottom: 28px; right: 28px; z-index: 60; width: 56px; height: 56px; border-radius: 50%; background: #000; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 20px rgba(0,0,0,0.3); transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
        .x-fab:hover { transform: scale(1.1); box-shadow: 0 6px 30px rgba(0,0,0,0.4); }
        .x-fab::before { content: ''; position: absolute; inset: -4px; border-radius: 50%; background: linear-gradient(135deg, #38bdf8, #0ea5e9); z-index: -1; opacity: 0; transition: opacity 0.3s; }
        .x-fab:hover::before { opacity: 1; }
        @media (max-width: 768px) { .x-fab { bottom: 20px; right: 20px; width: 48px; height: 48px; } }

        /* ─── Gallery ───────────────────────────────────────────────── */
        .gallery-item { overflow: hidden; border-radius: 1rem; cursor: pointer; }
        .gallery-item img { transition: transform 0.5s cubic-bezier(0.4,0,0.2,1); width: 100%; height: 100%; object-fit: cover; }
        .gallery-item:hover img { transform: scale(1.1); }
        .gallery-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(1,4,10,0.9) 0%, transparent 60%); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: flex-end; padding: 1.5rem; }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        .gallery-filter-active { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: white; }
        .gallery-filter-inactive { background: transparent; color: #6b7280; border: 1px solid #e5e7eb; }
        .gallery-filter-inactive:hover { background: #f3f4f6; color: #1f2937; }

        /* ─── Lightbox ──────────────────────────────────────────────── */
        .lightbox { display: none; position: fixed; inset: 0; z-index: 100; background: rgba(1,4,10,0.95); justify-content: center; align-items: center; padding: 2rem; }
        .lightbox.open { display: flex; }
        .lightbox img { max-width: 90%; max-height: 85vh; border-radius: 1rem; }

        /* ─── Honeypot (hidden from humans) ────────────────────────── */
        .hp-field { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }

        /* ─── Twitter Timeline ─────────────────────────────────────── */
        .twitter-section { background: linear-gradient(135deg, #020b1a 0%, #03162e 100%); }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased overflow-x-hidden">

<!-- NAVIGATION -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-800 to-navy-950 flex items-center justify-center border border-cosmic-400/30 group-hover:border-cosmic-400/60 transition-all">
                    <svg class="w-6 h-6 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/></svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-display font-bold text-lg leading-tight text-white tracking-wide">INTERSTELLAR</span>
                    <span class="font-display text-[10px] tracking-[0.3em] text-cosmic-400 leading-tight">PRINTS GLOBAL</span>
                </div>
            </a>
            <div class="hidden lg:flex items-center gap-8">
                <a href="#stationery" class="nav-link text-sm font-medium text-gray-300 hover:text-white transition-colors">Stationery Supply</a>
                <a href="#merchandise" class="nav-link text-sm font-medium text-gray-300 hover:text-white transition-colors">Custom Merchandise</a>
                <a href="#production" class="nav-link text-sm font-medium text-gray-300 hover:text-white transition-colors">Production Tech</a>
                <a href="#gallery" class="nav-link text-sm font-medium text-gray-300 hover:text-white transition-colors">Gallery</a>
                <a href="#logistics" class="nav-link text-sm font-medium text-gray-300 hover:text-white transition-colors">Logistics & Delivery</a>
                <a href="#quote" class="btn-primary px-6 py-2.5 rounded-full text-sm font-semibold text-white">Request a Quote</a>
            </div>
            <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors" aria-label="Toggle menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <div id="mobile-menu" class="mobile-menu lg:hidden bg-navy-950/95 backdrop-blur-xl border-t border-white/10">
        <div class="px-4 py-6 space-y-4">
            <a href="#stationery" class="block py-2 text-gray-300 hover:text-cosmic-400 transition-colors">Stationery Supply</a>
            <a href="#merchandise" class="block py-2 text-gray-300 hover:text-cosmic-400 transition-colors">Custom Merchandise</a>
            <a href="#production" class="block py-2 text-gray-300 hover:text-cosmic-400 transition-colors">Production Tech</a>
            <a href="#gallery" class="block py-2 text-gray-300 hover:text-cosmic-400 transition-colors">Gallery</a>
            <a href="#logistics" class="block py-2 text-gray-300 hover:text-cosmic-400 transition-colors">Logistics & Delivery</a>
            <a href="#quote" class="block btn-primary px-6 py-3 rounded-full text-center text-white font-semibold mt-4">Request a Quote</a>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="hero-bg min-h-screen flex items-center relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-cosmic-500/10 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-navy-600/20 rounded-full blur-3xl floating" style="animation-delay:-3s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cosmic-400/5 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:linear-gradient(rgba(255,255,255,0.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.1) 1px,transparent 1px);background-size:60px 60px;"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-20">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card mb-8">
                    <span class="w-2 h-2 rounded-full bg-cosmic-400 pulse-glow"></span>
                    <span class="text-xs font-medium text-cosmic-300 tracking-wider uppercase">Premium Brand Solutions</span>
                </div>
                <h1 class="font-display font-bold text-4xl sm:text-5xl lg:text-6xl xl:text-7xl text-white leading-[1.1] mb-6">
                    End-to-End<br><span class="gradient-text">Corporate Supply,</span><br>Custom Merchandise<br><span class="text-cosmic-300">& General Logistics.</span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-400 leading-relaxed mb-10 max-w-xl mx-auto lg:mx-0">
                    From premium customized stationery and apparel production to nationwide general delivery services — we power your business touchpoints.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#quote" class="btn-primary px-8 py-4 rounded-full text-white font-semibold text-sm tracking-wide flex items-center justify-center gap-2" onclick="switchQuoteTab('stationery')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Order Supplies
                    </a>
                    <a href="#quote" class="btn-secondary px-8 py-4 rounded-full text-white font-semibold text-sm tracking-wide flex items-center justify-center gap-2" onclick="switchQuoteTab('logistics')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        Book a Delivery
                    </a>
                </div>
                <div class="mt-16 flex flex-wrap items-center gap-8 justify-center lg:justify-start text-gray-500">
                    <div class="flex items-center gap-2"><svg class="w-5 h-5 text-cosmic-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span class="text-sm">Nationwide Delivery</span></div>
                    <div class="flex items-center gap-2"><svg class="w-5 h-5 text-cosmic-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span class="text-sm">In-House Production</span></div>
                    <div class="flex items-center gap-2"><svg class="w-5 h-5 text-cosmic-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span class="text-sm">Bulk Orders Welcome</span></div>
                </div>
            </div>
            <div class="hidden lg:block relative">
                <div class="relative">
                    <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl shadow-navy-900/50 border border-white/10">
                        <img src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=800&h=600&fit=crop" alt="Premium branded corporate merchandise and stationery" class="w-full h-auto object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/60 via-transparent to-transparent"></div>
                    </div>
                    <div class="absolute -top-6 -right-6 glass-card rounded-xl p-4 floating" style="animation-delay:-1s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-cosmic-500/20 flex items-center justify-center"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div><p class="text-xs text-gray-400">Quality Assured</p><p class="text-sm font-semibold text-white">ISO Certified</p></div>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -left-6 glass-card rounded-xl p-4 floating" style="animation-delay:-2s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center"><svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                            <div><p class="text-xs text-gray-400">Fast Turnaround</p><p class="text-sm font-semibold text-white">48-72 Hours</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-gray-500">
        <span class="text-xs tracking-widest uppercase">Scroll</span>
        <div class="w-6 h-10 rounded-full border-2 border-gray-600 flex justify-center pt-2"><div class="w-1.5 h-3 bg-cosmic-400 rounded-full animate-bounce"></div></div>
    </div>
</section>

<!-- CUSTOMIZED STATIONERY SUPPLY DIVISION -->
<section id="stationery" class="py-24 lg:py-32 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-navy-950 text-white mb-6">
                <svg class="w-4 h-4 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="text-xs font-semibold text-cosmic-300 tracking-wider uppercase">Stationery Division</span>
            </div>
            <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-navy-950 mb-6 leading-tight">
                Customized Stationery &<br><span class="text-cosmic-500">Corporate Supply</span>
            </h2>
            <p class="text-lg text-gray-600 leading-relaxed">
                From letterheads to corporate diaries, we supply premium branded stationery that elevates your corporate identity at every touchpoint.
            </p>
        </div>
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 mb-12">
            <div class="reveal">
                <div class="bg-gradient-to-br from-navy-950 to-navy-900 rounded-2xl p-8 lg:p-10 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-cosmic-500/10 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-xl bg-cosmic-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="font-display font-bold text-2xl">Corporate Stationery Sets</h3>
                        </div>
                        <p class="text-gray-400 mb-8 leading-relaxed">Complete branded stationery packages designed for corporate identity consistency across all touchpoints.</p>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>
                                <div><h4 class="font-semibold text-sm mb-1">Corporate Diaries</h4><p class="text-xs text-gray-500">Leather-bound, debossed with your logo</p></div>
                            </div>
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></div>
                                <div><h4 class="font-semibold text-sm mb-1">Executive Notepads</h4><p class="text-xs text-gray-500">Premium paper, custom covers, branded</p></div>
                            </div>
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                                <div><h4 class="font-semibold text-sm mb-1">Letterheads & Envelopes</h4><p class="text-xs text-gray-500">Full-color, watermarked, matching sets</p></div>
                            </div>
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg></div>
                                <div><h4 class="font-semibold text-sm mb-1">Business Cards</h4><p class="text-xs text-gray-500">Spot UV, foil stamping, premium stock</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="reveal" style="transition-delay:0.2s;">
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 border border-gray-200 h-full">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-navy-950 flex items-center justify-center">
                            <svg class="w-6 h-6 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-navy-950">Branded Corporate Gifts</h3>
                    </div>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">Premium gift items customized with your brand for client appreciation, employee recognition, and corporate events.</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-white border border-gray-100 shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-cosmic-100 flex items-center justify-center shrink-0"><svg class="w-4 h-4 text-cosmic-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/></svg></div>
                            <span class="text-sm font-medium text-gray-700">Custom Mugs & Drinkware</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-white border border-gray-100 shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-cosmic-100 flex items-center justify-center shrink-0"><svg class="w-4 h-4 text-cosmic-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd"/></svg></div>
                            <span class="text-sm font-medium text-gray-700">Water Bottles & Flasks</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-white border border-gray-100 shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-cosmic-100 flex items-center justify-center shrink-0"><svg class="w-4 h-4 text-cosmic-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.923 4.615a.5.5 0 01-.966.258L11.22 15H8.78l-.923 4.615a.5.5 0 01-.966-.258L7.78 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/></svg></div>
                            <span class="text-sm font-medium text-gray-700">Tech Gadgets & Accessories</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-white border border-gray-100 shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-cosmic-100 flex items-center justify-center shrink-0"><svg class="w-4 h-4 text-cosmic-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd"/></svg></div>
                            <span class="text-sm font-medium text-gray-700">Executive Hampers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 reveal">
            <div class="bg-gray-50 rounded-xl p-6 text-center border border-gray-100 hover:border-cosmic-300 hover:shadow-lg transition-all card-hover">
                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-navy-950 flex items-center justify-center"><svg class="w-6 h-6 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></div>
                <h4 class="font-semibold text-sm text-navy-950">Pens & Writing</h4><p class="text-xs text-gray-500 mt-1">Metal, plastic, eco-friendly</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-6 text-center border border-gray-100 hover:border-cosmic-300 hover:shadow-lg transition-all card-hover">
                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-navy-950 flex items-center justify-center"><svg class="w-6 h-6 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg></div>
                <h4 class="font-semibold text-sm text-navy-950">Files & Folders</h4><p class="text-xs text-gray-500 mt-1">Ring files, box files, expanding</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-6 text-center border border-gray-100 hover:border-cosmic-300 hover:shadow-lg transition-all card-hover">
                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-navy-950 flex items-center justify-center"><svg class="w-6 h-6 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
                <h4 class="font-semibold text-sm text-navy-950">Custom Packaging</h4><p class="text-xs text-gray-500 mt-1">Boxes, sleeves, custom labels</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-6 text-center border border-gray-100 hover:border-cosmic-300 hover:shadow-lg transition-all card-hover">
                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-navy-950 flex items-center justify-center"><svg class="w-6 h-6 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg></div>
                <h4 class="font-semibold text-sm text-navy-950">Branded Tote Bags</h4><p class="text-xs text-gray-500 mt-1">Canvas, jute, eco materials</p>
            </div>
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- MERCHANDISE BRANDING & CUSTOM APPAREL -->
<section id="merchandise" class="py-24 lg:py-32 bg-gray-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-navy-950 text-white mb-6">
                <svg class="w-4 h-4 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                <span class="text-xs font-semibold text-cosmic-300 tracking-wider uppercase">Production Division</span>
            </div>
            <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-navy-950 mb-6 leading-tight">
                Merchandise Branding &<br><span class="text-cosmic-500">Custom Apparel</span>
            </h2>
            <p class="text-lg text-gray-600 leading-relaxed">
                Our in-house manufacturing facility is equipped with state-of-the-art production technology. We handle the entire workflow from design to finished product — ensuring quality control at every stage.
            </p>
        </div>
        <div id="production" class="mb-20">
            <h3 class="font-display font-bold text-xl text-navy-950 text-center mb-10 reveal">Our Production Equipment Workflow</h3>
            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm card-hover reveal">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-navy-950 to-navy-800 flex items-center justify-center mb-6 shadow-lg shadow-navy-900/20"><span class="font-display font-bold text-2xl text-cosmic-400">01</span></div>
                    <h4 class="font-display font-bold text-xl text-navy-950 mb-3">DTF Printing</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">Direct-to-Film printing technology enables full-color graphics on virtually any fabric type. Vibrant, durable prints with exceptional wash resistance.</p>
                    <div class="flex flex-wrap gap-2"><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">Full-Color</span><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">Any Fabric</span><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">High Detail</span></div>
                </div>
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm card-hover reveal" style="transition-delay:0.15s;">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-navy-950 to-navy-800 flex items-center justify-center mb-6 shadow-lg shadow-navy-900/20"><span class="font-display font-bold text-2xl text-cosmic-400">02</span></div>
                    <h4 class="font-display font-bold text-xl text-navy-950 mb-3">Plotting Machine</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">Precision vinyl cutting for logos, lettering, and stickers. Computer-controlled blade accuracy ensures clean edges and intricate designs every time.</p>
                    <div class="flex flex-wrap gap-2"><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">Precision Cut</span><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">Logos</span><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">Stickers</span></div>
                </div>
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm card-hover reveal" style="transition-delay:0.3s;">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-navy-950 to-navy-800 flex items-center justify-center mb-6 shadow-lg shadow-navy-900/20"><span class="font-display font-bold text-2xl text-cosmic-400">03</span></div>
                    <h4 class="font-display font-bold text-xl text-navy-950 mb-3">Industrial Heat Press</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">High-temperature industrial heat press for permanent fusion onto garments, bags, and flat surfaces. Ensures long-lasting adhesion and professional finish.</p>
                    <div class="flex flex-wrap gap-2"><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">Permanent</span><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">Garments</span><span class="px-3 py-1 rounded-full bg-cosmic-50 text-cosmic-700 text-xs font-medium">Bags</span></div>
                </div>
            </div>
        </div>
        <div>
            <h3 class="font-display font-bold text-xl text-navy-950 text-center mb-10 reveal">Instant Offerings</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm card-hover reveal">
                    <div class="h-48 bg-gradient-to-br from-navy-900 to-navy-800 flex items-center justify-center relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400&h=300&fit=crop" alt="Custom Corporate Apparel" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4"><span class="px-3 py-1 rounded-full bg-cosmic-500/20 text-cosmic-300 text-xs font-medium border border-cosmic-500/30">Apparel</span></div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-display font-bold text-lg text-navy-950 mb-2">Custom Corporate Apparel</h4>
                        <p class="text-sm text-gray-600 mb-4">Professional uniforms, branded hoodies, and polo shirts tailored to your corporate identity.</p>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Corporate Uniforms</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Branded Hoodies</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Polo Shirts</li>
                        </ul>
                    </div>
                </div>
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm card-hover reveal" style="transition-delay:0.1s;">
                    <div class="h-48 bg-gradient-to-br from-navy-900 to-navy-800 flex items-center justify-center relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400&h=300&fit=crop" alt="Event & Promotional Wear" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4"><span class="px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs font-medium border border-purple-500/30">Events</span></div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-display font-bold text-lg text-navy-950 mb-2">Event & Promotional Wear</h4>
                        <p class="text-sm text-gray-600 mb-4">Custom apparel for weddings, political rallies, sports teams, and promotional campaigns.</p>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Wedding Shirts</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Campaign Rally Wear</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Sports Team Jerseys</li>
                        </ul>
                    </div>
                </div>
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm card-hover reveal" style="transition-delay:0.2s;">
                    <div class="h-48 bg-gradient-to-br from-navy-900 to-navy-800 flex items-center justify-center relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1597484661643-1367qu5f9f42?w=400&h=300&fit=crop" alt="Branded Tote Bags" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4"><span class="px-3 py-1 rounded-full bg-green-500/20 text-green-300 text-xs font-medium border border-green-500/30">Eco</span></div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-display font-bold text-lg text-navy-950 mb-2">Branded Tote Bags</h4>
                        <p class="text-sm text-gray-600 mb-4">Durable canvas and jute tote bags with your custom design — perfect for retail and events.</p>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Canvas Totes</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Jute Bags</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Custom Prints</li>
                        </ul>
                    </div>
                </div>
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm card-hover reveal" style="transition-delay:0.3s;">
                    <div class="h-48 bg-gradient-to-br from-navy-900 to-navy-800 flex items-center justify-center relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1606107557195-92e5f51e2c59?w=400&h=300&fit=crop" alt="Custom Packaging Labels" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4"><span class="px-3 py-1 rounded-full bg-orange-500/20 text-orange-300 text-xs font-medium border border-orange-500/30">Packaging</span></div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-display font-bold text-lg text-navy-950 mb-2">Custom Packaging Labels</h4>
                        <p class="text-sm text-gray-600 mb-4">Custom-printed labels and packaging materials that make your products stand out.</p>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Product Labels</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Custom Boxes</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cosmic-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Branded Sleeves</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- PRODUCT GALLERY SECTION -->
<section id="gallery" class="py-24 lg:py-32 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-cosmic-50 border border-cosmic-200 mb-6">
                <svg class="w-4 h-4 text-cosmic-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-xs font-semibold text-cosmic-600 tracking-wider uppercase">Our Portfolio</span>
            </div>
            <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-navy-950 mb-6 leading-tight">
                Mockups, Designs<br><span class="text-cosmic-500">& Our Works</span>
            </h2>
            <p class="text-lg text-gray-600 leading-relaxed">
                Explore our portfolio of custom designs, product mockups, and completed projects. See the quality we bring to every order.
            </p>
        </div>

        <!-- Gallery Filter -->
        <div class="flex flex-wrap justify-center gap-3 mb-10 reveal">
            <button class="gallery-filter px-5 py-2 rounded-full text-sm font-semibold transition-all gallery-filter-active" onclick="filterGallery('all', this)">All Works</button>
            <button class="gallery-filter px-5 py-2 rounded-full text-sm font-semibold transition-all gallery-filter-inactive" onclick="filterGallery('mockups', this)">Mockups</button>
            <button class="gallery-filter px-5 py-2 rounded-full text-sm font-semibold transition-all gallery-filter-inactive" onclick="filterGallery('designs', this)">Designs</button>
            <button class="gallery-filter px-5 py-2 rounded-full text-sm font-semibold transition-all gallery-filter-inactive" onclick="filterGallery('works', this)">Completed Works</button>
        </div>

        <!-- Gallery Grid -->
        <!--
            ─── HOW TO ADD YOUR OWN IMAGES ───────────────────────────
            Upload images to the gallery/ folder on your telehosting server.
            Then update the src paths below to: gallery/your-image.jpg
            Replace the placeholder data-category values:
              - "mockups"  for design mockups
              - "designs"  for artwork/designs
              - "works"    for completed project photos
        -->
        <div id="gallery-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Mockups -->
            <div class="gallery-item relative reveal" data-category="mockups" onclick="openLightbox(this)">
                <img src="gallery/mockup-1.jpg" alt="Business Card Mockup" onerror="this.src='https://images.unsplash.com/photo-1572044162444-ad8993fd3c1a?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-cosmic-500/20 text-cosmic-300 text-xs font-medium border border-cosmic-500/30 mb-2 inline-block">Mockup</span>
                        <h4 class="font-display font-bold text-white text-lg">Business Card Design</h4>
                        <p class="text-gray-400 text-sm">Spot UV & foil stamping</p>
                    </div>
                </div>
            </div>
            <div class="gallery-item relative reveal" data-category="mockups" onclick="openLightbox(this)" style="transition-delay:0.1s;">
                <img src="gallery/mockup-2.jpg" alt="T-Shirt Mockup" onerror="this.src='https://images.unsplash.com/photo-1581655355564-1577e2f31125?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-cosmic-500/20 text-cosmic-300 text-xs font-medium border border-cosmic-500/30 mb-2 inline-block">Mockup</span>
                        <h4 class="font-display font-bold text-white text-lg">DTF T-Shirt Print</h4>
                        <p class="text-gray-400 text-sm">Full-color custom apparel</p>
                    </div>
                </div>
            </div>
            <div class="gallery-item relative reveal" data-category="mockups" onclick="openLightbox(this)" style="transition-delay:0.2s;">
                <img src="gallery/mockup-3.jpg" alt="Branded Mug Mockup" onerror="this.src='https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-cosmic-500/20 text-cosmic-300 text-xs font-medium border border-cosmic-500/30 mb-2 inline-block">Mockup</span>
                        <h4 class="font-display font-bold text-white text-lg">Branded Mug</h4>
                        <p class="text-gray-400 text-sm">Corporate gift mockup</p>
                    </div>
                </div>
            </div>

            <!-- Designs -->
            <div class="gallery-item relative reveal" data-category="designs" onclick="openLightbox(this)">
                <img src="gallery/design-1.jpg" alt="Logo Design" onerror="this.src='https://images.unsplash.com/photo-1626785774573-4b799315345d?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs font-medium border border-purple-500/30 mb-2 inline-block">Design</span>
                        <h4 class="font-display font-bold text-white text-lg">Logo Concept</h4>
                        <p class="text-gray-400 text-sm">Corporate identity design</p>
                    </div>
                </div>
            </div>
            <div class="gallery-item relative reveal" data-category="designs" onclick="openLightbox(this)" style="transition-delay:0.1s;">
                <img src="gallery/design-2.jpg" alt="Flyer Design" onerror="this.src='https://images.unsplash.com/photo-1626785774625-9173f2c0e6b6?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs font-medium border border-purple-500/30 mb-2 inline-block">Design</span>
                        <h4 class="font-display font-bold text-white text-lg">Event Flyer</h4>
                        <p class="text-gray-400 text-sm">Campaign promotional design</p>
                    </div>
                </div>
            </div>
            <div class="gallery-item relative reveal" data-category="designs" onclick="openLightbox(this)" style="transition-delay:0.2s;">
                <img src="gallery/design-3.jpg" alt="Stationery Set Design" onerror="this.src='https://images.unsplash.com/photo-1586289228981-7c7d0a3f3c79?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs font-medium border border-purple-500/30 mb-2 inline-block">Design</span>
                        <h4 class="font-display font-bold text-white text-lg">Stationery Suite</h4>
                        <p class="text-gray-400 text-sm">Complete branding package</p>
                    </div>
                </div>
            </div>

            <!-- Completed Works -->
            <div class="gallery-item relative reveal" data-category="works" onclick="openLightbox(this)">
                <img src="gallery/work-1.jpg" alt="Completed Uniform Order" onerror="this.src='https://images.unsplash.com/photo-1542838132-92c533004ea2?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-green-500/20 text-green-300 text-xs font-medium border border-green-500/30 mb-2 inline-block">Completed</span>
                        <h4 class="font-display font-bold text-white text-lg">Corporate Uniforms</h4>
                        <p class="text-gray-400 text-sm">500 units delivered</p>
                    </div>
                </div>
            </div>
            <div class="gallery-item relative reveal" data-category="works" onclick="openLightbox(this)" style="transition-delay:0.1s;">
                <img src="gallery/work-2.jpg" alt="Completed Diary Order" onerror="this.src='https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-green-500/20 text-green-300 text-xs font-medium border border-green-500/30 mb-2 inline-block">Completed</span>
                        <h4 class="font-display font-bold text-white text-lg">Corporate Diaries</h4>
                        <p class="text-gray-400 text-sm">Leather-bound, debossed</p>
                    </div>
                </div>
            </div>
            <div class="gallery-item relative reveal" data-category="works" onclick="openLightbox(this)" style="transition-delay:0.2s;">
                <img src="gallery/work-3.jpg" alt="Completed Tote Bag Order" onerror="this.src='https://images.unsplash.com/photo-1597484661643-1367qu5f9f42?w=600&h=600&fit=crop'">
                <div class="gallery-overlay">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-green-500/20 text-green-300 text-xs font-medium border border-green-500/30 mb-2 inline-block">Completed</span>
                        <h4 class="font-display font-bold text-white text-lg">Branded Tote Bags</h4>
                        <p class="text-gray-400 text-sm">Canvas, custom print run</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery CTA -->
        <div class="text-center mt-12 reveal">
            <p class="text-gray-500 text-sm mb-4">Want something like this for your brand?</p>
            <a href="#quote" class="btn-primary inline-flex px-8 py-3 rounded-full text-white font-semibold text-sm items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Request a Quote
            </a>
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <button class="absolute top-6 right-6 text-white hover:text-cosmic-400 transition-colors" onclick="closeLightbox()" aria-label="Close">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <img id="lightbox-img" src="" alt="Gallery image">
</div>

<div class="section-divider"></div>

<!-- GENERAL LOGISTICS & DELIVERY SERVICES -->
<section id="logistics" class="py-24 lg:py-32 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-cosmic-50 border border-cosmic-200 mb-6">
                <svg class="w-4 h-4 text-cosmic-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                <span class="text-xs font-semibold text-cosmic-600 tracking-wider uppercase">Logistics Division</span>
            </div>
            <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-navy-950 mb-6 leading-tight">
                General Logistics &<br><span class="text-cosmic-500">Delivery Services</span>
            </h2>
            <p class="text-lg text-gray-600 leading-relaxed">
                We operate a <strong class="text-navy-800">comprehensive general delivery service</strong> that goes far beyond our own products. We handle the pickup, safe packaging, bulk transit, and door-to-door delivery of our own stationery and merchandise — <strong>AND</strong> offer general delivery services for other goods, documents, parcels, and commercial cargo.
            </p>
        </div>
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center mb-16">
            <div class="reveal">
                <div class="rounded-2xl overflow-hidden shadow-2xl shadow-navy-900/10 border border-gray-200">
                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&h=500&fit=crop" alt="Logistics and delivery fleet" class="w-full h-auto object-cover">
                </div>
            </div>
            <div class="reveal" style="transition-delay:0.2s;">
                <h3 class="font-display font-bold text-2xl text-navy-950 mb-4">What We Deliver</h3>
                <p class="text-gray-600 mb-8 leading-relaxed">Our logistics arm is equipped to handle diverse cargo types with professionalism and care. Whether it is our own branded products or your external shipments, we ensure safe, timely delivery every time.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-10 h-10 rounded-lg bg-navy-950 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
                        <span class="text-sm font-medium text-navy-950">Our Products</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-10 h-10 rounded-lg bg-navy-950 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg></div>
                        <span class="text-sm font-medium text-navy-950">External Cargo</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-10 h-10 rounded-lg bg-navy-950 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="text-sm font-medium text-navy-950">Documents</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-10 h-10 rounded-lg bg-navy-950 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
                        <span class="text-sm font-medium text-navy-950">Parcels</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="service-card bg-gradient-to-br from-navy-950 to-navy-900 rounded-2xl p-8 text-white relative overflow-hidden reveal">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cosmic-500/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-cosmic-500/20 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    </div>
                    <h4 class="font-display font-bold text-xl mb-3">Secure Packaging</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">Professional-grade packaging materials and techniques to ensure your goods arrive in perfect condition. From fragile items to bulk cargo.</p>
                </div>
            </div>
            <div class="service-card bg-gradient-to-br from-navy-950 to-navy-900 rounded-2xl p-8 text-white relative overflow-hidden reveal" style="transition-delay:0.15s;">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cosmic-500/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-cosmic-500/20 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h4 class="font-display font-bold text-xl mb-3">Bulk Distribution</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">Efficient bulk transit management for large-volume shipments. Consolidated logistics, route optimization, and real-time tracking.</p>
                </div>
            </div>
            <div class="service-card bg-gradient-to-br from-navy-950 to-navy-900 rounded-2xl p-8 text-white relative overflow-hidden reveal" style="transition-delay:0.3s;">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cosmic-500/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-cosmic-500/20 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h4 class="font-display font-bold text-xl mb-3">Door-to-Door Delivery</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">Reliable last-mile delivery services for our custom products and external client cargo. Timely, tracked, and professionally handled.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- TWITTER / X TIMELINE SECTION -->
<section class="twitter-section py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 reveal">
            <h2 class="font-display font-bold text-2xl sm:text-3xl text-white mb-4">Follow Us on X</h2>
            <p class="text-gray-400 text-sm">Stay updated with our latest projects, designs, and offers.</p>
        </div>
        <div class="rounded-2xl overflow-hidden border border-white/10 reveal">
            <a class="twitter-timeline" data-theme="dark" data-chrome="noheader nofooter noborders transparent" href="https://x.com/interstellarp21?ref_src=twsrc%5Etfw">Posts by interstellarp21</a>
            <script async src="https://platform.x.com/widgets.js" charset="utf-8"></script>
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- QUOTE & BOOKING FORM -->
<section id="quote" class="py-24 lg:py-32 quote-section relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-navy-950 text-white mb-6">
                <svg class="w-4 h-4 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                <span class="text-xs font-semibold text-cosmic-300 tracking-wider uppercase">Get Started</span>
            </div>
            <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-navy-950 mb-6">
                Request a Quote or<br><span class="text-cosmic-500">Book a Service</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Choose the service you need and we will get back to you with a tailored quote within 24 hours.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-navy-900/5 border border-gray-200 overflow-hidden reveal">
            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200">
                <button id="tab-stationery" class="flex-1 py-4 px-6 text-sm font-semibold transition-all tab-active" onclick="switchQuoteTab('stationery')">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Stationery / Merchandise Quote
                    </span>
                </button>
                <button id="tab-logistics" class="flex-1 py-4 px-6 text-sm font-semibold transition-all tab-inactive" onclick="switchQuoteTab('logistics')">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        Logistics / Delivery Booking
                    </span>
                </button>
            </div>

            <!-- Stationery/Merchandise Form -->
            <div id="form-stationery" class="p-8 lg:p-10">
                <form action="submit-quote.php" method="POST" class="space-y-6">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                    <!-- Honeypot (hidden — bots fill this, humans don't) -->
                    <div class="hp-field" aria-hidden="true">
                        <label for="hp-url">Do not fill this field</label>
                        <input type="text" id="hp-url" name="website_url" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="item_type" class="block text-sm font-medium text-gray-700 mb-2">Item Type <span class="text-red-500">*</span></label>
                            <select id="item_type" name="item_type" required class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                                <option value="">Select item type</option>
                                <option value="corporate-diaries">Corporate Diaries</option>
                                <option value="executive-notepads">Executive Notepads</option>
                                <option value="letterheads">Letterheads</option>
                                <option value="business-cards">Business Cards</option>
                                <option value="envelopes">Envelopes</option>
                                <option value="pens">Pens & Writing Instruments</option>
                                <option value="files-folders">Files & Folders</option>
                                <option value="corporate-apparel">Corporate Apparel (Uniforms, Hoodies)</option>
                                <option value="event-wear">Event & Promotional Wear</option>
                                <option value="tote-bags">Branded Tote Bags</option>
                                <option value="packaging-labels">Custom Packaging Labels</option>
                                <option value="corporate-gifts">Branded Corporate Gifts</option>
                                <option value="other">Other (specify below)</option>
                            </select>
                        </div>
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity <span class="text-red-500">*</span></label>
                            <input type="number" id="quantity" name="quantity" required min="1" placeholder="e.g., 500" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                    </div>
                    <div>
                        <label for="branding_requirements" class="block text-sm font-medium text-gray-700 mb-2">Branding Requirements</label>
                        <textarea id="branding_requirements" name="branding_requirements" rows="3" placeholder="Describe your branding needs: logo placement, colors, special finishes (foil, embossing, UV), etc." class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white resize-none"></textarea>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="sq_full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" id="sq_full_name" name="full_name" required placeholder="Your full name" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                        <div>
                            <label for="sq_company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                            <input type="text" id="sq_company_name" name="company_name" placeholder="Your company name" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="sq_email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="sq_email" name="email" required placeholder="you@company.com" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                        <div>
                            <label for="sq_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                            <input type="tel" id="sq_phone" name="phone" required placeholder="+234 ..." class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                    </div>
                    <div>
                        <label for="additional_details" class="block text-sm font-medium text-gray-700 mb-2">Additional Details</label>
                        <textarea id="additional_details" name="additional_details" rows="3" placeholder="Any other requirements, preferred delivery date, budget range, etc." class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white resize-none"></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-semibold text-sm tracking-wide flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Request Stationery / Merchandise Quote
                    </button>
                </form>
            </div>

            <!-- Logistics/Delivery Form -->
            <div id="form-logistics" class="p-8 lg:p-10 hidden">
                <form action="submit-logistics.php" method="POST" class="space-y-6">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                    <!-- Honeypot -->
                    <div class="hp-field" aria-hidden="true">
                        <label for="hp-url2">Do not fill this field</label>
                        <input type="text" id="hp-url2" name="website_url" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-2">Pickup Location <span class="text-red-500">*</span></label>
                            <input type="text" id="pickup_location" name="pickup_location" required placeholder="Full pickup address" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                        <div>
                            <label for="dropoff_location" class="block text-sm font-medium text-gray-700 mb-2">Drop-off Location <span class="text-red-500">*</span></label>
                            <input type="text" id="dropoff_location" name="dropoff_location" required placeholder="Full delivery address" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                    </div>
                    <div>
                        <label for="package_description" class="block text-sm font-medium text-gray-700 mb-2">Package Description <span class="text-red-500">*</span></label>
                        <textarea id="package_description" name="package_description" rows="3" required placeholder="Describe what needs to be delivered: type of goods, dimensions, special handling requirements, etc." class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white resize-none"></textarea>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-6">
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Estimated Weight (kg)</label>
                            <input type="number" id="weight" name="weight" step="0.1" min="0" placeholder="e.g., 5.5" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                        <div>
                            <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-2">Dimensions (L x W x H)</label>
                            <input type="text" id="dimensions" name="dimensions" placeholder="e.g., 30x20x15 cm" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                        <div>
                            <label for="delivery_type" class="block text-sm font-medium text-gray-700 mb-2">Delivery Type</label>
                            <select id="delivery_type" name="delivery_type" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                                <option value="standard">Standard Delivery</option>
                                <option value="express">Express Delivery</option>
                                <option value="same-day">Same-Day Delivery</option>
                                <option value="bulk">Bulk Distribution</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="lg_full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" id="lg_full_name" name="full_name" required placeholder="Your full name" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                        <div>
                            <label for="lg_company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                            <input type="text" id="lg_company_name" name="company_name" placeholder="Your company name" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="lg_email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="lg_email" name="email" required placeholder="you@company.com" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                        <div>
                            <label for="lg_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                            <input type="tel" id="lg_phone" name="phone" required placeholder="+234 ..." class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                        </div>
                    </div>
                    <div>
                        <label for="pickup_date" class="block text-sm font-medium text-gray-700 mb-2">Preferred Pickup Date</label>
                        <input type="date" id="pickup_date" name="pickup_date" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:outline-none focus:bg-white">
                    </div>
                    <button type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-semibold text-sm tracking-wide flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        Book Logistics / Delivery Service
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- FOOTER -->
<footer class="counter-bg text-white pt-20 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <a href="#" class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-800 to-navy-950 flex items-center justify-center border border-cosmic-400/30">
                        <svg class="w-6 h-6 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-display font-bold text-lg leading-tight tracking-wide">INTERSTELLAR</span>
                        <span class="font-display text-[10px] tracking-[0.3em] text-cosmic-400 leading-tight">PRINTS GLOBAL</span>
                    </div>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    Your Brand, Everywhere. End-to-end corporate supply, custom merchandise, and general logistics solutions.
                </p>
                <div class="flex gap-4">
                    <a href="https://x.com/interstellarp21" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-cosmic-500/20 hover:border-cosmic-500/30 transition-all" aria-label="X (Twitter)">
                        <svg class="w-4 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://wa.me/2348111110243" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-cosmic-500/20 hover:border-cosmic-500/30 transition-all" aria-label="WhatsApp">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <a href="tel:+2347045246353" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-cosmic-500/20 hover:border-cosmic-500/30 transition-all" aria-label="Call">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Quick Service Links -->
            <div>
                <h4 class="font-display font-bold text-lg mb-6">Our Services</h4>
                <ul class="space-y-3">
                    <li><a href="#stationery" class="text-gray-400 hover:text-cosmic-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Custom Stationery Supply</a></li>
                    <li><a href="#merchandise" class="text-gray-400 hover:text-cosmic-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Merchandise & Apparel</a></li>
                    <li><a href="#gallery" class="text-gray-400 hover:text-cosmic-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Product Gallery</a></li>
                    <li><a href="#logistics" class="text-gray-400 hover:text-cosmic-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Logistics & Delivery</a></li>
                    <li><a href="#quote" class="text-gray-400 hover:text-cosmic-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Request a Quote</a></li>
                </ul>
            </div>

            <!-- Contact Details -->
            <div>
                <h4 class="font-display font-bold text-lg mb-6">Contact Us</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-300 font-medium">Head Office</p>
                            <p class="text-sm text-gray-500">No 108 Sarkin Pawa Road,<br>Zaria, Kaduna</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-300 font-medium">Email</p>
                            <a href="mailto:info@interstellarprints.com" class="text-sm text-gray-500 hover:text-cosmic-400 transition-colors">info@interstellarprints.com</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-300 font-medium">Call Us</p>
                            <a href="tel:+2347045246353" class="text-sm text-gray-500 hover:text-cosmic-400 transition-colors">+234 704 524 6353</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-cosmic-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-300 font-medium">WhatsApp</p>
                            <a href="https://wa.me/2348111110243" target="_blank" rel="noopener" class="text-sm text-gray-500 hover:text-cosmic-400 transition-colors">+234 811 111 0243</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-cosmic-500/20 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-cosmic-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-300 font-medium">Business Hours</p>
                            <p class="text-sm text-gray-500">Mon - Fri: 8:00 AM - 6:00 PM</p>
                            <p class="text-sm text-gray-500">Sat: 9:00 AM - 2:00 PM</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="font-display font-bold text-lg mb-6">Stay Updated</h4>
                <p class="text-gray-400 text-sm mb-4">Subscribe to our newsletter for the latest products, offers, and industry insights.</p>
                <form class="space-y-3" action="submit-newsletter.php" method="POST" id="newsletter-form">
                    <input type="email" name="email" placeholder="Enter your email" required class="form-input w-full px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-white placeholder-gray-500 focus:outline-none focus:border-cosmic-500/50">
                    <button type="submit" class="w-full py-3 rounded-xl bg-cosmic-500 hover:bg-cosmic-400 text-white font-semibold text-sm transition-colors">Subscribe</button>
                </form>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-gray-500 text-sm">© 2026 Interstellar Prints Global Ltd. — Your Brand, Everywhere.</p>
            <div class="flex gap-6">
                <a href="#" class="text-gray-500 hover:text-cosmic-400 text-sm transition-colors">Privacy Policy</a>
                <a href="#" class="text-gray-500 hover:text-cosmic-400 text-sm transition-colors">Terms of Service</a>
                <a href="#" class="text-gray-500 hover:text-cosmic-400 text-sm transition-colors">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<!-- X (TWITTER) FLOATING ACTION BUTTON -->
<a href="https://x.com/interstellarp21" target="_blank" rel="noopener" class="x-fab" aria-label="Follow us on X (Twitter)">
    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
</a>

<!-- JAVASCRIPT -->
<script>
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('bg-navy-950/90', 'backdrop-blur-xl', 'shadow-lg', 'shadow-navy-900/20');
        } else {
            navbar.classList.remove('bg-navy-950/90', 'backdrop-blur-xl', 'shadow-lg', 'shadow-navy-900/20');
        }
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
    });

    // Close mobile menu on link click
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
        });
    });

    // Quote tab switching
    function switchQuoteTab(tab) {
        const stationeryTab = document.getElementById('tab-stationery');
        const logisticsTab = document.getElementById('tab-logistics');
        const stationeryForm = document.getElementById('form-stationery');
        const logisticsForm = document.getElementById('form-logistics');

        if (tab === 'stationery') {
            stationeryTab.classList.add('tab-active');
            stationeryTab.classList.remove('tab-inactive');
            logisticsTab.classList.remove('tab-active');
            logisticsTab.classList.add('tab-inactive');
            stationeryForm.classList.remove('hidden');
            logisticsForm.classList.add('hidden');
        } else {
            logisticsTab.classList.add('tab-active');
            logisticsTab.classList.remove('tab-inactive');
            stationeryTab.classList.remove('tab-active');
            stationeryTab.classList.add('tab-inactive');
            logisticsForm.classList.remove('hidden');
            stationeryForm.classList.add('hidden');
        }
    }

    // Scroll reveal animation
    const revealElements = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    revealElements.forEach(el => revealObserver.observe(el));

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offset = 80;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: targetPosition, behavior: 'smooth' });
            }
        });
    });

    // ─── Gallery Filtering ───────────────────────────────────────────
    function filterGallery(category, btn) {
        // Update filter buttons
        document.querySelectorAll('.gallery-filter').forEach(b => {
            b.classList.remove('gallery-filter-active');
            b.classList.add('gallery-filter-inactive');
        });
        btn.classList.add('gallery-filter-active');
        btn.classList.remove('gallery-filter-inactive');

        // Filter items
        document.querySelectorAll('#gallery-grid .gallery-item').forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // ─── Lightbox ─────────────────────────────────────────────────────
    function openLightbox(el) {
        const img = el.querySelector('img');
        if (!img) return;
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        lightboxImg.src = img.src;
        lightboxImg.alt = img.alt;
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
    });
</script>

</body>
</html>
