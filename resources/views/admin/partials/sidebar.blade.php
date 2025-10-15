<!-- Sidebar -->
<aside @toggle-sidebar.window="open = !open" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white transform transition-transform duration-300 lg:translate-x-0" :class="{ '-translate-x-full': !open }">
    <!-- Logo -->
    <div class="flex items-center justify-between h-16 px-6 border-b border-gray-700/50">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-xl">O</span>
            </div>
            <span class="font-bold text-lg">{{ config('app.name') }}</span>
        </a>
        <button @click="open = false" class="lg:hidden text-gray-400 hover:text-white">
            <x-lucide-x class="w-6 h-6" />
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" @click="open = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500/20 text-orange-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <x-lucide-layout-dashboard class="w-5 h-5" />
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Divider -->
        <div class="pt-4 mt-4 border-t border-gray-700/50">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">İçerik Yönetimi</p>
        </div>

        <!-- Site Bilgileri -->
        <a href="{{ route('admin.site-information.index') }}" @click="open = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.site-information.*') ? 'bg-orange-500/20 text-orange-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <x-lucide-info class="w-5 h-5" />
            <span class="font-medium">Site Bilgileri</span>
        </a>

        <!-- Hizmetler -->
        <a href="{{ route('admin.services.index') }}" @click="open = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-orange-500/20 text-orange-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <x-lucide-briefcase class="w-5 h-5" />
            <span class="font-medium">Hizmetler</span>
        </a>

        <!-- Blog Categories -->
        <a href="{{ route('admin.blog-categories.index') }}" @click="open = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.blog-categories.*') ? 'bg-orange-500/20 text-orange-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <x-lucide-folder class="w-5 h-5" />
            <span class="font-medium">Blog Kategorileri</span>
        </a>

        <!-- Blog -->
        <a href="{{ route('admin.blogs.index') }}" @click="open = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.blogs.*') ? 'bg-orange-500/20 text-orange-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <x-lucide-newspaper class="w-5 h-5" />
            <span class="font-medium">Blog</span>
        </a>

        <!-- Referanslar -->
        <a href="{{ route('admin.brands.index') }}" @click="open = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.brands.*') ? 'bg-orange-500/20 text-orange-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <x-lucide-award class="w-5 h-5" />
            <span class="font-medium">Referanslar</span>
        </a>

        <!-- Divider -->
        <div class="pt-4 mt-4 border-t border-gray-700/50">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sistem Ayarları</p>
        </div>

        <!-- SMTP Ayarları -->
        <a href="{{ route('admin.smtp.index') }}" @click="open = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.smtp.*') ? 'bg-orange-500/20 text-orange-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <x-lucide-mail class="w-5 h-5" />
            <span class="font-medium">SMTP Ayarları</span>
        </a>

        <!-- Profil Ayarları -->
        <a href="{{ route('admin.profile.edit') }}" @click="open = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-orange-500/20 text-orange-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <x-lucide-user class="w-5 h-5" />
            <span class="font-medium">Profil Ayarları</span>
        </a>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-gray-700/50">
        <div class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-gray-800/50">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 2) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>

