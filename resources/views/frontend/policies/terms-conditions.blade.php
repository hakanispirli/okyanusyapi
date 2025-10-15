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
                    <span class="text-gray-900 font-medium">Kullanım Şartları</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-corporate-950 via-corporate-900 to-primary-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white mb-3">
                    Kullanım Şartları
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

                <h2 class="text-xl font-bold text-gray-900 mb-4">1. Genel Hükümler</h2>
                <p class="text-gray-600 mb-6">
                    Bu kullanım şartları, Okyanus Yapı web sitesini ziyaret eden tüm kullanıcılar için geçerlidir. Web sitemizi kullanarak bu şartları kabul etmiş sayılırsınız. Bu şartları kabul etmiyorsanız, web sitemizi kullanmaktan kaçınınız.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">2. Tanımlar</h2>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• <strong>Site:</strong> Okyanus Yapı web sitesi</li>
                    <li>• <strong>Kullanıcı:</strong> Web sitesini ziyaret eden kişi</li>
                    <li>• <strong>Hizmet:</strong> Web sitesi üzerinden sunulan tüm hizmetler</li>
                    <li>• <strong>İçerik:</strong> Web sitesinde yer alan tüm metin, görsel ve diğer materyaller</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">3. Hizmet Kapsamı</h2>
                <p class="text-gray-600 mb-4">Web sitemiz aracılığıyla aşağıdaki hizmetleri sunmaktayız:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• İnşaat ve izolasyon hizmetleri hakkında bilgi verme</li>
                    <li>• Proje örnekleri ve referansların paylaşılması</li>
                    <li>• İletişim formu aracılığıyla teklif alma</li>
                    <li>• Blog ve uygulama örneklerinin paylaşılması</li>
                    <li>• Genel bilgilendirme ve danışmanlık</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">4. Kullanıcı Yükümlülükleri</h2>
                <p class="text-gray-600 mb-4">Web sitemizi kullanırken aşağıdaki kurallara uymakla yükümlüsünüz:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• Yasalara ve ahlak kurallarına uygun davranmak</li>
                    <li>• Başkalarının haklarını ihlal etmemek</li>
                    <li>• Zararlı yazılım veya virüs yüklememek</li>
                    <li>• Telif hakkı ihlali yapmamak</li>
                    <li>• Sahte veya yanıltıcı bilgi vermemek</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">5. Fikri Mülkiyet Hakları</h2>
                <p class="text-gray-600 mb-6">
                    Web sitemizde yer alan tüm içerikler (metin, görsel, logo, tasarım vb.) Okyanus Yapı'ya aittir ve telif hakkı koruması altındadır. Bu içeriklerin izinsiz kullanımı yasaktır.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">6. Sorumluluk Sınırları</h2>
                <p class="text-gray-600 mb-4">Okyanus Yapı aşağıdaki durumlarda sorumluluk kabul etmez:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• Web sitesinin geçici olarak erişilemez olması</li>
                    <li>• Üçüncü taraf web sitelerine yönlendirmeler</li>
                    <li>• Kullanıcıların web sitesini yanlış kullanması</li>
                    <li>• Teknik arızalar ve sistem kesintileri</li>
                    <li>• İnternet bağlantı sorunları</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">7. Kişisel Verilerin Korunması</h2>
                <p class="text-gray-600 mb-6">
                    Kişisel verilerinizin işlenmesi, KVKK (Kişisel Verilerin Korunması Kanunu) kapsamında gerçekleştirilir. Detaylı bilgi için Gizlilik Politikamızı inceleyebilirsiniz.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">8. Çerezler</h2>
                <p class="text-gray-600 mb-6">
                    Web sitemizde kullanıcı deneyimini geliştirmek için çerezler kullanılmaktadır. Çerez kullanımı hakkında detaylı bilgi için Çerez Politikamızı inceleyebilirsiniz.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">9. Değişiklikler</h2>
                <p class="text-gray-600 mb-6">
                    Bu kullanım şartlarını istediğimiz zaman değiştirme hakkını saklı tutarız. Değişiklikler web sitemizde yayınlandığı tarihten itibaren geçerli olur. Önemli değişiklikler için kullanıcılarımızı bilgilendiririz.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">10. Uygulanacak Hukuk</h2>
                <p class="text-gray-600 mb-6">
                    Bu kullanım şartları Türk hukukuna tabidir. Bu şartlardan doğan uyuşmazlıklar İstanbul mahkemelerinde çözülecektir.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">11. İletişim</h2>
                <p class="text-gray-600">
                    Kullanım şartları hakkında sorularınız varsa, bizimle iletişim sayfamızda yer alan telefon veya e-posta aracılığıyla iletişime geçebilirsiniz.
                </p>

            </div>
        </div>
    </section>
</x-app-layout>
