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
                    <span class="text-gray-900 font-medium">Çerez Politikası</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-corporate-950 via-corporate-900 to-primary-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white mb-3">
                    Çerez Politikası
                </h1>
                <p class="text-gray-200 max-w-2xl mx-auto text-base">
                    Son güncelleme: {{ date('d.m.Y') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-8 md:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">

                <h2 class="text-xl font-bold text-gray-900 mb-4">1. Çerez Nedir?</h2>
                <p class="text-gray-600 mb-6">
                    Çerezler, web sitelerini ziyaret ettiğinizde tarayıcınız tarafından bilgisayarınıza veya mobil cihazınıza kaydedilen küçük metin dosyalarıdır. Bu dosyalar, web sitesinin daha iyi çalışmasını sağlar ve size daha iyi bir kullanıcı deneyimi sunar.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">2. Çerez Türleri</h2>
                <p class="text-gray-600 mb-4">Web sitemizde aşağıdaki türde çerezler kullanılmaktadır:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• <strong>Zorunlu Çerezler:</strong> Web sitesinin temel işlevlerini yerine getirmesi için gerekli olan çerezler</li>
                    <li>• <strong>Performans Çerezleri:</strong> Web sitesinin performansını analiz etmek için kullanılan çerezler</li>
                    <li>• <strong>Fonksiyonel Çerezler:</strong> Kullanıcı tercihlerini hatırlamak için kullanılan çerezler</li>
                    <li>• <strong>Analitik Çerezler:</strong> Web sitesi kullanım istatistiklerini toplamak için kullanılan çerezler</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">3. Çerezlerin Kullanım Amacı</h2>
                <p class="text-gray-600 mb-4">Çerezleri aşağıdaki amaçlarla kullanırız:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• Web sitesinin düzgün çalışmasını sağlamak</li>
                    <li>• Kullanıcı deneyimini geliştirmek</li>
                    <li>• Web sitesi trafiğini analiz etmek</li>
                    <li>• Kullanıcı tercihlerini hatırlamak</li>
                    <li>• Güvenlik önlemlerini uygulamak</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">4. Üçüncü Taraf Çerezler</h2>
                <p class="text-gray-600 mb-6">
                    Web sitemizde Google Analytics gibi üçüncü taraf hizmetlerin çerezleri de kullanılabilir. Bu çerezler, web sitesi performansını analiz etmek ve size daha iyi hizmet sunmak için kullanılır.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">5. Çerez Yönetimi</h2>
                <p class="text-gray-600 mb-4">Çerezleri aşağıdaki yöntemlerle yönetebilirsiniz:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• Tarayıcınızın ayarlarından çerezleri devre dışı bırakabilirsiniz</li>
                    <li>• Mevcut çerezleri silebilirsiniz</li>
                    <li>• Çerez uyarılarını etkinleştirebilirsiniz</li>
                    <li>• Belirli web siteleri için çerez ayarlarını yapılandırabilirsiniz</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">6. Çerez Ayarları</h2>
                <p class="text-gray-600 mb-4">Popüler tarayıcılarda çerez ayarları:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• <strong>Chrome:</strong> Ayarlar > Gizlilik ve güvenlik > Çerezler ve diğer site verileri</li>
                    <li>• <strong>Firefox:</strong> Ayarlar > Gizlilik ve güvenlik > Çerezler ve site verileri</li>
                    <li>• <strong>Safari:</strong> Tercihler > Gizlilik > Çerezleri yönet</li>
                    <li>• <strong>Edge:</strong> Ayarlar > Çerezler ve site izinleri</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">7. Çerez Kullanımının Sonuçları</h2>
                <p class="text-gray-600 mb-6">
                    Çerezleri devre dışı bırakırsanız, web sitemizin bazı özellikleri düzgün çalışmayabilir. Bu durumda kullanıcı deneyiminiz olumsuz etkilenebilir.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">8. İletişim</h2>
                <p class="text-gray-600">
                    Çerez politikamız hakkında sorularınız varsa, bizimle iletişim sayfamızda yer alan telefon veya e-posta aracılığıyla iletişime geçebilirsiniz.
                </p>

            </div>
        </div>
    </section>
</x-app-layout>
