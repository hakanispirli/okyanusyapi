<!-- Mobile Contact Button - Collapsible Corporate Style -->
@if($siteInformation && $siteInformation->phone)
    <style>
        @keyframes phoneRing {
            0%, 100% { transform: rotate(0deg); }
            10% { transform: rotate(-15deg); }
            20% { transform: rotate(15deg); }
            30% { transform: rotate(-15deg); }
            40% { transform: rotate(15deg); }
            50% { transform: rotate(0deg); }
        }

        .phone-icon-ring {
            animation: phoneRing 2s ease-in-out infinite;
            transform-origin: center bottom;
        }
    </style>

    <div x-data="{
        isVisible: localStorage.getItem('phoneButtonVisible') !== 'false',

        hide() {
            this.isVisible = false;
            localStorage.setItem('phoneButtonVisible', 'false');
        },

        show() {
            this.isVisible = true;
            localStorage.setItem('phoneButtonVisible', 'true');
        }
    }"
         class="fixed bottom-6 right-6 z-40 lg:hidden">

        <!-- Main Contact Button (When Visible) -->
        <div x-show="isVisible"
             x-transition:enter="ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-400"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative"
             style="display: none;">

            <!-- Close Button -->
            <button @click="hide()"
                    class="absolute -top-2 -right-2 z-10 flex items-center justify-center w-7 h-7 bg-corporate-800 hover:bg-corporate-700 rounded-full shadow-md hover:shadow-lg transition-all duration-300 border border-corporate-700/50 hover:border-primary-500/50 hover:scale-110 active:scale-95 group"
                    aria-label="Kapat">
                <x-lucide-x class="w-3.5 h-3.5 text-corporate-300 group-hover:text-white transition-colors duration-200" />
            </button>

            <!-- Contact Button -->
            <a href="tel:{{ $siteInformation->phone }}"
               class="group flex items-center gap-3 px-5 py-4 bg-corporate-950 hover:bg-corporate-900 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-corporate-800/50 hover:border-primary-500/50 active:scale-95"
               aria-label="Bize Ulaşın">

                <!-- Icon Container -->
                <div class="flex items-center justify-center w-10 h-10 bg-primary-500/10 group-hover:bg-primary-500/20 rounded-lg transition-all duration-300">
                    <x-lucide-phone class="w-5 h-5 text-primary-500 group-hover:text-primary-400 transition-colors duration-300" />
                </div>

                <!-- Text Content -->
                <div class="flex flex-col">
                    <span class="text-xs font-medium text-corporate-400 group-hover:text-corporate-300 transition-colors duration-300 tracking-wide">
                        Bize Ulaşın
                    </span>
                    <span class="text-sm font-semibold text-white tracking-tight">
                        {{ $siteInformation->phone }}
                    </span>
                </div>

                <!-- Arrow Icon -->
                <div class="ml-1 transform group-hover:translate-x-0.5 transition-transform duration-300">
                    <x-lucide-arrow-right class="w-4 h-4 text-primary-500 opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                </div>

                <!-- Subtle Glow Effect -->
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-primary-500/0 via-primary-500/5 to-primary-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            </a>
        </div>

        <!-- Collapsed Button (When Hidden) -->
        <button x-show="!isVisible"
                @click="show()"
                x-transition:enter="ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-400"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative flex items-center justify-center w-14 h-14 bg-corporate-950 hover:bg-corporate-900 rounded-full shadow-lg hover:shadow-2xl transition-all duration-300 border border-corporate-800/50 hover:border-primary-500/50 hover:scale-105 active:scale-95 group"
                aria-label="İletişim Butonunu Göster"
                style="display: none;">

            <!-- Breathing Glow Effect -->
            <div class="absolute inset-0 rounded-full bg-primary-500/20 blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

            <!-- Phone Icon with Ring Animation -->
            <x-lucide-phone class="relative w-6 h-6 text-primary-500 group-hover:text-primary-400 transition-colors duration-300 phone-icon-ring" />
        </button>
    </div>
@endif

