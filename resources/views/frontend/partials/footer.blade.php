<!-- Okyanus Yapı Footer -->
<footer class="bg-corporate-900 text-white">
    <!-- Call to Action Section -->
    <section class="bg-gradient-to-br from-gray-100 via-white to-gray-100 relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23000000" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">
            <div class="text-center mb-6">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-display font-bold text-corporate-900 mb-3">
                    Hayalinizdeki Projeyi Birlikte Gerçekleştirelim
                </h2>
                <p class="text-corporate-700 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-4">
                    30 yılı aşkın deneyimimizle, profesyonel ekibimizle ve kaliteli hizmet anlayışımızla
                    projenizi hayata geçirmeye hazırız. Ücretsiz keşif ve detaylı fiyat teklifi için bizimle iletişime geçin.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                <a
                    href="{{ route('contact') }}"
                    class="group inline-flex items-center justify-center px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-600/25 transition-all duration-300 transform hover:-translate-y-1">
                    <x-lucide-message-circle class="w-4 h-4 mr-2" />
                    <span class="font-medium text-sm">Ücretsiz Teklif Al</span>
                    <x-lucide-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" />
                </a>

                <div class="flex items-center text-corporate-600">
                    <x-lucide-phone class="w-3 h-3 mr-2" />
                    <span class="text-xs">veya</span>
                </div>

                <a href="tel:{{ $siteInformation->phone }}"
                    class="group inline-flex items-center justify-center px-5 py-2.5 bg-corporate-900 text-white border border-corporate-800 rounded-lg hover:bg-corporate-800 hover:border-corporate-700 transition-all duration-300">
                    <x-lucide-phone-call class="w-4 h-4 mr-2" />
                    <span class="font-medium text-sm">
                        Hemen Ara
                    </span>
                </a>
            </div>

            {{-- Trust Indicators --}}
            <div class="mt-6 pt-4 border-t border-corporate-200">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-corporate-600 text-xs">
                    <div class="flex items-center">
                        <x-lucide-award class="w-3 h-3 mr-2 text-primary-500" />
                        <span>30+ Yıl Deneyim</span>
                    </div>
                    <div class="flex items-center">
                        <x-lucide-users class="w-3 h-3 mr-2 text-primary-500" />
                        <span>500+ Mutlu Müşteri</span>
                    </div>
                    <div class="flex items-center">
                        <x-lucide-circle-check class="w-3 h-3 mr-2 text-primary-500" />
                        <span>%100 Müşteri Memnuniyeti</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-3 mb-6">
                    @if($siteInformation && $siteInformation->footer_logo)
                        <img src="{{ asset($siteInformation->footer_logo) }}"
                             alt="{{ $siteInformation->name }}"
                             class="h-16 w-auto object-contain">
                    @else
                        <div class="h-16 w-20 bg-primary-600 rounded-lg flex items-center justify-center">
                            <x-lucide-building-2 class="w-8 h-8 text-white" />
                        </div>
                    @endif
                </div>
                <p class="text-corporate-300 mb-6 leading-relaxed">
                    Güvenilir, kaliteli ve modern inşaat çözümleri sunarak müşterilerimizin hayallerini gerçeğe dönüştürüyoruz.
                    20 yıllık deneyimimizle sektörde öncü konumdayız.
                </p>
                <div class="flex space-x-4">
                    @if($siteInformation && $siteInformation->facebook)
                        <a href="{{ $siteInformation->facebook }}" target="_blank" class="text-corporate-400 hover:text-primary-400 transition-colors duration-200">
                            <x-lucide-facebook class="w-6 h-6" />
                        </a>
                    @endif
                    @if($siteInformation && $siteInformation->instagram)
                        <a href="{{ $siteInformation->instagram }}" target="_blank" class="text-corporate-400 hover:text-primary-400 transition-colors duration-200">
                            <x-lucide-instagram class="w-6 h-6" />
                        </a>
                    @endif
                    @if($siteInformation && $siteInformation->twitter)
                        <a href="{{ $siteInformation->twitter }}" target="_blank" class="text-corporate-400 hover:text-primary-400 transition-colors duration-200">
                            <x-lucide-twitter class="w-6 h-6" />
                        </a>
                    @endif
                    @if($siteInformation && $siteInformation->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteInformation->whatsapp) }}" target="_blank" class="text-corporate-400 hover:text-primary-400 transition-colors duration-200">
                            <x-lucide-message-circle class="w-6 h-6" />
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-6">Hızlı Linkler</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                            Ana Sayfa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                            Hakkımızda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                            Hizmetlerimiz
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blogs') }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                            Uygulamalar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                            İletişim
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-lg font-semibold mb-6">Hizmetlerimiz</h4>
                <ul class="space-y-3">
                    @if($services && $services->count() > 0)
                        @foreach($services->take(6) as $service)
                            <li>
                                <a href="{{ route('services.show', $service) }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                                    {{ $service->name }}
                                </a>
                            </li>
                        @endforeach

                        @if($services->count() > 6)
                            <li>
                                <a href="{{ route('services') }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200 font-medium">
                                    Tüm Hizmetler →
                                </a>
                            </li>
                        @endif
                    @else
                        <li>
                            <a href="{{ route('services') }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                                Hizmetlerimiz
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-6">İletişim Bilgileri</h4>
                <div class="space-y-4">
                    @if($siteInformation && $siteInformation->address)
                        <div class="flex items-start space-x-3">
                            <x-lucide-map-pin class="w-5 h-5 text-primary-400 mt-1 flex-shrink-0" />
                            <div>
                                <p class="text-corporate-300">
                                    {{ $siteInformation->address }}
                                </p>
                            </div>
                        </div>
                    @endif
                    @if($siteInformation && $siteInformation->phone)
                        <div class="flex items-center space-x-3">
                            <x-lucide-phone class="w-5 h-5 text-primary-400 flex-shrink-0" />
                            <a href="tel:{{ $siteInformation->phone }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                                {{ $siteInformation->phone }}
                            </a>
                        </div>
                    @endif
                    @if($siteInformation && $siteInformation->email)
                        <div class="flex items-center space-x-3">
                            <x-lucide-mail class="w-5 h-5 text-primary-400 flex-shrink-0" />
                            <a href="mailto:{{ $siteInformation->email }}" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">
                                {{ $siteInformation->email }}
                            </a>
                        </div>
                    @endif
                    <div class="flex items-center space-x-3">
                        <x-lucide-clock class="w-5 h-5 text-primary-400 flex-shrink-0" />
                        <div class="text-corporate-300">
                            <p>Pazartesi - Cuma: 08:00 - 18:00</p>
                            <p>Cumartesi: 09:00 - 15:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bg-corporate-950 border-t border-corporate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-corporate-400 text-sm mb-4 md:mb-0">
                    © {{ date('Y') }} {{ $siteInformation->name ?? 'Okyanus Yapı' }}. Tüm hakları saklıdır.
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="{{ route('privacy-policy') }}" class="text-corporate-400 hover:text-primary-400 transition-colors duration-200">
                        Gizlilik Politikası
                    </a>
                    <a href="{{ route('terms-conditions') }}" class="text-corporate-400 hover:text-primary-400 transition-colors duration-200">
                        Kullanım Şartları
                    </a>
                    <a href="{{ route('cookie-policy') }}" class="text-corporate-400 hover:text-primary-400 transition-colors duration-200">
                        Çerez Politikası
                    </a>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-corporate-800 text-center">
                <div class="text-corporate-500 text-xs">
                    Bu websitesi <a href="https://webmarka.com" target="_blank" class="text-corporate-300 hover:text-primary-400 transition-colors duration-200">Webmarka</a> altyapısı ile oluşturulmuştur.
                </div>
            </div>
        </div>
    </div>
</footer>
