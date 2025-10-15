<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">SMTP Ayarları</h1>
                <p class="mt-1 text-sm text-gray-600">E-posta gönderimi için SMTP ayarlarını yönetin</p>
            </div>
            <a href="{{ route('admin.smtp.create') }}"
                class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-plus class="w-4 h-4 mr-2" />
                Yeni SMTP Ayarı
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                <div class="flex">
                    <x-lucide-circle-check class="w-5 h-5 mr-2 mt-0.5" />
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                <div class="flex">
                    <x-lucide-circle-x class="w-5 h-5 mr-2 mt-0.5" />
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if ($smtpSettings->count() > 0)
            <!-- SMTP Settings Table -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Durum
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SMTP Bilgileri
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Gönderen
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Açıklama
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    İşlemler
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($smtpSettings as $smtp)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($smtp->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <x-lucide-check class="w-3 h-3 mr-1" />
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <x-lucide-pause class="w-3 h-3 mr-1" />
                                                Pasif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $smtp->host }}</div>
                                        <div class="text-sm text-gray-500">Port: {{ $smtp->port }} | {{ $smtp->username }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $smtp->from_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $smtp->from_address }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $smtp->description ? Str::limit($smtp->description, 50) : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            @if (!$smtp->is_active)
                                                <form method="POST" action="{{ route('admin.smtp.activate', $smtp) }}" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                                        title="Aktif Yap">
                                                        <x-lucide-play class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            @endif

                                            <form method="POST" action="{{ route('admin.smtp.test', $smtp) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                                    title="Test Et">
                                                    <x-lucide-send class="w-4 h-4" />
                                                </button>
                                            </form>

                                            <a href="{{ route('admin.smtp.show', $smtp) }}"
                                                class="text-gray-600 hover:text-gray-900 transition-colors duration-200"
                                                title="Görüntüle">
                                                <x-lucide-eye class="w-4 h-4" />
                                            </a>

                                            <a href="{{ route('admin.smtp.edit', $smtp) }}"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200"
                                                title="Düzenle">
                                                <x-lucide-square-pen class="w-4 h-4" />
                                            </a>

                                            @if (!$smtp->is_active)
                                                <form method="POST" action="{{ route('admin.smtp.destroy', $smtp) }}" class="inline"
                                                    onsubmit="return confirm('Bu SMTP ayarını silmek istediğinizden emin misiniz?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                        title="Sil">
                                                        <x-lucide-trash-2 class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($smtpSettings->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $smtpSettings->links() }}
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <x-lucide-mail class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz SMTP ayarı bulunmuyor</h3>
                <p class="text-gray-500 mb-6">E-posta gönderimi için SMTP ayarı ekleyin.</p>
                <a href="{{ route('admin.smtp.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-plus class="w-4 h-4 mr-2" />
                    İlk SMTP Ayarını Ekle
                </a>
            </div>
        @endif
    </div>
</x-admin-layout>
