<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                <p class="mt-1 text-sm text-gray-600">Kategori detayları ve blog yazıları</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.blog-categories.edit', $category) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-square-pen class="w-4 h-4 mr-2" />
                    Düzenle
                </a>
                <a href="{{ route('admin.blog-categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Category Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Basic Info -->
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Kategori Bilgileri</h3>

                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kategori Adı</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">URL Slug</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $category->slug }}</code>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Durum</dt>
                                    <dd class="mt-1">
                                        @if($category->status)
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
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Oluşturulma Tarihi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('d.m.Y H:i') }}</dd>
                                </div>

                                @if($category->description)
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Açıklama</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $category->description }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Statistics -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">İstatistikler</h3>

                            <div class="space-y-4">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <x-lucide-file-text class="h-8 w-8 text-blue-600" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-blue-800">Toplam Blog</p>
                                            <p class="text-2xl font-semibold text-blue-900">{{ $category->blogs_count }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-green-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <x-lucide-eye class="h-8 w-8 text-green-600" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-green-800">Yayınlanan Blog</p>
                                            <p class="text-2xl font-semibold text-green-900">{{ $category->published_blogs_count }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($category->meta_title || $category->meta_description || $category->meta_keywords)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Bilgileri</h3>

                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-1">
                            @if($category->meta_title)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Meta Başlık</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->meta_title }}</dd>
                                </div>
                            @endif

                            @if($category->meta_description)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Meta Açıklama</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->meta_description }}</dd>
                                </div>
                            @endif

                            @if($category->meta_keywords)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Meta Anahtar Kelimeler</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->meta_keywords }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            @endif

            <!-- Related Blogs -->
            @if($category->blogs->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Bu Kategoriye Ait Blog Yazıları</h3>
                            <a href="{{ route('admin.blogs.index', ['category' => $category->id]) }}" class="text-orange-600 hover:text-orange-900 text-sm font-medium">
                                Tümünü Görüntüle →
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Başlık
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Yazar
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Durum
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Oluşturulma
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">İşlemler</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($category->blogs->take(5) as $blog)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $blog->title }}</div>
                                                @if($blog->excerpt)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($blog->excerpt, 50) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $blog->author->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
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
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $blog->created_at->format('d.m.Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.blogs.show', $blog) }}" class="text-orange-600 hover:text-orange-900">
                                                    <x-lucide-eye class="w-4 h-4" />
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($category->blogs->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.blogs.index', ['category' => $category->id]) }}" class="text-orange-600 hover:text-orange-900 text-sm font-medium">
                                    {{ $category->blogs->count() - 5 }} blog daha göster →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-center py-8">
                            <x-lucide-file-x class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Bu kategoriye ait blog bulunamadı</h3>
                            <p class="mt-1 text-sm text-gray-500">Henüz bu kategoriye ait hiç blog yazısı oluşturulmamış.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.blogs.create', ['category' => $category->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    <x-lucide-plus class="w-4 h-4 mr-2" />
                                    Bu kategoriye blog ekle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
