<header class="sticky top-0 z-20 px-4 pt-4 sm:px-6 lg:px-8">
    <div class="rounded-[28px] border border-white/80 bg-white/72 px-4 py-4 shadow-[0_18px_60px_-34px_rgba(15,23,42,0.24)] backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/72 sm:px-5">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex items-center gap-3">
                <button class="rounded-2xl border border-slate-200 bg-white p-3 text-slate-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 lg:hidden" @click="sidebarOpen = true">
                    <i data-lucide="panel-left-open" class="h-5 w-5"></i>
                </button>
                <button class="hidden rounded-2xl border border-slate-200 bg-white p-3 text-slate-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 lg:inline-flex" @click="toggleSidebar()">
                    <i data-lucide="panel-left-open" class="h-5 w-5"></i>
                </button>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-600 dark:text-teal-300">Helix Workspace</p>
                    <h1 class="crm-heading mt-1 text-2xl">Sales command center</h1>
                </div>
            </div>

            <div class="flex flex-1 items-center justify-end gap-3">
                <label class="relative hidden w-full max-w-lg xl:block">
                    <i data-lucide="search" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" class="crm-input border-0 bg-slate-100/90 pl-11 shadow-none dark:bg-slate-900/90" placeholder="Search deals, customers, or activities">
                </label>
                <button class="rounded-2xl border border-slate-200 bg-white p-3 text-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300" @click="window.applyTheme(document.documentElement.classList.contains('dark') ? 'light' : 'dark');">
                    <i data-lucide="moon-star" class="h-5 w-5"></i>
                </button>
                <button class="relative rounded-2xl border border-slate-200 bg-white p-3 text-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
                    <i data-lucide="bell" class="h-5 w-5"></i>
                    <span class="absolute right-2 top-2 h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                </button>
                <div x-data="{ open: false }" class="relative">
                    <button class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 dark:border-slate-700 dark:bg-slate-900" @click="open = !open">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-400 via-cyan-400 to-sky-500 font-display text-sm font-bold text-slate-950">
                            {{ str(auth()->user()->name)->substr(0, 2)->upper() }}
                        </div>
                        <div class="hidden text-left sm:block">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="crm-subtext">{{ str(auth()->user()->role)->headline() }}</p>
                        </div>
                        <i data-lucide="chevron-down" class="hidden h-4 w-4 text-slate-400 sm:block"></i>
                    </button>

                    <div
                        class="absolute right-0 mt-3 w-56 rounded-[24px] border border-slate-200 bg-white p-2 shadow-2xl shadow-slate-950/10 dark:border-slate-700 dark:bg-slate-900"
                        x-show="open"
                        x-transition
                        @click.outside="open = false"
                    >
                        <a href="{{ route('profile.edit') }}" class="crm-sidebar-link">Profile</a>
                        @if (auth()->user()->canManageSettings())
                            <a href="{{ route('settings.edit') }}" class="crm-sidebar-link">Settings</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="crm-sidebar-link w-full text-left">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
