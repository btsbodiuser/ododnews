<!DOCTYPE html>
<html lang="mn" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админ') — ODOD</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @custom-variant dark (&:where(.dark, .dark *));
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="h-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased">
    <div class="flex min-h-full">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 flex flex-col border-r border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 transition-all duration-300 lg:translate-x-0 -translate-x-full sidebar-expanded">
            {{-- Brand --}}
            <div class="flex h-16 items-center gap-3 border-b border-zinc-200 dark:border-zinc-800 px-4 overflow-hidden">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 font-bold text-white text-sm shadow-lg shadow-blue-600/20">OD</div>
                <span class="sidebar-label text-lg font-bold tracking-tight whitespace-nowrap">ODOD <span class="text-blue-600 dark:text-blue-400">Админ</span></span>
            </div>

            {{-- Collapse toggle --}}
            <button onclick="collapseSidebar()" class="hidden lg:flex items-center justify-center absolute -right-3 top-20 h-6 w-6 rounded-full border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 shadow-sm z-40 transition-colors" id="collapse-btn">
                <svg class="w-3.5 h-3.5 transition-transform duration-300" id="collapse-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto overflow-x-hidden p-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Хянах самбар">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
                    <span class="sidebar-label whitespace-nowrap">Хянах самбар</span>
                </a>

                <div class="pt-4 pb-1 px-3"><span class="sidebar-label text-[10px] font-semibold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Контент</span></div>

                <a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}" title="Мэдээ">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <span class="sidebar-label whitespace-nowrap">Мэдээ</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" title="Ангилал">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span class="sidebar-label whitespace-nowrap">Ангилал</span>
                </a>
                <a href="{{ route('admin.authors.index') }}" class="nav-link {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}" title="Нийтлэгч">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="sidebar-label whitespace-nowrap">Нийтлэгч</span>
                </a>
                <a href="{{ route('admin.tags.index') }}" class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}" title="Шошго">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                    <span class="sidebar-label whitespace-nowrap">Шошго</span>
                </a>
                <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" title="Медиа">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="sidebar-label whitespace-nowrap">Медиа</span>
                </a>
            </nav>

            {{-- User --}}
            <div class="border-t border-zinc-200 dark:border-zinc-800 p-3">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-zinc-200 to-zinc-300 dark:from-zinc-700 dark:to-zinc-600 text-sm font-semibold text-zinc-600 dark:text-zinc-300">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="sidebar-label flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="sidebar-label">
                        @csrf
                        <button type="submit" class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors" title="Гарах">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-20 bg-black/50 backdrop-blur-sm lg:hidden hidden" onclick="toggleSidebar()"></div>

        {{-- Main --}}
        <div id="main-content" class="flex-1 transition-all duration-300 lg:ml-64">
            {{-- Topbar --}}
            <header class="sticky top-0 z-10 flex h-16 items-center gap-4 border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-900/80 px-6 backdrop-blur-xl">
                <button onclick="toggleSidebar()" class="rounded-lg p-2 text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 lg:hidden transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">@yield('heading')</h1>
                <div class="ml-auto flex items-center gap-3">
                    @yield('actions')
                    {{-- Theme toggle --}}
                    <button onclick="toggleTheme()" class="rounded-lg p-2 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors" title="Загвар солих" id="theme-toggle">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                </div>
            </header>

            {{-- Flash --}}
            @if(session('success'))
                <div class="mx-6 mt-4 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/30 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-400 flex items-center gap-2" id="flash-success">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">&times;</button>
                </div>
                <script>setTimeout(() => document.getElementById('flash-success')?.remove(), 4000)</script>
            @endif
            @if(session('error'))
                <div class="mx-6 mt-4 rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/30 px-4 py-3 text-sm text-red-700 dark:text-red-400 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">&times;</button>
                </div>
            @endif

            {{-- Content --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Collapsible sidebar (desktop)
        function collapseSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main-content');
            const icon = document.getElementById('collapse-icon');
            const isCollapsed = sidebar.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('sidebar-expanded', !isCollapsed);
            main.classList.toggle('lg:ml-64', !isCollapsed);
            main.classList.toggle('lg:ml-[4.5rem]', isCollapsed);
            icon.style.transform = isCollapsed ? 'rotate(180deg)' : '';
            localStorage.setItem('sidebar_collapsed', isCollapsed);
        }

        // Restore sidebar state
        if (localStorage.getItem('sidebar_collapsed') === 'true') {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main-content');
            const icon = document.getElementById('collapse-icon');
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.add('sidebar-collapsed');
            main.classList.remove('lg:ml-64');
            main.classList.add('lg:ml-[4.5rem]');
            icon.style.transform = 'rotate(180deg)';
        }

        // Dark/light mode toggle
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
    </script>
    @stack('scripts')

    <style>
        /* Sidebar widths */
        .sidebar-expanded { width: 16rem; }
        .sidebar-collapsed { width: 4.5rem; }
        .sidebar-collapsed .sidebar-label { display: none; }
        .sidebar-collapsed .nav-link { justify-content: center; padding: 0.625rem; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #71717a;
            transition: all 0.15s;
        }
        .dark .nav-link { color: #a1a1aa; }
        .nav-link:hover { background-color: #f4f4f5; color: #18181b; }
        .dark .nav-link:hover { background-color: #27272a; color: #fafafa; }
        .nav-link.active { background-color: #eff6ff; color: #2563eb; }
        .dark .nav-link.active { background-color: #1e3a5f; color: #60a5fa; }
        .nav-link.active svg { color: #2563eb; }
        .dark .nav-link.active svg { color: #60a5fa; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s;
            cursor: pointer;
        }
        .btn-primary { background: linear-gradient(135deg, #2563eb, #4f46e5); color: #fff; box-shadow: 0 1px 3px rgba(37, 99, 235, 0.3); }
        .btn-primary:hover { background: linear-gradient(135deg, #1d4ed8, #4338ca); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); }
        .btn-secondary { background-color: #fff; color: #3f3f46; border: 1px solid #e4e4e7; }
        .dark .btn-secondary { background-color: #27272a; color: #d4d4d8; border-color: #3f3f46; }
        .btn-secondary:hover { background-color: #f4f4f5; }
        .dark .btn-secondary:hover { background-color: #3f3f46; }
        .btn-danger { background-color: #fff; color: #dc2626; border: 1px solid #fecaca; }
        .dark .btn-danger { background-color: #27272a; color: #f87171; border-color: #7f1d1d; }
        .btn-danger:hover { background-color: #fef2f2; }
        .dark .btn-danger:hover { background-color: #3f3f46; }
        .btn-sm { padding: 0.375rem 0.75rem; font-size: 0.8125rem; }

        .card {
            background: #fff;
            border: 1px solid #e4e4e7;
            border-radius: 0.875rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }
        .dark .card { background: #18181b; border-color: #27272a; }

        .input {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e4e4e7;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            background: #fff;
            color: #18181b;
            transition: all 0.15s;
        }
        .dark .input { background: #18181b; border-color: #3f3f46; color: #fafafa; }
        .input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }
        .dark .input:focus { border-color: #60a5fa; box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.15); }

        .label { display: block; margin-bottom: 0.375rem; font-size: 0.875rem; font-weight: 500; color: #3f3f46; }
        .dark .label { color: #a1a1aa; }

        .badge { display: inline-flex; align-items: center; padding: 0.125rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
        .table-wrapper { overflow-x: auto; }
        .table-wrapper table { width: 100%; font-size: 0.875rem; }
        .table-wrapper th {
            padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: #71717a;
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;
            background: #fafafa; border-bottom: 1px solid #e4e4e7;
        }
        .dark .table-wrapper th { background: #1c1c1f; color: #71717a; border-bottom-color: #27272a; }
        .table-wrapper td { padding: 0.75rem 1rem; border-bottom: 1px solid #f4f4f5; vertical-align: middle; }
        .dark .table-wrapper td { border-bottom-color: #27272a; }
        .table-wrapper tbody tr:hover { background-color: #fafafa; }
        .dark .table-wrapper tbody tr:hover { background-color: #1f1f23; }
    </style>
</body>
</html>
