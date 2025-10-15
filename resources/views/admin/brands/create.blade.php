<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Yeni Marka Oluştur</h1>
                <p class="mt-1 text-sm text-gray-600">Yeni bir marka logosu oluşturun</p>
            </div>
            <a href="{{ route('admin.brands.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Geri Dön
            </a>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Temel Bilgiler</h3>

            <div class="space-y-6">
                <!-- Brand Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Marka Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-300 @enderror"
                        placeholder="Örn: Microsoft" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Açıklama
                    </label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-300 @enderror"
                        placeholder="Marka hakkında kısa bir açıklama yazın...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Brand Images Section -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Marka Resimleri</h3>

            <!-- Brand Images Upload -->
            <div x-data="brandImagesUpload()">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Marka Resimleri <span class="text-red-500">*</span>
                </label>

                <!-- File Upload Area -->
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <x-lucide-images class="mx-auto h-12 w-12 text-gray-400" />
                        <div class="flex text-sm text-gray-600">
                            <label for="brands_images" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Resimleri yükleyin</span>
                                <input id="brands_images"
                                       name="brands_images[]"
                                       type="file"
                                       accept="image/*"
                                       multiple
                                       @change="handleFiles($event)"
                                       class="sr-only"
                                       required>
                            </label>
                            <p class="pl-1">veya sürükleyip bırakın</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, WebP formatları desteklenir. Birden fazla resim seçebilirsiniz.
                        </p>
                    </div>
                </div>

                <!-- Preview Area -->
                <div x-show="previews.length > 0" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template x-for="(preview, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="preview.url"
                                 :alt="preview.name"
                                 class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                            <button type="button"
                                    @click="removeImage(index)"
                                    class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <x-lucide-x class="w-4 h-4" />
                            </button>
                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 rounded-b-lg truncate">
                                <span x-text="preview.name"></span>
                            </div>
                        </div>
                    </template>
                </div>

                @error('brands_images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('brands_images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Durum</h3>

            <div class="flex items-center">
                <input type="checkbox" id="status" name="status" value="1"
                    {{ old('status', true) ? 'checked' : '' }}
                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="status" class="ml-2 block text-sm text-gray-900">
                    Marka aktif olsun
                </label>
            </div>
            <p class="mt-1 text-xs text-gray-500">Pasif markalar frontend'de görünmez</p>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.brands.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                İptal
            </a>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-save class="w-4 h-4 mr-2" />
                Marka Oluştur
            </button>
        </div>
    </form>

    <script>
        function brandImagesUpload() {
            return {
                previews: [],
                files: [],
                handleFiles(event) {
                    const fileInput = event.target;
                    const newFiles = Array.from(fileInput.files);

                    newFiles.forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.previews.push({
                                    url: e.target.result,
                                    name: file.name
                                });
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                },
                removeImage(index) {
                    this.previews.splice(index, 1);
                    // Reset file input to reflect changes
                    const fileInput = document.getElementById('brands_images');
                    const dt = new DataTransfer();

                    // Get current files and rebuild without the removed one
                    const currentFiles = Array.from(fileInput.files);
                    currentFiles.forEach((file, i) => {
                        if (i !== index) {
                            dt.items.add(file);
                        }
                    });

                    fileInput.files = dt.files;
                }
            };
        }
    </script>
</x-admin-layout>
