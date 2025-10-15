<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Site Bilgilerini Düzenle</h2>
                <p class="text-sm text-gray-600 mt-1">Site bilgilerini güncelleyin</p>
            </div>
            <a href="{{ route('admin.site-information.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Geri
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route('admin.site-information.update', $siteInformation) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <x-lucide-info class="w-5 h-5 mr-2 text-orange-500" />
                    Temel Bilgiler
                </h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Site Adı <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $siteInformation->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Telefon <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $siteInformation->phone) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            E-posta <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $siteInformation->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('email') border-red-500 @enderror">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Adres <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="address" id="address" value="{{ old('address', $siteInformation->address) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('address') border-red-500 @enderror">
                        @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notification Email -->
                    <div>
                        <label for="notification_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Bildirim E-postası <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="notification_email" id="notification_email" value="{{ old('notification_email', $siteInformation->notification_email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('notification_email') border-red-500 @enderror">
                        @error('notification_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Header Logo -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <x-lucide-image class="w-5 h-5 mr-2 text-orange-500" />
                    Header Logo
                </h3>

                <div x-data="logoUpload('header_logo', '{{ $siteInformation->header_logo ? asset($siteInformation->header_logo) : '' }}', '{{ $siteInformation->header_logo ? basename($siteInformation->header_logo) : '' }}')">
                    <label for="header_logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Header Logo
                    </label>

                    <!-- Current/Preview Image -->
                    <div x-show="preview" class="mb-4">
                        <div class="relative inline-block w-full">
                            <img :src="preview" alt="Header Logo" class="h-32 w-auto object-contain border-2 rounded-lg bg-white p-4" :class="isNewImage ? 'border-orange-300' : 'border-gray-300'">
                            <button type="button" x-show="isNewImage" @click="removeNewImage()" class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition-colors duration-200">
                                <x-lucide-x class="w-4 h-4" />
                            </button>
                            <div class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                <span x-text="fileName"></span>
                                <span x-show="!isNewImage && {{ $siteInformation->header_logo ? 'true' : 'false' }}" class="ml-2 text-green-300">(Mevcut)</span>
                                <span x-show="isNewImage" class="ml-2 text-yellow-300">(Yeni)</span>
                            </div>
                        </div>
                        <p x-show="!isNewImage && {{ $siteInformation->header_logo ? 'true' : 'false' }}" class="mt-2 text-sm text-gray-600">
                            <strong>Not:</strong> Yeni header logo yüklemek için aşağıdaki alandan dosya seçin.
                        </p>
                    </div>

                    <!-- Upload Area -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-orange-400 transition-colors duration-200">
                        <div class="space-y-1 text-center w-full">
                            <x-lucide-cloud-upload class="mx-auto h-12 w-12 text-gray-400" />
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="header_logo" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                    <span>{{ $siteInformation->header_logo ? 'Yeni header logo yükleyin' : 'Header logo yükleyin' }}</span>
                                    <input id="header_logo" name="header_logo" type="file" accept="image/*" @change="handleFile($event)" class="sr-only">
                                </label>
                                <p class="pl-1">veya sürükleyip bırakın</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                {{ $siteInformation->header_logo ? 'Yeni header logo yüklemek için dosya seçin. Boş bırakılırsa mevcut logo korunur.' : 'PNG, JPG, WebP, SVG formatları desteklenir. Maksimum 2MB.' }}
                            </p>
                        </div>
                    </div>

                    @error('header_logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer Logo -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <x-lucide-image class="w-5 h-5 mr-2 text-orange-500" />
                    Footer Logo
                </h3>

                <div x-data="logoUpload('footer_logo', '{{ $siteInformation->footer_logo ? asset($siteInformation->footer_logo) : '' }}', '{{ $siteInformation->footer_logo ? basename($siteInformation->footer_logo) : '' }}')">
                    <label for="footer_logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Footer Logo
                    </label>

                    <!-- Current/Preview Image -->
                    <div x-show="preview" class="mb-4">
                        <div class="relative inline-block w-full">
                            <img :src="preview" alt="Footer Logo" class="h-32 w-auto object-contain border-2 rounded-lg bg-white p-4" :class="isNewImage ? 'border-orange-300' : 'border-gray-300'">
                            <button type="button" x-show="isNewImage" @click="removeNewImage()" class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition-colors duration-200">
                                <x-lucide-x class="w-4 h-4" />
                            </button>
                            <div class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                <span x-text="fileName"></span>
                                <span x-show="!isNewImage && {{ $siteInformation->footer_logo ? 'true' : 'false' }}" class="ml-2 text-green-300">(Mevcut)</span>
                                <span x-show="isNewImage" class="ml-2 text-yellow-300">(Yeni)</span>
                            </div>
                        </div>
                        <p x-show="!isNewImage && {{ $siteInformation->footer_logo ? 'true' : 'false' }}" class="mt-2 text-sm text-gray-600">
                            <strong>Not:</strong> Yeni footer logo yüklemek için aşağıdaki alandan dosya seçin.
                        </p>
                    </div>

                    <!-- Upload Area -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-orange-400 transition-colors duration-200">
                        <div class="space-y-1 text-center w-full">
                            <x-lucide-cloud-upload class="mx-auto h-12 w-12 text-gray-400" />
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="footer_logo" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                    <span>{{ $siteInformation->footer_logo ? 'Yeni footer logo yükleyin' : 'Footer logo yükleyin' }}</span>
                                    <input id="footer_logo" name="footer_logo" type="file" accept="image/*" @change="handleFile($event)" class="sr-only">
                                </label>
                                <p class="pl-1">veya sürükleyip bırakın</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                {{ $siteInformation->footer_logo ? 'Yeni footer logo yüklemek için dosya seçin. Boş bırakılırsa mevcut logo korunur.' : 'PNG, JPG, WebP, SVG formatları desteklenir. Maksimum 2MB.' }}
                            </p>
                        </div>
                    </div>

                    @error('footer_logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Favicon -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <x-lucide-image class="w-5 h-5 mr-2 text-orange-500" />
                    Favicon
                </h3>

                <div x-data="logoUpload('favicon', '{{ $siteInformation->favicon ? asset($siteInformation->favicon) : '' }}', '{{ $siteInformation->favicon ? basename($siteInformation->favicon) : '' }}')">
                    <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">
                        Favicon
                    </label>

                    <!-- Current/Preview Image -->
                    <div x-show="preview" class="mb-4">
                        <div class="relative inline-block w-full">
                            <img :src="preview" alt="Favicon" class="h-32 w-auto object-contain border-2 rounded-lg bg-white p-4" :class="isNewImage ? 'border-orange-300' : 'border-gray-300'">
                            <button type="button" x-show="isNewImage" @click="removeNewImage()" class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition-colors duration-200">
                                <x-lucide-x class="w-4 h-4" />
                            </button>
                            <div class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                <span x-text="fileName"></span>
                                <span x-show="!isNewImage && {{ $siteInformation->favicon ? 'true' : 'false' }}" class="ml-2 text-green-300">(Mevcut)</span>
                                <span x-show="isNewImage" class="ml-2 text-yellow-300">(Yeni)</span>
                            </div>
                        </div>
                        <p x-show="!isNewImage && {{ $siteInformation->favicon ? 'true' : 'false' }}" class="mt-2 text-sm text-gray-600">
                            <strong>Not:</strong> Yeni favicon yüklemek için aşağıdaki alandan dosya seçin.
                        </p>
                    </div>

                    <!-- Upload Area -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-orange-400 transition-colors duration-200">
                        <div class="space-y-1 text-center w-full">
                            <x-lucide-cloud-upload class="mx-auto h-12 w-12 text-gray-400" />
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="favicon" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                    <span>{{ $siteInformation->favicon ? 'Yeni favicon yükleyin' : 'Favicon yükleyin' }}</span>
                                    <input id="favicon" name="favicon" type="file" accept="image/*,.ico" @change="handleFile($event)" class="sr-only">
                                </label>
                                <p class="pl-1">veya sürükleyip bırakın</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                {{ $siteInformation->favicon ? 'Yeni favicon yüklemek için dosya seçin. Boş bırakılırsa mevcut favicon korunur.' : 'PNG, JPG, WebP, SVG, ICO formatları desteklenir. Maksimum 1MB.' }}
                            </p>
                        </div>
                    </div>

                    @error('favicon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Social Media -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <x-lucide-share-2 class="w-5 h-5 mr-2 text-orange-500" />
                    Sosyal Medya Bağlantıları
                </h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Facebook -->
                    <div>
                        <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <x-lucide-facebook class="w-4 h-4 mr-1 text-blue-600" />
                            Facebook
                        </label>
                        <input type="url" name="facebook" id="facebook" value="{{ old('facebook', $siteInformation->facebook) }}" placeholder="https://facebook.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('facebook') border-red-500 @enderror">
                        @error('facebook')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <x-lucide-instagram class="w-4 h-4 mr-1 text-pink-600" />
                            Instagram
                        </label>
                        <input type="url" name="instagram" id="instagram" value="{{ old('instagram', $siteInformation->instagram) }}" placeholder="https://instagram.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('instagram') border-red-500 @enderror">
                        @error('instagram')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Twitter -->
                    <div>
                        <label for="twitter" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <x-lucide-twitter class="w-4 h-4 mr-1 text-sky-500" />
                            Twitter
                        </label>
                        <input type="url" name="twitter" id="twitter" value="{{ old('twitter', $siteInformation->twitter) }}" placeholder="https://twitter.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('twitter') border-red-500 @enderror">
                        @error('twitter')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <x-lucide-message-circle class="w-4 h-4 mr-1 text-green-600" />
                            WhatsApp
                        </label>
                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $siteInformation->whatsapp) }}" placeholder="+90 555 123 4567" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('whatsapp') border-red-500 @enderror">
                        @error('whatsapp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.site-information.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    İptal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200">
                    <x-lucide-save class="w-4 h-4 mr-2" />
                    Güncelle
                </button>
            </div>
        </form>
    </div>

    <script>
        function logoUpload(inputId, currentImageUrl = '', currentFileName = '') {
            return {
                preview: currentImageUrl || null,
                fileName: currentFileName || '',
                isNewImage: false,

                init() {
                    // Set initial preview if current image exists
                    if (currentImageUrl) {
                        this.preview = currentImageUrl;
                        this.fileName = currentFileName;
                        this.isNewImage = false;
                    }
                },

                handleFile(event) {
                    const file = event.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.preview = e.target.result;
                            this.fileName = file.name;
                            this.isNewImage = true;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                removeNewImage() {
                    this.preview = currentImageUrl || null;
                    this.fileName = currentFileName || '';
                    this.isNewImage = false;
                    document.getElementById(inputId).value = '';
                }
            };
        }
    </script>
</x-admin-layout>
