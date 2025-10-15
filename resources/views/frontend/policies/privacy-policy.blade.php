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
                    <span class="text-gray-900 font-medium">Gizlilik Politikası</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-corporate-950 via-corporate-900 to-primary-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white mb-3">
                    Gizlilik Politikası
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

                <h2 class="text-xl font-bold text-gray-900 mb-4">1. Giriş</h2>
                <p class="text-gray-600 mb-6">
                    Okyanus Yapı olarak, kişisel verilerinizin gizliliğini korumak bizim önceliklerimiz arasındadır. Bu Gizlilik Politikası, web sitemizi ziyaret ettiğinizde veya hizmetlerimizi kullandığınızda kişisel bilgilerinizin nasıl toplandığını, kullanıldığını ve korunduğunu açıklamaktadır.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">2. Toplanan Bilgiler</h2>
                <p class="text-gray-600 mb-4">Web sitemizi kullanırken aşağıdaki bilgileri toplayabiliriz:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• Ad, soyad ve iletişim bilgileri (e-posta, telefon, adres)</li>
                    <li>• IP adresi ve tarayıcı bilgileri</li>
                    <li>• Web sitesi kullanım verileri</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">3. Bilgilerin Kullanım Amacı</h2>
                <p class="text-gray-600 mb-4">Topladığımız bilgileri aşağıdaki amaçlarla kullanırız:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• Size hizmet sunmak ve taleplerinizi yanıtlamak</li>
                    <li>• Web sitemizi geliştirmek ve güvenliğini sağlamak</li>
                    <li>• Yasal yükümlülüklerimizi yerine getirmek</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">4. Veri Güvenliği</h2>
                <p class="text-gray-600 mb-6">
                    Kişisel verilerinizi korumak için uygun teknik ve idari güvenlik önlemlerini alırız. Verileriniz güvenli sunucularda saklanır ve yetkisiz erişime karşı korunur.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">5. Çerezler</h2>
                <p class="text-gray-600 mb-6">
                    Web sitemizde kullanıcı deneyimini geliştirmek için çerezler kullanılmaktadır. Tarayıcınızın ayarlarından çerezleri devre dışı bırakabilirsiniz.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">6. Haklarınız</h2>
                <p class="text-gray-600 mb-4">KVKK kapsamında aşağıdaki haklara sahipsiniz:</p>
                <ul class="text-gray-600 mb-6 space-y-2">
                    <li>• Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
                    <li>• İşlenen kişisel verileriniz hakkında bilgi talep etme</li>
                    <li>• Kişisel verilerinizin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme</li>
                    <li>• Yurt içinde veya yurt dışında kişisel verilerinizin aktarıldığı üçüncü kişileri bilme</li>
                    <li>• Kişisel verilerinizin eksik veya yanlış işlenmiş olması hâlinde bunların düzeltilmesini isteme</li>
                    <li>• Kişisel verilerinizin silinmesini veya yok edilmesini isteme</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mb-4">7. İletişim</h2>
                <p class="text-gray-600 mb-4">
                    Gizlilik politikamız hakkında sorularınız varsa veya kişisel
                    verilerinizle ilgili haklarınızı kullanmak istiyorsanız, bizimle iletişim sayfamızda yer alan telefon veya e-posta aracılığıyla iletişime geçebilirsiniz.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mb-4">8. Politika Değişiklikleri</h2>
                <p class="text-gray-600">
                    Bu gizlilik politikasını zaman zaman güncelleyebiliriz. Önemli değişiklikler olduğunda, web sitemizde duyuru yaparak sizi bilgilendireceğiz.
                </p>

            </div>
        </div>
    </section>
</x-app-layout>
