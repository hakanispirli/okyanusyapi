<!-- Top Navigation -->
<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
    <div class="flex items-center space-x-4">
        <!-- Mobile Menu Button -->
        <button @click="$dispatch('toggle-sidebar')" class="lg:hidden p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">
            <x-lucide-menu class="w-5 h-5" />
        </button>

        <!-- Page Title -->
        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                @if(request()->routeIs('admin.dashboard'))
                    Dashboard
                @elseif(request()->routeIs('admin.site-information.*'))
                    Site Bilgileri
                @elseif(request()->routeIs('admin.services.*'))
                    Hizmetler
                @elseif(request()->routeIs('admin.blog-categories.*'))
                    Blog Kategorileri
                @elseif(request()->routeIs('admin.blogs.*'))
                    Blog Yönetimi
                @elseif(request()->routeIs('admin.brands.*'))
                    Referanslar
                @elseif(request()->routeIs('admin.smtp.*'))
                    SMTP Ayarları
                @elseif(request()->routeIs('admin.profile.*'))
                    Profil Ayarları
                @else
                    Yönetim Paneli
                @endif
            </h1>
            <p class="text-sm text-gray-500">
                @if(request()->routeIs('admin.dashboard'))
                    Genel bakış ve istatistikler
                @elseif(request()->routeIs('admin.site-information.*'))
                    Site bilgilerini yönetin
                @elseif(request()->routeIs('admin.services.*'))
                    Hizmet detay sayfalarını yönetin
                @elseif(request()->routeIs('admin.blog-categories.*'))
                    Blog kategorilerini yönetin
                @elseif(request()->routeIs('admin.blogs.*'))
                    Blog yazılarını yönetin
                @elseif(request()->routeIs('admin.brands.*'))
                    Referans projelerini yönetin
                @elseif(request()->routeIs('admin.smtp.*'))
                    E-posta ayarlarını yönetin
                @elseif(request()->routeIs('admin.profile.*'))
                    Profil bilgilerinizi güncelleyin
                @endif
            </p>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Frontend Link -->
        <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center space-x-2 px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors rounded-lg hover:bg-gray-100">
            <x-lucide-external-link class="w-5 h-5" />
            <span class="hidden md:inline">Siteyi Görüntüle</span>
        </a>

        <!-- Notifications -->
        <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors relative">
            <x-lucide-bell class="w-5 h-5" />
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
        </button>

        <!-- Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 2) }}</span>
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">Admin</p>
                </div>
                <x-lucide-chevron-down class="w-4 h-4 text-gray-500" />
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200">

                <a href="{{ route('admin.profile.edit') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <x-lucide-user class="w-4 h-4" />
                    <span>Profil Ayarları</span>
                </a>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <x-lucide-external-link class="w-4 h-4" />
                    <span>Siteyi Görüntüle</span>
                </a>

                <div class="border-t border-gray-200 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                        <x-lucide-log-out class="w-4 h-4" />
                        <span>Çıkış Yap</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

