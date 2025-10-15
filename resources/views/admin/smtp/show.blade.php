<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">SMTP Ayarı Detayları</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $smtp->host }} - SMTP ayarı bilgileri</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.smtp.edit', $smtp) }}"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-square-pen class="w-4 h-4 mr-2" />
                    Düzenle
                </a>
                <a href="{{ route('admin.smtp.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Status -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Durum</h3>

            <div class="flex items-center">
                @if ($smtp->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <x-lucide-check class="w-4 h-4 mr-2" />
                        Aktif
                    </span>
                    <p class="ml-3 text-sm text-gray-600">Bu SMTP ayarı şu anda e-posta gönderimi için kullanılıyor.</p>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        <x-lucide-pause class="w-4 h-4 mr-2" />
                        Pasif
                    </span>
                    <p class="ml-3 text-sm text-gray-600">Bu SMTP ayarı şu anda kullanılmıyor.</p>
                @endif
            </div>
        </div>

        <!-- SMTP Configuration -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">SMTP Yapılandırması</h3>

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Mailer</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->mailer }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">SMTP Sunucusu</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->host }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Port</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->port }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Şifreleme</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->encryption ?: 'Yok' }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Kullanıcı Adı</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->username }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Şifre</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if($smtp->password)
                            <span class="text-gray-500">••••••••</span>
                        @else
                            <span class="text-red-500">Ayarlanmamış</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- From Configuration -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Gönderen Bilgileri</h3>

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Gönderen E-posta</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->from_address }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Gönderen Adı</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->from_name }}</dd>
                </div>
            </dl>
        </div>

        <!-- Description -->
        @if($smtp->description)
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Açıklama</h3>
                <p class="text-sm text-gray-900">{{ $smtp->description }}</p>
            </div>
        @endif

        <!-- Actions -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">İşlemler</h3>

            <div class="flex items-center space-x-4">
                @if (!$smtp->is_active)
                    <form method="POST" action="{{ route('admin.smtp.activate', $smtp) }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <x-lucide-play class="w-4 h-4 mr-2" />
                            Aktif Yap
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.smtp.test', $smtp) }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <x-lucide-send class="w-4 h-4 mr-2" />
                        Test Et
                    </button>
                </form>

                @if (!$smtp->is_active)
                    <form method="POST" action="{{ route('admin.smtp.destroy', $smtp) }}" class="inline"
                        onsubmit="return confirm('Bu SMTP ayarını silmek istediğinizden emin misiniz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                            Sil
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Timestamps -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Zaman Bilgileri</h3>

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Oluşturulma Tarihi</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->created_at->format('d.m.Y H:i') }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Son Güncelleme</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $smtp->updated_at->format('d.m.Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</x-admin-layout>
