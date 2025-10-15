<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Blog Yazısı Detayı</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $blog->title }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.blogs.edit', $blog) }}"
                   class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-square-pen class="w-4 h-4 mr-2" />
                    Düzenle
                </a>
                <a href="{{ route('admin.blogs.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Blog Header -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex items-start space-x-6">
                @if($blog->featured_image)
                    <div class="flex-shrink-0">
                        <img class="h-32 w-48 object-cover rounded-lg"
                             src="{{ asset($blog->featured_image) }}"
                             alt="{{ $blog->title }}">
                    </div>
                @endif
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $blog->title }}</h2>
                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <x-lucide-user class="w-4 h-4 mr-1" />
                            {{ $blog->author->name ?? 'Bilinmeyen' }}
                        </div>
                        <div class="flex items-center">
                            <x-lucide-folder class="w-4 h-4 mr-1" />
                            {{ $blog->category->name ?? 'Kategori yok' }}
                        </div>
                        <div class="flex items-center">
                            <x-lucide-calendar class="w-4 h-4 mr-1" />
                            {{ $blog->created_at->format('d.m.Y H:i') }}
                        </div>
                        @if($blog->published_at)
                            <div class="flex items-center">
                                <x-lucide-clock class="w-4 h-4 mr-1" />
                                {{ $blog->published_at->format('d.m.Y H:i') }}
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center space-x-4">
                        @if($blog->status)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <x-lucide-check class="w-3 h-3 mr-1" />
                                Yayında
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <x-lucide-x class="w-3 h-3 mr-1" />
                                Taslak
                            </span>
                        @endif
                        @if($blog->featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <x-lucide-star class="w-3 h-3 mr-1" />
                                Öne Çıkan
                            </span>
                        @endif
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <x-lucide-eye class="w-3 h-3 mr-1" />
                            {{ $blog->views }} görüntülenme
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <x-lucide-heart class="w-3 h-3 mr-1" />
                            {{ $blog->likes }} beğeni
                        </span>
                        @if($blog->reading_time)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <x-lucide-clock class="w-3 h-3 mr-1" />
                                {{ $blog->reading_time }} dk okuma
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Excerpt -->
        @if($blog->excerpt)
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Özet</h3>
                <p class="text-gray-700 leading-relaxed">{{ $blog->excerpt }}</p>
            </div>
        @endif

        <!-- Content -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">İçerik</h3>
            <div class="prose max-w-none">
                {!! $blog->content !!}
            </div>
        </div>

        <!-- Gallery Images -->
        @if($blog->gallery_images && count($blog->gallery_images) > 0)
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Galeri Resimleri</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($blog->formatted_gallery_images as $image)
                        <div class="relative group">
                            <img src="{{ $image['url'] }}"
                                 alt="{{ $image['alt'] }}"
                                 class="w-full h-32 object-cover rounded-lg border border-gray-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center">
                                <button onclick="openImageModal('{{ $image['url'] }}', '{{ $image['alt'] }}')"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white text-gray-800 p-2 rounded-full hover:bg-gray-100">
                                    <x-lucide-maximize class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Tags -->
        @if($blog->tags && count($blog->tags) > 0)
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Etiketler</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($blog->formatted_tags as $tag)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ $tag['name'] }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- SEO Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Bilgileri</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Meta Başlık</h4>
                    <p class="text-sm text-gray-600">{{ $blog->meta_title ?: 'Belirtilmemiş' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Meta Açıklama</h4>
                    <p class="text-sm text-gray-600">{{ $blog->meta_description ?: 'Belirtilmemiş' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Meta Anahtar Kelimeler</h4>
                    <p class="text-sm text-gray-600">{{ $blog->meta_keywords ?: 'Belirtilmemiş' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">URL Slug</h4>
                    <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $blog->slug }}</code>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">İstatistikler</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary-600">{{ $blog->views }}</div>
                    <div class="text-sm text-gray-500">Görüntülenme</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $blog->likes }}</div>
                    <div class="text-sm text-gray-500">Beğeni</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $blog->reading_time ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Dakika Okuma</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $blog->tags ? count($blog->tags) : 0 }}</div>
                    <div class="text-sm text-gray-500">Etiket</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900"></h3>
                <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600">
                    <x-lucide-x class="w-6 h-6" />
                </button>
            </div>
            <div class="p-4">
                <img id="modalImage" src="" alt="" class="max-w-full max-h-96 object-contain mx-auto">
            </div>
        </div>
    </div>

    <script>
        function openImageModal(url, alt) {
            document.getElementById('modalImage').src = url;
            document.getElementById('modalImage').alt = alt;
            document.getElementById('modalTitle').textContent = alt;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
</x-admin-layout>
