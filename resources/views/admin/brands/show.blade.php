<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Marka Detayları</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $brand->name }} markasının detayları</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.brands.edit', $brand) }}"
                   class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-square-pen class="w-4 h-4 mr-2" />
                    Düzenle
                </a>
                <a href="{{ route('admin.brands.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Brand Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Marka Bilgileri</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Marka Adı</label>
                    <p class="text-sm text-gray-900">{{ $brand->name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                    @if($brand->status)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <x-lucide-check class="w-3 h-3 mr-1" />
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <x-lucide-x class="w-3 h-3 mr-1" />
                            Pasif
                        </span>
                    @endif
                </div>
            </div>

            @if($brand->description)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Açıklama</label>
                    <p class="text-sm text-gray-900">{{ $brand->description }}</p>
                </div>
            @endif
        </div>

        <!-- Brand Images Section -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Marka Resimleri</h3>

            @if($brand->brands_images && count($brand->brands_images) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($brand->brands_images as $index => $image)
                        <div class="relative group">
                            <img src="{{ $image['url'] ?? '' }}"
                                 alt="{{ $image['alt'] ?? 'Marka resmi' }}"
                                 class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 rounded-b-lg truncate">
                                {{ $image['alt'] ?? 'Marka resmi' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <x-lucide-image class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                    <p class="text-gray-500">Henüz marka resmi yüklenmemiş</p>
                </div>
            @endif
        </div>

        <!-- Timestamps -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Zaman Bilgileri</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Oluşturulma Tarihi</label>
                    <p class="text-sm text-gray-900">{{ $brand->created_at->format('d.m.Y H:i') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Son Güncelleme</label>
                    <p class="text-sm text-gray-900">{{ $brand->updated_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">İşlemler</h3>

            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.brands.edit', $brand) }}"
                   class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-square-pen class="w-4 h-4 mr-2" />
                    Düzenle
                </a>

                <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" class="inline"
                      onsubmit="return confirm('Bu markayı silmek istediğinizden emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                        Sil
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
