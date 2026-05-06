<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Helix CRM' }}</title>
        <script>
            (() => {
                const theme = localStorage.getItem('crm-theme') || @js(optional(auth()->user())->theme ?? 'light');
                document.documentElement.classList.toggle('dark', theme === 'dark');
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="crm-shell" x-data="appShell(@js(optional(auth()->user())->theme ?? 'light'))">
        <div class="relative min-h-screen">
            <x-layout.sidebar />

            <div
                class="flex min-h-screen flex-1 flex-col transition-[margin] duration-300 lg:ml-80"
                :class="{ 'lg:ml-24': sidebarCollapsed, 'lg:ml-80': !sidebarCollapsed }"
            >
                <x-layout.navbar />

                <main class="flex-1 px-4 pb-10 pt-5 sm:px-6 lg:px-8">
                    @isset($header)
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endisset
                    <div class="crm-page">
                        {{ $slot ?? '' }}
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <x-common.toast />
        @stack('modals')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
