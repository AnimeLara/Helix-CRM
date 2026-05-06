<x-guest-layout>
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-12">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(45,212,191,0.22),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.22),_transparent_28%),linear-gradient(135deg,_#020617,_#0f172a_42%,_#042f2e)]"></div>
        <div class="absolute inset-y-10 left-10 hidden w-80 rounded-full bg-teal-400/10 blur-3xl lg:block"></div>
        <div class="absolute bottom-0 right-0 hidden h-96 w-96 rounded-full bg-cyan-400/10 blur-3xl lg:block"></div>

        <div class="relative grid w-full max-w-6xl overflow-hidden rounded-[2rem] border border-white/10 bg-white/8 shadow-2xl shadow-black/30 backdrop-blur-2xl lg:grid-cols-[1.1fr_0.9fr]">
            <div class="hidden p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <x-application-logo />
                        <div>
                            <p class="font-display text-xl font-bold">Helix CRM</p>
                            <p class="text-sm text-white/60">Premium sales operating system</p>
                        </div>
                    </div>
                    <div class="mt-14 max-w-lg">
                        <p class="text-sm uppercase tracking-[0.3em] text-white/40">Command Center</p>
                        <h1 class="mt-4 font-display text-5xl font-extrabold leading-tight">See pipeline momentum, customer health, and team execution at a glance.</h1>
                        <p class="mt-6 text-lg text-white/70">Built for revenue teams that want elegant workflows, faster follow-ups, and cleaner forecasting.</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="rounded-3xl border border-white/10 bg-white/10 p-5">
                        <p class="text-sm text-white/50">Revenue</p>
                        <p class="mt-2 font-display text-3xl font-bold">$482k</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/10 p-5">
                        <p class="text-sm text-white/50">Qualified</p>
                        <p class="mt-2 font-display text-3xl font-bold">68%</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/10 p-5">
                        <p class="text-sm text-white/50">Response</p>
                        <p class="mt-2 font-display text-3xl font-bold">1.8h</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 sm:p-10 dark:bg-slate-950">
                <div class="mx-auto max-w-md">
                    <div class="lg:hidden">
                        <div class="flex items-center gap-3">
                            <x-application-logo />
                            <div>
                                <p class="font-display text-xl font-bold text-slate-950 dark:text-white">Helix CRM</p>
                                <p class="crm-subtext">Premium sales operating system</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <p class="crm-subtext">Welcome back</p>
                        <h2 class="crm-heading mt-2 text-3xl">Sign in to your workspace</h2>
                        <p class="crm-subtext mt-3">Demo users: `admin@crm.test`, `manager@crm.test`, `sales@crm.test` with password `password`.</p>
                    </div>

                    <x-auth-session-status class="mt-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                        @csrf

                        <x-ui.input label="Email address" name="email" type="email" :value="old('email', 'admin@crm.test')" required autofocus autocomplete="username" />
                        <x-ui.input label="Password" name="password" type="password" value="password" required autocomplete="current-password" />

                        <label class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 dark:border-slate-800">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Remember me</span>
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-500 focus:ring-teal-500">
                        </label>

                        <button type="submit" class="crm-btn-primary w-full py-3">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
