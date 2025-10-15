<x-app-layout :seoData="$seoData">
    {{-- Breadcrumb - Shadcn-UI Style --}}
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
                    <span class="text-gray-900 font-medium">Hakkımızda</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section - Image + Title + Content --}}
    <section class="relative bg-white py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                {{-- Image --}}
                <div class="order-2 lg:order-1">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/3]">
                        <img
                            src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&h=600&fit=crop"
                            alt="Okyanus Yapı - Hakkımızda"
                            class="w-full h-full object-cover"
                            loading="eager">
                        <div class="absolute inset-0 bg-gradient-to-t from-corporate-900/50 to-transparent"></div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 rounded-full text-primary-600 text-sm font-medium mb-6">
                        <x-lucide-building class="w-4 h-4" />
                        <span>Okyanus Yapı</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-corporate-900 mb-6 leading-tight">
                        Güvenilir İnşaat ve İzolasyon Çözümleri
                    </h1>

                    <div class="prose prose-lg max-w-none">
                        <p class="text-gray-600 leading-relaxed mb-4">
                            1995 yılından bu yana inşaat ve izolasyon sektöründe faaliyet gösteren Okyanus Yapı, kaliteli işçilik ve müşteri memnuniyeti odaklı yaklaşımıyla sektörde öncü konumdadır.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Deneyimli kadromuz ve modern teknolojik altyapımızla, konut, ticari ve endüstriyel projelerde kapsamlı çözümler sunmaktayız. Her projede en yüksek kalite standartlarını hedefliyor, müşterilerimize güvenilir ve uzun ömürlü yapılar teslim ediyoruz.
                        </p>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-3 gap-4 mt-8 pt-8 border-t border-gray-200">
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-primary-600">30+</div>
                            <div class="text-sm text-gray-600 mt-1">Yıllık Tecrübe</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-primary-600">500+</div>
                            <div class="text-sm text-gray-600 mt-1">Tamamlanan Proje</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-primary-600">%100</div>
                            <div class="text-sm text-gray-600 mt-1">Müşteri Memnuniyeti</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Divider Line --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
    </div>

    {{-- Timeline Section - Mobile Friendly --}}
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-corporate-900 mb-4">
                    Yolculuğumuz
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    30 yılı aşkın tecrübemizle sektördeki gelişimimiz
                </p>
            </div>

            {{-- Timeline - Mobile & Desktop Optimized --}}
            <div class="relative max-w-6xl mx-auto">
                {{-- Timeline Line --}}
                <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary-500 via-primary-400 to-primary-300 md:transform md:-translate-x-1/2"></div>

                {{-- Timeline Items --}}
                <div class="space-y-8 md:space-y-16">
                    {{-- Item 1: 1995 --}}
                    <div class="relative flex items-start md:items-center gap-6 md:gap-0">
                        {{-- Timeline Dot --}}
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-500 border-4 border-white shadow-lg z-10 md:absolute md:left-1/2 md:transform md:-translate-x-1/2"></div>

                        {{-- Content - Left Side on Desktop --}}
                        <div class="flex-1 bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 md:w-[calc(50%-3rem)] md:mr-auto md:pr-8">
                            <div class="text-sm font-semibold text-primary-600 mb-2">1995</div>
                            <h3 class="text-lg font-bold text-corporate-900 mb-2">Kuruluş</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Okyanus Yapı, İstanbul'da küçük bir ekiple inşaat sektörüne adım attı. İlk projelerimizle güven kazandık.
                            </p>
                        </div>
                    </div>

                    {{-- Item 2: 2005 --}}
                    <div class="relative flex items-start md:items-center gap-6 md:gap-0">
                        {{-- Timeline Dot --}}
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-500 border-4 border-white shadow-lg z-10 md:absolute md:left-1/2 md:transform md:-translate-x-1/2"></div>

                        {{-- Content - Right Side on Desktop --}}
                        <div class="flex-1 bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 md:w-[calc(50%-3rem)] md:ml-auto md:pl-8">
                            <div class="text-sm font-semibold text-primary-600 mb-2">2005</div>
                            <h3 class="text-lg font-bold text-corporate-900 mb-2">Büyüme ve Gelişim</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Ekibimizi genişlettik, modern teknolojilere yatırım yaptık. Konut projelerinde uzmanlaştık.
                            </p>
                        </div>
                    </div>

                    {{-- Item 3: 2015 --}}
                    <div class="relative flex items-start md:items-center gap-6 md:gap-0">
                        {{-- Timeline Dot --}}
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-500 border-4 border-white shadow-lg z-10 md:absolute md:left-1/2 md:transform md:-translate-x-1/2"></div>

                        {{-- Content - Left Side on Desktop --}}
                        <div class="flex-1 bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 md:w-[calc(50%-3rem)] md:mr-auto md:pr-8">
                            <div class="text-sm font-semibold text-primary-600 mb-2">2015</div>
                            <h3 class="text-lg font-bold text-corporate-900 mb-2">İnovasyon ve Kalite</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                ISO sertifikalarını aldık, çevre dostu malzemeler kullanmaya başladık. Kalite standartlarımızı yükselttik.
                            </p>
                        </div>
                    </div>

                    {{-- Item 4: 2025 --}}
                    <div class="relative flex items-start md:items-center gap-6 md:gap-0">
                        {{-- Timeline Dot --}}
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-600 border-4 border-white shadow-lg z-10 animate-pulse md:absolute md:left-1/2 md:transform md:-translate-x-1/2"></div>

                        {{-- Content - Right Side on Desktop --}}
                        <div class="flex-1 bg-gradient-to-br from-primary-50 to-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-primary-100 md:w-[calc(50%-3rem)] md:ml-auto md:pl-8">
                            <div class="text-sm font-semibold text-primary-600 mb-2">2025</div>
                            <h3 class="text-lg font-bold text-corporate-900 mb-2">Bugün ve Gelecek</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                500'den fazla başarılı projeyle sektörün öncü firmalarından biriyiz. Teknoloji ve kaliteye yatırım yapmaya devam ediyoruz.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Divider Line --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
    </div>

    {{-- Mission & Vision Section --}}
    <section class="py-8 md:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                {{-- Mission --}}
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <x-lucide-target class="w-4 h-4 mr-2 text-primary-600" />
                            Misyonumuz
                        </h3>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Müşterilerimize en yüksek kalitede inşaat ve izolasyon hizmetleri sunarak, güvenli, konforlu ve uzun ömürlü yapılar inşa etmek.
                        </p>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <x-lucide-check class="w-3 h-3 text-primary-600" />
                                </div>
                                <span class="text-sm text-gray-600">Kaliteden ödün vermeden çalışmak</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <x-lucide-check class="w-3 h-3 text-primary-600" />
                                </div>
                                <span class="text-sm text-gray-600">Müşteri memnuniyetini ön planda tutmak</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <x-lucide-check class="w-3 h-3 text-primary-600" />
                                </div>
                                <span class="text-sm text-gray-600">Zamanında ve bütçe dahilinde teslim etmek</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Vision --}}
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <x-lucide-eye class="w-4 h-4 mr-2 text-primary-600" />
                            Vizyonumuz
                        </h3>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Türkiye'nin inşaat ve izolasyon sektöründe en güvenilir ve tercih edilen firma olmak, sürdürülebilir yapılar inşa ederek gelecek nesillere katkı sağlamak.
                        </p>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <x-lucide-check class="w-3 h-3 text-primary-600" />
                                </div>
                                <span class="text-sm text-gray-600">Sektörde öncü ve yenilikçi olmak</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <x-lucide-check class="w-3 h-3 text-primary-600" />
                                </div>
                                <span class="text-sm text-gray-600">Çevre dostu ve sürdürülebilir projeler geliştirmek</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <x-lucide-check class="w-3 h-3 text-primary-600" />
                                </div>
                                <span class="text-sm text-gray-600">Ulusal ve uluslararası arenada büyümek</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

