<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $service->name }}</h1>
                <p class="mt-1 text-sm text-gray-600">Hizmet detaylarını görüntüleyin</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.services.edit', $service) }}"
                   class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-square-pen class="w-4 h-4 mr-2" />
                    Düzenle
                </a>
                <a href="{{ route('admin.services.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Basic Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Temel Bilgiler</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hizmet Adı</label>
                    <p class="text-sm text-gray-900">{{ $service->name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
                    <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $service->slug }}</code>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kısa Açıklama</label>
                    <p class="text-sm text-gray-900">{{ $service->description ?: 'Açıklama girilmemiş' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                    @if($service->status)
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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Oluşturulma Tarihi</label>
                    <p class="text-sm text-gray-900">{{ $service->created_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Hero Bölümü</h3>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Başlığı</label>
                    <p class="text-sm text-gray-900">{{ $service->title }}</p>
                </div>

                @if($service->hero_image)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hero Resmi</label>
                        <img src="{{ asset($service->hero_image) }}"
                             alt="{{ $service->name }}"
                             class="h-48 w-full object-cover rounded-lg border border-gray-300">
                    </div>
                @else
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hero Resmi</label>
                        <div class="h-48 w-full bg-gray-200 rounded-lg border border-gray-300 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <x-lucide-image class="w-12 h-12 mx-auto mb-2" />
                                <p class="text-sm">Resim yüklenmemiş</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Process Section -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Süreç Bölümü</h3>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Süreç Başlığı</label>
                    <p class="text-sm text-gray-900">{{ $service->process_title ?: 'Başlık girilmemiş' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Süreç Açıklaması</label>
                    <p class="text-sm text-gray-900">{{ $service->process_description ?: 'Açıklama girilmemiş' }}</p>
                </div>

                @if($service->process_steps && count($service->process_steps) > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Süreç Adımları</label>
                        <div class="space-y-3">
                            @foreach($service->process_steps as $index => $step)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-primary-600 text-white text-sm font-bold rounded-full mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $step['title'] ?? 'Başlık yok' }}</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-11">{{ $step['description'] ?? 'Açıklama yok' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Süreç Adımları</label>
                        <p class="text-sm text-gray-500 italic">Süreç adımları tanımlanmamış</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Galeri Bölümü</h3>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Başlığı</label>
                    <p class="text-sm text-gray-900">{{ $service->gallery_title ?: 'Başlık girilmemiş' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Açıklaması</label>
                    <p class="text-sm text-gray-900">{{ $service->gallery_description ?: 'Açıklama girilmemiş' }}</p>
                </div>

                @if($service->gallery_images && count($service->gallery_images) > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Resimleri</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($service->gallery_images as $image)
                                <div class="relative">
                                    <img src="{{ $image['url'] ?? '' }}"
                                         alt="{{ $image['alt'] ?? 'Galeri resmi' }}"
                                         class="w-full h-24 object-cover rounded-lg border border-gray-300">
                                    <div class="absolute bottom-1 left-1 right-1 bg-black bg-opacity-50 text-white text-xs p-1 rounded">
                                        {{ $image['alt'] ?? 'Alt metin yok' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Resimleri</label>
                        <p class="text-sm text-gray-500 italic">Galeri resimleri tanımlanmamış</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- SEO Content -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">SEO İçeriği</h3>

            @if($service->seo_content)
                <div class="prose prose-sm max-w-none">
                    {!! $service->seo_content !!}
                </div>
            @else
                <p class="text-sm text-gray-500 italic">SEO içeriği girilmemiş</p>
            @endif
        </div>

        <!-- Actions -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">İşlemler</h3>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.services.edit', $service) }}"
                       class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <x-lucide-square-pen class="w-4 h-4 mr-2" />
                        Düzenle
                    </a>

                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline"
                          onsubmit="return confirm('Bu hizmeti silmek istediğinizden emin misiniz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                            Sil
                        </button>
                    </form>
                </div>

                <div class="text-sm text-gray-500">
                    Son güncelleme: {{ $service->updated_at->format('d.m.Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
