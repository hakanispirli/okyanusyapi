<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Blog Yazıları</h1>
                <p class="mt-1 text-sm text-gray-600">Blog yazılarını yönetin</p>
            </div>
            <a href="{{ route('admin.blogs.create') }}"
               class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-plus class="w-4 h-4 mr-2" />
                Yeni Blog Yazısı
            </a>
        </div>
    </x-slot>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
            <div class="flex">
                <x-lucide-circle-check class="w-5 h-5 text-green-400 mr-2 mt-0.5" />
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
            <div class="flex">
                <x-lucide-circle-x class="w-5 h-5 text-red-400 mr-2 mt-0.5" />
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Blogs Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        @if($blogs->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Blog Yazısı
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Yazar
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durum
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Yayın Tarihi
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">İşlemler</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($blogs as $blog)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($blog->featured_image)
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-lg object-cover"
                                                     src="{{ asset($blog->featured_image) }}"
                                                     alt="{{ $blog->title }}">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <x-lucide-image class="w-6 h-6 text-gray-400" />
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $blog->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($blog->excerpt, 50) }}</div>
                                            <div class="flex items-center mt-1">
                                                @if($blog->featured)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mr-2">
                                                        <x-lucide-star class="w-3 h-3 mr-1" />
                                                        Öne Çıkan
                                                    </span>
                                                @endif
                                                <span class="text-xs text-gray-400">
                                                    <x-lucide-eye class="w-3 h-3 inline mr-1" />
                                                    {{ $blog->views }} görüntülenme
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($blog->category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $blog->category->name }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">Kategori yok</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $blog->author->name ?? 'Bilinmeyen' }}
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
                                    @if($blog->published_at)
                                        {{ $blog->published_at->format('d.m.Y H:i') }}
                                    @else
                                        <span class="text-gray-400">Yayınlanmamış</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.blogs.show', $blog) }}"
                                           class="text-gray-600 hover:text-primary-600 transition-colors duration-200"
                                           title="Görüntüle">
                                            <x-lucide-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog) }}"
                                           class="text-gray-600 hover:text-primary-600 transition-colors duration-200"
                                           title="Düzenle">
                                            <x-lucide-square-pen class="w-4 h-4" />
                                        </a>
                                        <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" class="inline"
                                              onsubmit="return confirm('Bu blog yazısını silmek istediğinizden emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-gray-600 hover:text-red-600 transition-colors duration-200"
                                                    title="Sil">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($blogs->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $blogs->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <x-lucide-file-text class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz blog yazısı bulunmuyor</h3>
                <p class="text-gray-500 mb-6">İlk blog yazınızı oluşturmak için aşağıdaki butona tıklayın.</p>
                <a href="{{ route('admin.blogs.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-plus class="w-4 h-4 mr-2" />
                    Yeni Blog Yazısı Oluştur
                </a>
            </div>
        @endif
    </div>
</x-admin-layout>
