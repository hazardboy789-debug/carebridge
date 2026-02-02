<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Patient Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script>
        // Apply initial theme from localStorage or OS preference
        (function() {
            try {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const useDark = stored === 'dark' || (!stored && prefersDark);
                if (useDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {
                // ignore
            }
        })();

        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#197fe6",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                        "card-light": "#ffffff",
                        "card-dark": "#1e293b",
                        "text-light-primary": "#111418",
                        "text-dark-primary": "#f8fafc",
                        "text-light-secondary": "#637588",
                        "text-dark-secondary": "#94a3b8",
                        "border-light": "#f0f2f4",
                        "border-dark": "#334155",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "full": "9999px",
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="font-display bg-background-light dark:bg-background-dark">
    <div class="relative flex min-h-screen w-full">
        <!-- SideNavBar -->
        <aside
            class="sticky top-0 h-screen w-64 flex-shrink-0 bg-card-light dark:bg-card-dark border-r border-border-light dark:border-border-dark">
            <div class="flex h-full flex-col p-4">
                <div class="flex items-center gap-3 px-3 py-4">
                    <div class="size-8 text-primary">
                        <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M24 4H6V17.3333V30.6667H24V44H42V30.6667V17.3333H24V4Z"
                                fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-xl font-bold">CareBridge</h2>
                </div>
                <div class="flex flex-col gap-4 mt-6 grow">
                    <div class="flex flex-col gap-2">
                        <a
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.dashboard') ? 'bg-primary/10 dark:bg-primary/20' : 'hover:bg-primary/10 dark:hover:bg-primary/20 group' }}"
                            href="{{ route('patient.dashboard') }}">
                            <span
                                class="material-symbols-outlined text-2xl {{ request()->routeIs('patient.dashboard') ? 'text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary' }}">
                                dashboard
                            </span>
                            <p
                                class="{{ request()->routeIs('patient.dashboard') ? 'text-primary text-sm font-bold' : 'text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium' }}">
                                Dashboard
                            </p>
                        </a>

                        <a
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.symptom-checker') ? 'bg-primary/10 dark:bg-primary/20' : 'hover:bg-primary/10 dark:hover:bg-primary/20 group' }}"
                            href="{{ route('patient.symptom-checker') }}">
                            <span
                                class="material-symbols-outlined text-2xl {{ request()->routeIs('patient.symptom-checker') ? 'text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary' }}">
                                playlist_add_check
                            </span>
                            <p
                                class="{{ request()->routeIs('patient.symptom-checker') ? 'text-primary text-sm font-bold' : 'text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium' }}">
                                Symptom Checker
                            </p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 group"
                            href="{{ route('patient.appointments') }}">
                            <span
                                class="material-symbols-outlined text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary text-2xl">calendar_month</span>
                            <p
                                class="text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium">
                                Appointments</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 group"
                            href="{{ route('patient.chat') }}">
                            <span
                                class="material-symbols-outlined text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary text-2xl">chat</span>
                            <p
                                class="text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium">
                                Chat</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 group"
                            href="{{ route('patient.wallet') }}">
                            <span
                                class="material-symbols-outlined text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary text-2xl">account_balance_wallet</span>
                            <p
                                class="text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium">
                                Wallet</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 group"
                            href="{{ route('patient.pharmacy') }}">
                            <span
                                class="material-symbols-outlined text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary text-2xl">pill</span>
                            <p
                                class="text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium">
                                Pharmacy</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 group"
                            href="{{ route('patient.emergency') }}">
                            <span
                                class="material-symbols-outlined text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary text-2xl">emergency</span>
                            <p
                                class="text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium">
                                Emergency Assistance</p>
                        </a>
                    </div>
                </div>
                <!-- user profile removed as requested -->
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- TopNavBar -->
            <header
                class="sticky top-0 flex items-center justify-end whitespace-nowrap bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm z-10 px-8 py-4">
                <div class="flex items-center gap-4">
                    <button id="theme-toggle" class="flex items-center justify-center rounded-full size-10 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary" aria-label="Toggle dark mode" type="button">
                        <span id="theme-toggle-icon" class="material-symbols-outlined text-2xl">dark_mode</span>
                    </button>
                    <button
                        class="flex items-center justify-center rounded-full size-10 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                        <span class="material-symbols-outlined text-2xl">notifications</span>
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center rounded-full size-10 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary"
                            aria-label="Logout">
                            <span class="material-symbols-outlined text-2xl">logout</span>
                        </button>
                    </form>
                    <button
                        class="flex items-center justify-center rounded-full size-10 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                        <span class="material-symbols-outlined text-2xl">settings</span>
                    </button>
                </div>
            </header>

            <div class="main">
                {{ $slot }}
            </div>

        </main>
    </div>
</body>

    <script>
        // Theme toggle for patient layout
        (function(){
            const toggle = document.getElementById('theme-toggle');
            const icon = document.getElementById('theme-toggle-icon');
            if (!toggle) return;

            function setIcon() {
                const isDark = document.documentElement.classList.contains('dark');
                icon.textContent = isDark ? 'dark_mode' : 'light_mode';
            }

            toggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');
                try { localStorage.setItem('theme', isDark ? 'dark' : 'light'); } catch(e) {}
                setIcon();
            });

            setIcon();
        })();
    </script>

</html>