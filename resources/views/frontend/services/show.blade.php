<x-app-layout :seoData="$seoData">
    {{-- Breadcrumb --}}
    <nav class="bg-gray-50 border-b border-gray-200" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600 transition-colors duration-200">
                        <x-lucide-house class="w-4 h-4" />
                    </a>
                </li>
                <li class="flex items-center">
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-400 mx-2" />
                    <a href="{{ route('services') }}" class="text-gray-500 hover:text-primary-600 transition-colors duration-200">
                        Hizmetlerimiz
                    </a>
                </li>
                <li class="flex items-center">
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-400 mx-2" />
                    <span class="text-gray-900 font-medium">{{ $service->name }}</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section --}}
    @include('frontend.services.partials.hero')

    {{-- Divider --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
    </div>

    {{-- Divider --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
    </div>

    {{-- Photo Gallery --}}
    @include('frontend.services.partials.photo-gallery')

    {{-- Divider --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
    </div>

    @include('frontend.services.partials.process')


    {{-- Divider --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
    </div>

    {{-- SEO Content --}}
    @include('frontend.services.partials.seo-content')
</x-app-layout>
