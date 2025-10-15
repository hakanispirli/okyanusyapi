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
                    <span class="text-gray-900 font-medium">İletişim</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-corporate-950 via-corporate-900 to-primary-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white mb-3">
                    İletişim
                </h1>
                <p class="text-gray-200 max-w-2xl mx-auto text-base">
                    Projeleriniz için profesyonel danışmanlık ve teklif almak istiyorsanız, bizimle iletişime geçin
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="py-8 md:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white border border-gray-200 rounded-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Mesaj Gönderin</h2>
                        <p class="text-gray-600 mb-8">Projeleriniz hakkında detaylı bilgi almak için formu doldurun.</p>

                        <form id="contactForm" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Ad Soyad <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                                        placeholder="Adınız ve soyadınız">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        E-posta <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                                        placeholder="ornek@email.com">
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Telefon
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                                    placeholder="+90 (5XX) XXX XX XX">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konu <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="subject"
                                    name="subject"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200">
                                    <option value="">Konu seçiniz</option>
                                    <option value="genel-bilgi">Genel Bilgi</option>
                                    <option value="proje-teklifi">Proje Teklifi</option>
                                    <option value="izolasyon-hizmetleri">İzolasyon Hizmetleri</option>
                                    <option value="danismanlik">Danışmanlık</option>
                                    <option value="diger">Diğer</option>
                                </select>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                    Mesaj <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    required
                                    rows="5"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 resize-none"
                                    placeholder="Mesajınızı buraya yazın..."></textarea>
                            </div>

                            <button
                                type="submit"
                                class="w-full px-6 py-3 bg-primary-600 text-white rounded-lg font-medium text-base hover:bg-primary-700 transition-colors duration-200 group">
                                <span id="submitText">Mesaj Gönder</span>
                                <x-lucide-send class="w-4 h-4 ml-2 inline group-hover:translate-x-1 transition-transform duration-200" />
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="mt-8 lg:mt-0">
                    <div class="space-y-6">
                        <!-- Contact Information -->
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <x-lucide-phone class="w-4 h-4 mr-2 text-gray-600" />
                                    İletişim Bilgileri
                                </h3>
                            </div>
                            <div class="p-4 space-y-4">
                                @if($siteInformation)
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <x-lucide-phone class="w-5 h-5 text-gray-600" />
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Telefon</div>
                                            <div class="text-sm text-gray-600">{{ $siteInformation->phone }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <x-lucide-mail class="w-5 h-5 text-gray-600" />
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">E-posta</div>
                                            <div class="text-sm text-gray-600">{{ $siteInformation->email }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <x-lucide-map-pin class="w-5 h-5 text-gray-600" />
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Adres</div>
                                            <div class="text-sm text-gray-600">{{ $siteInformation->address }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <x-lucide-info class="mx-auto h-8 w-8 text-gray-400" />
                                        <p class="text-sm text-gray-500 mt-2">İletişim bilgileri yüklenemedi</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <x-lucide-clock class="w-4 h-4 mr-2 text-gray-600" />
                                    Çalışma Saatleri
                                </h3>
                            </div>
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-600">Pazartesi - Cuma</span>
                                    <span class="text-sm font-medium text-gray-900">08:00 - 18:00</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-600">Cumartesi</span>
                                    <span class="text-sm font-medium text-gray-900">09:00 - 16:00</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm text-gray-600">Pazar</span>
                                    <span class="text-sm font-medium text-gray-900">Kapalı</span>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        @if($siteInformation && ($siteInformation->facebook || $siteInformation->instagram || $siteInformation->twitter || $siteInformation->whatsapp))
                            <div class="bg-white border border-gray-200 rounded-lg">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                        <x-lucide-share-2 class="w-4 h-4 mr-2 text-gray-600" />
                                        Sosyal Medya
                                    </h3>
                                </div>
                                <div class="p-4">
                                    <div class="flex flex-wrap gap-3">
                                        @if($siteInformation->facebook)
                                            <a href="{{ $siteInformation->facebook }}" target="_blank" class="flex items-center space-x-2 text-gray-600 hover:text-primary-600 transition-colors">
                                                <x-lucide-facebook class="w-4 h-4" />
                                                <span class="text-sm">Facebook</span>
                                            </a>
                                        @endif
                                        @if($siteInformation->instagram)
                                            <a href="{{ $siteInformation->instagram }}" target="_blank" class="flex items-center space-x-2 text-gray-600 hover:text-primary-600 transition-colors">
                                                <x-lucide-instagram class="w-4 h-4" />
                                                <span class="text-sm">Instagram</span>
                                            </a>
                                        @endif
                                        @if($siteInformation->twitter)
                                            <a href="{{ $siteInformation->twitter }}" target="_blank" class="flex items-center space-x-2 text-gray-600 hover:text-primary-600 transition-colors">
                                                <x-lucide-twitter class="w-4 h-4" />
                                                <span class="text-sm">Twitter</span>
                                            </a>
                                        @endif
                                        @if($siteInformation->whatsapp)
                                            <a href="https://wa.me/{{ $siteInformation->whatsapp }}" target="_blank" class="flex items-center space-x-2 text-gray-600 hover:text-primary-600 transition-colors">
                                                <x-lucide-message-circle class="w-4 h-4" />
                                                <span class="text-sm">WhatsApp</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Success/Error Messages --}}
    <div id="messageContainer" class="fixed top-4 right-4 z-50 hidden">
        <div id="messageContent" class="px-6 py-4 rounded-lg border max-w-sm">
            <div class="flex items-center gap-3">
                <div id="messageIcon"></div>
                <div>
                    <div id="messageTitle" class="font-semibold"></div>
                    <div id="messageText" class="text-sm mt-1"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alpine.js for form handling --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const submitText = document.getElementById('submitText');
            const messageContainer = document.getElementById('messageContainer');
            const messageContent = document.getElementById('messageContent');
            const messageIcon = document.getElementById('messageIcon');
            const messageTitle = document.getElementById('messageTitle');
            const messageText = document.getElementById('messageText');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');

                // Disable submit button
                submitButton.disabled = true;
                submitText.textContent = 'Gönderiliyor...';

                try {
                    const response = await fetch('{{ route("contact.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showMessage('success', 'Başarılı!', data.message);
                        form.reset();
                    } else {
                        showMessage('error', 'Hata!', data.message);
                    }
                } catch (error) {
                    showMessage('error', 'Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.');
                } finally {
                    // Re-enable submit button
                    submitButton.disabled = false;
                    submitText.textContent = 'Mesaj Gönder';
                }
            });

            function showMessage(type, title, text) {
                messageContent.className = `px-6 py-4 rounded-lg border max-w-sm ${
                    type === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'
                }`;

                messageIcon.innerHTML = type === 'success'
                    ? '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
                    : '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

                messageTitle.textContent = title;
                messageTitle.className = `font-semibold ${type === 'success' ? 'text-green-900' : 'text-red-900'}`;
                messageText.textContent = text;
                messageText.className = `text-sm mt-1 ${type === 'success' ? 'text-green-700' : 'text-red-700'}`;

                messageContainer.classList.remove('hidden');

                setTimeout(() => {
                    messageContainer.classList.add('hidden');
                }, 5000);
            }
        });
    </script>
</x-app-layout>
