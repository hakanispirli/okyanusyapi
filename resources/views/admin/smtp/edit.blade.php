<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">SMTP Ayarını Düzenle</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $smtp->host }} - SMTP ayarını düzenleyin</p>
            </div>
            <a href="{{ route('admin.smtp.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Geri Dön
            </a>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.smtp.update', $smtp) }}" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SMTP Configuration -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">SMTP Yapılandırması</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Mailer -->
                <div>
                    <label for="mailer" class="block text-sm font-medium text-gray-700 mb-2">
                        Mailer <span class="text-red-500">*</span>
                    </label>
                    <select id="mailer" name="mailer"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('mailer') border-red-300 @enderror"
                        required>
                        <option value="smtp" {{ old('mailer', $smtp->mailer) == 'smtp' ? 'selected' : '' }}>SMTP</option>
                    </select>
                    @error('mailer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Host -->
                <div>
                    <label for="host" class="block text-sm font-medium text-gray-700 mb-2">
                        SMTP Sunucusu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="host" name="host" value="{{ old('host', $smtp->host) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('host') border-red-300 @enderror"
                        placeholder="smtp.gmail.com" required>
                    @error('host')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Port -->
                <div>
                    <label for="port" class="block text-sm font-medium text-gray-700 mb-2">
                        Port <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="port" name="port" value="{{ old('port', $smtp->port) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('port') border-red-300 @enderror"
                        placeholder="587" min="1" max="65535" required>
                    @error('port')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Encryption -->
                <div>
                    <label for="encryption" class="block text-sm font-medium text-gray-700 mb-2">
                        Şifreleme
                    </label>
                    <select id="encryption" name="encryption"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('encryption') border-red-300 @enderror">
                        <option value="tls" {{ old('encryption', $smtp->encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ old('encryption', $smtp->encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="null" {{ old('encryption', $smtp->encryption) == 'null' ? 'selected' : '' }}>Yok</option>
                    </select>
                    @error('encryption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Kullanıcı Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="username" name="username" value="{{ old('username', $smtp->username) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('username') border-red-300 @enderror"
                        placeholder="your-email@gmail.com" required>
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Şifre
                        @if(!$smtp->password)
                            <span class="text-red-500">*</span>
                        @else
                            <span class="text-gray-500">(Değiştirmek için yeni şifre girin)</span>
                        @endif
                    </label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-300 @enderror"
                        placeholder="{{ $smtp->password ? '•••••••• (Mevcut şifre)' : '••••••••' }}"
                        {{ !$smtp->password ? 'required' : '' }}>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- From Configuration -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Gönderen Bilgileri</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- From Address -->
                <div>
                    <label for="from_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Gönderen E-posta <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="from_address" name="from_address" value="{{ old('from_address', $smtp->from_address) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('from_address') border-red-300 @enderror"
                        placeholder="noreply@example.com" required>
                    @error('from_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- From Name -->
                <div>
                    <label for="from_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Gönderen Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="from_name" name="from_name" value="{{ old('from_name', $smtp->from_name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('from_name') border-red-300 @enderror"
                        placeholder="Okyanus Yapı" required>
                    @error('from_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Ayarlar</h3>

            <div class="space-y-6">
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Açıklama
                    </label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-300 @enderror"
                        placeholder="Bu SMTP ayarı için açıklama yazın...">{{ old('description', $smtp->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        {{ old('is_active', $smtp->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Bu SMTP ayarını aktif yap
                    </label>
                </div>
                <p class="text-xs text-gray-500">Aktif SMTP ayarı e-posta gönderimi için kullanılır. Sadece bir ayar aktif olabilir.</p>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.smtp.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                İptal
            </a>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-save class="w-4 h-4 mr-2" />
                Değişiklikleri Kaydet
            </button>
        </div>
    </form>
</x-admin-layout>
