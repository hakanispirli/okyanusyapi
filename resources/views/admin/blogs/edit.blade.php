<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Blog Yazısını Düzenle</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $blog->title }}</p>
            </div>
            <a href="{{ route('admin.blogs.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Geri Dön
            </a>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Temel Bilgiler</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Blog Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Blog Başlığı <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', $blog->title) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-300 @enderror"
                           placeholder="Örn: Konut İnşaatında Dikkat Edilmesi Gerekenler"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        URL Slug
                    </label>
                    <input type="text"
                           id="slug"
                           name="slug"
                           value="{{ old('slug', $blog->slug) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('slug') border-red-300 @enderror"
                           placeholder="otomatik-oluşturulur">
                    <p class="mt-1 text-xs text-gray-500">Boş bırakılırsa başlıktan otomatik oluşturulur</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id"
                            name="category_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('category_id') border-red-300 @enderror"
                            required>
                        <option value="">Kategori seçin</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div class="md:col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                        Özet
                    </label>
                    <textarea id="excerpt"
                              name="excerpt"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('excerpt') border-red-300 @enderror"
                              placeholder="Blog yazısının kısa özeti...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Maksimum 500 karakter</p>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">İçerik</h3>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Blog İçeriği <span class="text-red-500">*</span>
                </label>
                <x-quill-editor
                    name="content"
                    :value="old('content', $blog->content)"
                    placeholder="Blog yazınızın detaylı içeriğini yazın..."
                    height="500px"
                    toolbar="full"
                    :required="true"
                    class="mb-2" />
                <p class="mt-1 text-xs text-gray-500">
                    Zengin metin editörü ile içeriğinizi formatlayabilirsiniz. Başlık, kalın, italik, liste ve daha fazla seçenek mevcuttur.
                </p>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Featured Image -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Kapak Resmi</h3>

            <div x-data="heroImageUpload('{{ $blog->featured_image ? asset($blog->featured_image) : '' }}', '{{ $blog->featured_image ? basename($blog->featured_image) : '' }}')">
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Kapak Resmi
                </label>

                <!-- Current Image -->
                <div x-show="!isNewImage && originalImage" class="mb-4">
                    <div class="relative group">
                        <img :src="originalImage"
                             :alt="originalFileName"
                             class="w-full h-48 object-cover rounded-lg border-2 border-gray-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 rounded-b-lg">
                            <span x-text="originalFileName"></span>
                            <span class="ml-2 text-gray-300">(Mevcut resim)</span>
                        </div>
                    </div>
                </div>

                <!-- New Image Preview -->
                <div x-show="isNewImage && preview" class="mb-4">
                    <div class="relative group">
                        <img :src="preview"
                             :alt="fileName"
                             class="w-full h-48 object-cover rounded-lg border-2 border-gray-300">
                        <button type="button"
                                @click="removeNewImage()"
                                class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <x-lucide-x class="w-4 h-4" />
                        </button>
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 rounded-b-lg">
                            <span x-text="fileName"></span>
                        </div>
                    </div>
                </div>

                <!-- File Upload Area -->
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <x-lucide-image class="mx-auto h-12 w-12 text-gray-400" />
                        <div class="flex text-sm text-gray-600">
                            <label for="featured_image"
                                class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Yeni kapak resmi yükleyin</span>
                                <input id="featured_image" name="featured_image" type="file"
                                    accept="image/*" @change="handleFile($event)" class="sr-only">
                            </label>
                            <p class="pl-1">veya sürükleyip bırakın</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, WebP formatları desteklenir. Maksimum 2MB. Yeni resim seçmezseniz mevcut resim korunur.
                        </p>
                    </div>
                </div>

                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Gallery Images -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Galeri Resimleri</h3>

            <div x-data="galleryImagesUpload({{ json_encode($blog->formatted_gallery_images) }})">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Galeri Resimleri
                </label>

                <!-- Current Gallery Images -->
                <div x-show="existingImages.length > 0" class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Mevcut Galeri Resimleri:</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <template x-for="(image, index) in existingImages" :key="'existing-' + index">
                            <div class="relative group">
                                <img :src="image.url"
                                     :alt="image.alt"
                                     class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                                <button type="button"
                                        @click="removeExistingImage(index)"
                                        class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <x-lucide-x class="w-4 h-4" />
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 rounded-b-lg truncate">
                                    <span x-text="image.alt"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- File Upload Area -->
                <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <x-lucide-images class="mx-auto h-12 w-12 text-gray-400" />
                        <div class="flex text-sm text-gray-600">
                            <label for="gallery_images"
                                class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Yeni resimler yükleyin</span>
                                <input id="gallery_images" name="gallery_images[]" type="file"
                                    accept="image/*" multiple @change="handleFiles($event)" class="sr-only">
                            </label>
                            <p class="pl-1">veya sürükleyip bırakın</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, WebP formatları desteklenir. Yeni resimler mevcut resimlere eklenir.
                        </p>
                    </div>
                </div>

                <!-- New Gallery Preview -->
                <div x-show="previews.length > 0" class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Yeni Galeri Resimleri:</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <template x-for="(preview, index) in previews" :key="'new-' + index">
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
                </div>

                @error('gallery_images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('gallery_images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">SEO Ayarları</h3>

            <div class="space-y-6">
                <!-- Meta Title -->
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Başlık
                    </label>
                    <input type="text"
                           id="meta_title"
                           name="meta_title"
                           value="{{ old('meta_title', $blog->meta_title) }}"
                           maxlength="60"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('meta_title') border-red-300 @enderror"
                           placeholder="SEO için başlık (maksimum 60 karakter)">
                    <p class="mt-1 text-xs text-gray-500">Boş bırakılırsa blog başlığı kullanılır</p>
                    @error('meta_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meta Description -->
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Açıklama
                    </label>
                    <textarea id="meta_description"
                              name="meta_description"
                              rows="3"
                              maxlength="160"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('meta_description') border-red-300 @enderror"
                              placeholder="SEO için açıklama (maksimum 160 karakter)">{{ old('meta_description', $blog->meta_description) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Boş bırakılırsa blog özeti kullanılır</p>
                    @error('meta_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meta Keywords -->
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Anahtar Kelimeler
                    </label>
                    <input type="text"
                           id="meta_keywords"
                           name="meta_keywords"
                           value="{{ old('meta_keywords', $blog->meta_keywords) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('meta_keywords') border-red-300 @enderror"
                           placeholder="anahtar, kelime, virgülle, ayrılmış">
                    @error('meta_keywords')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tags -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Etiketler</h3>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                    Etiketler
                </label>
                <input type="text"
                       id="tags"
                       name="tags"
                       value="{{ old('tags', is_array(old('tags')) ? implode(', ', old('tags')) : (is_array($blog->tags) ? implode(', ', $blog->tags) : '')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('tags') border-red-300 @enderror"
                       placeholder="etiket1, etiket2, etiket3">
                <p class="mt-1 text-xs text-gray-500">Etiketleri virgülle ayırın</p>
                @error('tags')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Publishing Settings -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Yayın Ayarları</h3>

            <div class="space-y-4">
                <!-- Status -->
                <div class="flex items-center">
                    <input type="checkbox"
                           id="status"
                           name="status"
                           value="1"
                           {{ old('status', $blog->status) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="status" class="ml-2 block text-sm text-gray-900">
                        Blog yazısını yayınla
                    </label>
                </div>

                <!-- Featured -->
                <div class="flex items-center">
                    <input type="checkbox"
                           id="featured"
                           name="featured"
                           value="1"
                           {{ old('featured', $blog->featured) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="featured" class="ml-2 block text-sm text-gray-900">
                        Öne çıkan blog yazısı yap
                    </label>
                </div>

                <!-- Published At -->
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                        Yayın Tarihi
                    </label>
                    <input type="datetime-local"
                           id="published_at"
                           name="published_at"
                           value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('published_at') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Boş bırakılırsa şu anki tarih kullanılır</p>
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.blogs.index') }}"
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

    <script>
        function heroImageUpload(existingImage = '', existingFileName = '') {
            return {
                preview: existingImage,
                fileName: existingFileName,
                isNewImage: false,
                originalImage: existingImage,
                originalFileName: existingFileName,
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
                    this.preview = this.originalImage;
                    this.fileName = this.originalFileName;
                    this.isNewImage = false;
                    document.getElementById('featured_image').value = '';
                }
            };
        }

        function galleryImagesUpload(existingImages = []) {
            return {
                existingImages: existingImages,
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
                    const fileInput = document.getElementById('gallery_images');
                    const dt = new DataTransfer();

                    // Get current files and rebuild without the removed one
                    const currentFiles = Array.from(fileInput.files);
                    currentFiles.forEach((file, i) => {
                        if (i !== index) {
                            dt.items.add(file);
                        }
                    });

                    fileInput.files = dt.files;
                },
                removeExistingImage(index) {
                    this.existingImages.splice(index, 1);
                }
            };
        }

        // Handle tags input
        document.addEventListener('DOMContentLoaded', function() {
            const tagsInput = document.getElementById('tags');

            // Initialize with existing value
            if (tagsInput.value) {
                const tags = tagsInput.value.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
                tagsInput.value = tags.join(', ');
            }
        });
    </script>
</x-admin-layout>
