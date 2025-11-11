<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Doctor Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script>
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
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-xl font-bold">Care-Path</h2>
                </div>
                <div class="flex flex-col gap-4 mt-6 grow">
                    <div class="flex flex-col gap-2">
                        {{-- <a
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.dashboard') ? 'bg-primary/10 dark:bg-primary/20' : 'hover:bg-primary/10 dark:hover:bg-primary/20 group' }}"
                            href="{{ route('doctor.dashboard') }}">
                            <span
                                class="material-symbols-outlined text-2xl {{ request()->routeIs('doctor.dashboard') ? 'text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary' }}">
                                dashboard
                            </span>
                            <p
                                class="{{ request()->routeIs('doctor.dashboard') ? 'text-primary text-sm font-bold' : 'text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium' }}">
                                Dashboard
                            </p>
                        </a>

                        <a
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.appointments') ? 'bg-primary/10 dark:bg-primary/20' : 'hover:bg-primary/10 dark:hover:bg-primary/20 group' }}"
                            href="">
                            <span
                                class="material-symbols-outlined text-2xl {{ request()->routeIs('doctor.appointments') ? 'text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary' }}">
                                calendar_month
                            </span>
                            <p
                                class="{{ request()->routeIs('doctor.appointments') ? 'text-primary text-sm font-bold' : 'text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium' }}">
                                Appointments
                            </p>
                        </a>

                        <a
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.chat') ? 'bg-primary/10 dark:bg-primary/20' : 'hover:bg-primary/10 dark:hover:bg-primary/20 group' }}"
                            href="{{ route('doctor.chat') }}">
                            <span
                                class="material-symbols-outlined text-2xl {{ request()->routeIs('doctor.chat') ? 'text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary' }}">
                                chat
                            </span>
                            <p
                                class="{{ request()->routeIs('doctor.chat') ? 'text-primary text-sm font-bold' : 'text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium' }}">
                                Chat
                            </p>
                        </a>

                        <a
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.patients') ? 'bg-primary/10 dark:bg-primary/20' : 'hover:bg-primary/10 dark:hover:bg-primary/20 group' }}"
                            href="{{ route('doctor.patients') }}">
                            <span
                                class="material-symbols-outlined text-2xl {{ request()->routeIs('doctor.patients') ? 'text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary' }}">
                                groups
                            </span>
                            <p
                                class="{{ request()->routeIs('doctor.patients') ? 'text-primary text-sm font-bold' : 'text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium' }}">
                                Patients
                            </p>
                        </a>

                        <a
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.wallet') ? 'bg-primary/10 dark:bg-primary/20' : 'hover:bg-primary/10 dark:hover:bg-primary/20 group' }}"
                            href="{{ route('doctor.wallet') }}">
                            <span
                                class="material-symbols-outlined text-2xl {{ request()->routeIs('doctor.wallet') ? 'text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary' }}">
                                account_balance_wallet
                            </span>
                            <p
                                class="{{ request()->routeIs('doctor.wallet') ? 'text-primary text-sm font-bold' : 'text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium' }}">
                                Wallet
                            </p>
                        </a>

                        <a
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.profile') ? 'bg-primary/10 dark:bg-primary/20' : 'hover:bg-primary/10 dark:hover:bg-primary/20 group' }}"
                            href="{{ route('doctor.profile') }}">
                            <span
                                class="material-symbols-outlined text-2xl {{ request()->routeIs('doctor.profile') ? 'text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary group-hover:text-primary' }}">
                                person
                            </span>
                            <p
                                class="{{ request()->routeIs('doctor.profile') ? 'text-primary text-sm font-bold' : 'text-text-light-primary dark:text-text-dark-primary group-hover:text-primary text-sm font-medium' }}">
                                Profile
                            </p>
                        </a> --}}
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-3 px-3 py-4 border-t border-border-light dark:border-border-dark">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                            data-alt="Profile picture of Dr. Evelyn Reed"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPyLJw3e-STCG-Z_O80E32_v6PZpysy71S1oSZahWCaDPPQmvcgI2t0gUj2Zrs9mZc37Qkvjq-vINlPqEmVzUN_TA36pmlmevEoz2tgIGY5cI3MriGJn0lQxDKPb_26F2nPz6-be5413GVSx6e1MTVRDeDgpC9AXz4sPxw53iRSaKl4L-kNXkJUbxSJl3uRQ0yHwUqig5sZkkhDpfh1pOixCpqMsnux06f4TcFD80t8P87irVbR-BWMQobLI6VPC5xNX2hdY2Z0w");'>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold">Dr. Evelyn Reed</h1>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">Oncologist</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- TopNavBar -->
            <header
                class="sticky top-0 flex items-center justify-between whitespace-nowrap bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm z-10 px-8 py-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-semibold" id="current-time">
                        {{ date('l, F j, Y') }}
                    </h2>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        class="flex items-center justify-center rounded-full size-10 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary relative">
                        <span class="material-symbols-outlined text-2xl">notifications</span>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full size-5 flex items-center justify-center">3</span>
                    </button>
                    <button
                        class="flex items-center justify-center rounded-full size-10 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                        <span class="material-symbols-outlined text-2xl">help_outline</span>
                    </button>
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

    <script>
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('current-time').textContent = now.toLocaleDateString('en-US', options);
        }
        
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>

</html>