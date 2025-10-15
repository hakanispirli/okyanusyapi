<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Site Bilgileri</h2>
            @if(!$siteInfo)
            <a href="{{ route('admin.site-information.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg shadow-md hover:from-orange-600 hover:to-orange-700 transition-all duration-200">
                <x-lucide-plus class="w-5 h-5 mr-2" />
                Yeni Oluştur
            </a>
            @endif
        </div>
    </x-slot>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
        <div class="flex items-center">
            <x-lucide-circle-check class="w-5 h-5 mr-2" />
            <span>{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-green-600 hover:text-green-800">
            <x-lucide-x class="w-4 h-4" />
        </button>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
        <div class="flex items-center">
            <x-lucide-circle-alert class="w-5 h-5 mr-2" />
            <span>{{ session('error') }}</span>
        </div>
        <button @click="show = false" class="text-red-600 hover:text-red-800">
            <x-lucide-x class="w-4 h-4" />
        </button>
    </div>
    @endif

    @if($siteInfo)
    <!-- Site Information Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Mevcut Site Bilgileri</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.site-information.edit', $siteInfo) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors">
                        <x-lucide-square-pen class="w-4 h-4 mr-2" />
                        Düzenle
                    </a>
                    <form action="{{ route('admin.site-information.destroy', $siteInfo) }}" method="POST" class="inline" onsubmit="return confirm('Site bilgilerini silmek istediğinizden emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors">
                            <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                            Sil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site Adı</label>
                    <p class="text-gray-900">{{ $siteInfo->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                    <p class="text-gray-900">{{ $siteInfo->phone }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                    <p class="text-gray-900">{{ $siteInfo->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adres</label>
                    <p class="text-gray-900">{{ $siteInfo->address }}</p>
                </div>
            </div>

            <!-- Logos -->
            <div class="grid md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Header Logo</label>
                    @if($siteInfo->header_logo)
                    <img src="{{ asset($siteInfo->header_logo) }}" alt="Header Logo" class="h-16 object-contain bg-gray-100 p-2 rounded">
                    @else
                    <p class="text-gray-500 text-sm">Logo yüklenmemiş</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Footer Logo</label>
                    @if($siteInfo->footer_logo)
                    <img src="{{ asset($siteInfo->footer_logo) }}" alt="Footer Logo" class="h-16 object-contain bg-gray-100 p-2 rounded">
                    @else
                    <p class="text-gray-500 text-sm">Logo yüklenmemiş</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                    @if($siteInfo->favicon)
                    <img src="{{ asset($siteInfo->favicon) }}" alt="Favicon" class="h-16 object-contain bg-gray-100 p-2 rounded">
                    @else
                    <p class="text-gray-500 text-sm">Favicon yüklenmemiş</p>
                    @endif
                </div>
            </div>

            <!-- Social Media -->
            <div class="border-t pt-6">
                <h4 class="text-md font-semibold text-gray-800 mb-4">Sosyal Medya Bağlantıları</h4>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="flex items-center space-x-2">
                        <x-lucide-facebook class="w-5 h-5 text-blue-600" />
                        <span class="text-sm font-medium text-gray-700">Facebook:</span>
                        <a href="{{ $siteInfo->facebook }}" target="_blank" class="text-sm text-blue-600 hover:underline">{{ $siteInfo->facebook ?? '-' }}</a>
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-lucide-instagram class="w-5 h-5 text-pink-600" />
                        <span class="text-sm font-medium text-gray-700">Instagram:</span>
                        <a href="{{ $siteInfo->instagram }}" target="_blank" class="text-sm text-blue-600 hover:underline">{{ $siteInfo->instagram ?? '-' }}</a>
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-lucide-twitter class="w-5 h-5 text-sky-500" />
                        <span class="text-sm font-medium text-gray-700">Twitter:</span>
                        <a href="{{ $siteInfo->twitter }}" target="_blank" class="text-sm text-blue-600 hover:underline">{{ $siteInfo->twitter ?? '-' }}</a>
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-lucide-message-circle class="w-5 h-5 text-green-600" />
                        <span class="text-sm font-medium text-gray-700">WhatsApp:</span>
                        <span class="text-sm text-gray-900">{{ $siteInfo->whatsapp ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <div class="max-w-md mx-auto">
            <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <x-lucide-info class="w-10 h-10 text-orange-600" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Site Bilgisi Bulunamadı</h3>
            <p class="text-gray-600 mb-6">Henüz site bilgisi oluşturulmamış. Lütfen yeni bir site bilgisi oluşturun.</p>
            <a href="{{ route('admin.site-information.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg shadow-md hover:from-orange-600 hover:to-orange-700 transition-all duration-200">
                <x-lucide-plus class="w-5 h-5 mr-2" />
                Site Bilgisi Oluştur
            </a>
        </div>
    </div>
    @endif
</x-admin-layout>

