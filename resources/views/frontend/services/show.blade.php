<x-app-layout>
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

    {{-- Divider --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
    </div>

    {{-- Call to Action --}}
    <section class="py-16 md:py-24 bg-gradient-to-br from-corporate-900 via-corporate-800 to-corporate-900 relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-white mb-6">
                    Hayalinizdeki Projeyi Birlikte Gerçekleştirelim
                </h2>
                <p class="text-gray-200 text-lg sm:text-xl max-w-3xl mx-auto leading-relaxed mb-8">
                    30 yılı aşkın deneyimimizle, profesyonel ekibimizle ve kaliteli hizmet anlayışımızla
                    projenizi hayata geçirmeye hazırız. Ücretsiz keşif ve detaylı fiyat teklifi için bizimle iletişime geçin.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a
                    href="{{ route('contact') }}"
                    class="group inline-flex items-center justify-center px-8 py-4 bg-primary-600 text-white rounded-xl hover:bg-primary-700 hover:shadow-xl hover:shadow-primary-600/25 transition-all duration-300 transform hover:-translate-y-1">
                    <x-lucide-message-circle class="w-5 h-5 mr-3" />
                    <span class="font-semibold">Ücretsiz Teklif Al</span>
                    <x-lucide-arrow-right class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" />
                </a>

                <div class="flex items-center text-gray-300">
                    <x-lucide-phone class="w-4 h-4 mr-2" />
                    <span class="text-sm">veya</span>
                </div>

                <a
                    href="tel:+905551234567"
                    class="group inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white border border-white/20 rounded-xl hover:bg-white/20 hover:border-white/30 transition-all duration-300">
                    <x-lucide-phone-call class="w-5 h-5 mr-3" />
                    <span class="font-semibold">Hemen Ara</span>
                    <span class="text-sm ml-2 opacity-75">+90 555 123 45 67</span>
                </a>
            </div>

            {{-- Trust Indicators --}}
            <div class="mt-12 pt-8 border-t border-white/10">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-8 text-gray-300 text-sm">
                    <div class="flex items-center">
                        <x-lucide-award class="w-4 h-4 mr-2 text-primary-400" />
                        <span>30+ Yıl Deneyim</span>
                    </div>
                    <div class="flex items-center">
                        <x-lucide-users class="w-4 h-4 mr-2 text-primary-400" />
                        <span>500+ Mutlu Müşteri</span>
                    </div>
                    <div class="flex items-center">
                        <x-lucide-circle-check class="w-4 h-4 mr-2 text-primary-400" />
                        <span>%100 Müşteri Memnuniyeti</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
