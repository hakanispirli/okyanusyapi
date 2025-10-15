<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Markalar</h1>
                <p class="mt-1 text-sm text-gray-600">Marka logolarını yönetin</p>
            </div>
            <a href="{{ route('admin.brands.create') }}"
               class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-plus class="w-4 h-4 mr-2" />
                Yeni Marka
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

    <!-- Brands Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        @if($brands->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Marka
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Logo
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
                        @foreach($brands as $brand)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $brand->name }}</div>
                                            @if($brand->description)
                                                <div class="text-sm text-gray-500">{{ Str::limit($brand->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($brand->brands_images && count($brand->brands_images) > 0)
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-lg object-cover"
                                                 src="{{ $brand->brands_images[0]['url'] ?? '' }}"
                                                 alt="{{ $brand->brands_images[0]['alt'] ?? $brand->name }}">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <x-lucide-image class="w-6 h-6 text-gray-400" />
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $brand->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.brands.show', $brand) }}"
                                           class="text-gray-600 hover:text-primary-600 transition-colors duration-200"
                                           title="Görüntüle">
                                            <x-lucide-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.brands.edit', $brand) }}"
                                           class="text-gray-600 hover:text-primary-600 transition-colors duration-200"
                                           title="Düzenle">
                                            <x-lucide-square-pen class="w-4 h-4" />
                                        </a>
                                        <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" class="inline"
                                              onsubmit="return confirm('Bu markayı silmek istediğinizden emin misiniz?')">
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
            @if($brands->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $brands->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <x-lucide-building class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz marka bulunmuyor</h3>
                <p class="text-gray-500 mb-6">İlk marka logonuzu oluşturmak için aşağıdaki butona tıklayın.</p>
                <a href="{{ route('admin.brands.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-plus class="w-4 h-4 mr-2" />
                    Yeni Marka Oluştur
                </a>
            </div>
        @endif
    </div>
</x-admin-layout>
