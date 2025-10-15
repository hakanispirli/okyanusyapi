<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Hizmet Düzenle</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $service->name }} hizmetini düzenleyin</p>
            </div>
            <a href="{{ route('admin.services.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Geri Dön
            </a>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Temel Bilgiler</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Hizmet Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $service->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-300 @enderror"
                           placeholder="Örn: Konut İnşaatı"
                           required>
                    @error('name')
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
                           value="{{ old('slug', $service->slug) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('slug') border-red-300 @enderror"
                           placeholder="konut-insaati">
                    <p class="mt-1 text-xs text-gray-500">Boş bırakılırsa hizmet adından otomatik oluşturulur</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Kısa Açıklama
                </label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-300 @enderror"
                          placeholder="Hizmet hakkında kısa bir açıklama yazın...">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Hero Section -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Hero Bölümü</h3>

            <div class="space-y-6">
                <!-- Hero Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Hero Başlığı <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', $service->title) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-300 @enderror"
                           placeholder="Modern ve Güvenli Konut Projeleri"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hero Image -->
                <div x-data="heroImageUpload('{{ $service->hero_image ? asset($service->hero_image) : '' }}', '{{ $service->hero_image ? basename($service->hero_image) : '' }}')">
                    <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Hero Resmi
                        @if(!$service->hero_image)
                            <span class="text-red-500">*</span>
                        @endif
                    </label>

                    <!-- Current/Preview Image -->
                    <div x-show="preview" class="mb-4">
                        <div class="relative inline-block w-full">
                            <img :src="preview"
                                 alt="Hero resim"
                                 class="h-48 w-full object-cover rounded-lg border-2"
                                 :class="isNewImage ? 'border-primary-300' : 'border-gray-300'">
                            <button type="button"
                                    x-show="isNewImage"
                                    @click="removeNewImage()"
                                    class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition-colors duration-200">
                                <x-lucide-x class="w-4 h-4" />
                            </button>
                            <div class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                <span x-text="fileName"></span>
                                <span x-show="!isNewImage" class="ml-2 text-green-300">(Mevcut)</span>
                                <span x-show="isNewImage" class="ml-2 text-yellow-300">(Yeni)</span>
                            </div>
                        </div>
                        <p x-show="!isNewImage && {{ $service->hero_image ? 'true' : 'false' }}" class="mt-2 text-sm text-gray-600">
                            <strong>Not:</strong> Yeni resim yüklemek için aşağıdaki alandan dosya seçin.
                        </p>
                    </div>

                    <!-- Upload Area -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors duration-200">
                        <div class="space-y-1 text-center w-full">
                            <x-lucide-cloud-upload class="mx-auto h-12 w-12 text-gray-400" />
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="hero_image"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>{{ $service->hero_image ? 'Yeni resim yükleyin' : 'Resim yükleyin' }}</span>
                                    <input id="hero_image"
                                           name="hero_image"
                                           type="file"
                                           accept="image/*"
                                           @change="handleFile($event)"
                                           class="sr-only"
                                           {{ !$service->hero_image ? 'required' : '' }}>
                                </label>
                                <p class="pl-1">veya sürükleyip bırakın</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                {{ $service->hero_image ? 'Yeni resim yüklemek için dosya seçin. Boş bırakılırsa mevcut resim korunur.' : 'PNG, JPG, WebP formatları desteklenir. Maksimum 2MB.' }}
                            </p>
                        </div>
                    </div>

                    @error('hero_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Process Section -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Süreç Bölümü</h3>

            <div class="space-y-6">
                <!-- Process Title -->
                <div>
                    <label for="process_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Süreç Başlığı
                    </label>
                    <input type="text"
                           id="process_title"
                           name="process_title"
                           value="{{ old('process_title', $service->process_title) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('process_title') border-red-300 @enderror"
                           placeholder="Çalışma Sürecimiz">
                    @error('process_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Process Description -->
                <div>
                    <label for="process_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Süreç Açıklaması
                    </label>
                    <textarea id="process_description"
                              name="process_description"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('process_description') border-red-300 @enderror"
                              placeholder="Konut inşaatı projelerinizi 4 adımda gerçekleştiriyoruz">{{ old('process_description', $service->process_description) }}</textarea>
                    @error('process_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Process Steps -->
                <div x-data="processSteps({{ json_encode($service->process_steps ?? []) }})">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Süreç Adımları
                    </label>
                    <div class="space-y-4">
                        <template x-for="(step, index) in steps" :key="index">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-gray-900">Adım <span x-text="index + 1"></span></h4>
                                    <button type="button"
                                            @click="removeStep(index)"
                                            class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                        <x-lucide-trash-2 class="w-4 h-4" />
                                    </button>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <input type="text"
                                               :name="`process_steps[${index}][title]`"
                                               x-model="step.title"
                                               placeholder="Adım başlığı"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <textarea :name="`process_steps[${index}][description]`"
                                                  x-model="step.description"
                                                  rows="2"
                                                  placeholder="Adım açıklaması"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <button type="button"
                                @click="addStep()"
                                class="w-full border-2 border-dashed border-gray-300 rounded-lg p-4 text-gray-600 hover:border-primary-500 hover:text-primary-600 transition-colors duration-200">
                            <x-lucide-plus class="w-5 h-5 mx-auto mb-2" />
                            Yeni Adım Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Galeri Bölümü</h3>

            <div class="space-y-6">
                <!-- Gallery Title -->
                <div>
                    <label for="gallery_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Galeri Başlığı
                    </label>
                    <input type="text"
                           id="gallery_title"
                           name="gallery_title"
                           value="{{ old('gallery_title', $service->gallery_title) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('gallery_title') border-red-300 @enderror"
                           placeholder="Proje Galerisi">
                    @error('gallery_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gallery Description -->
                <div>
                    <label for="gallery_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Galeri Açıklaması
                    </label>
                    <textarea id="gallery_description"
                              name="gallery_description"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('gallery_description') border-red-300 @enderror"
                              placeholder="Tamamladığımız konut projelerinden örnekler">{{ old('gallery_description', $service->gallery_description) }}</textarea>
                    @error('gallery_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gallery Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mevcut Galeri Resimleri
                    </label>

                    @if($service->gallery_images && count($service->gallery_images) > 0)
                        <div class="mb-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($service->gallery_images as $index => $image)
                                <div class="relative group">
                                    <img src="{{ $image['url'] ?? '' }}"
                                         alt="{{ $image['alt'] ?? 'Galeri resmi' }}"
                                         class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 rounded-b-lg truncate">
                                        {{ $image['alt'] ?? 'Galeri resmi' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-600 mb-4">
                            <strong>Not:</strong> Yeni resimler yüklerseniz, mevcut resimler korunur ve yenileri eklenir.
                        </p>
                    @else
                        <p class="text-sm text-gray-500 italic mb-4">Henüz galeri resmi yüklenmemiş.</p>
                    @endif

                    <div x-data="galleryImagesUpload()">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Yeni Galeri Resimleri Ekle
                        </label>

                        <!-- File Upload Area -->
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <x-lucide-images class="mx-auto h-12 w-12 text-gray-400" />
                                <div class="flex text-sm text-gray-600">
                                    <label for="gallery_images" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>Resimleri yükleyin</span>
                                        <input id="gallery_images"
                                               name="gallery_images[]"
                                               type="file"
                                               accept="image/*"
                                               multiple
                                               @change="handleFiles($event)"
                                               class="sr-only">
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
                                         class="w-full h-32 object-cover rounded-lg border-2 border-primary-300">
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

                        @error('gallery_images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('gallery_images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Content -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">SEO İçeriği</h3>

            <!-- Content -->
            <div>
                <label for="seo_content" class="block text-sm font-medium text-gray-700 mb-2">
                    SEO İçeriği
                </label>
                <x-quill-editor
                    name="seo_content"
                    :value="old('seo_content', $service->seo_content)"
                    placeholder="SEO için detaylı içerik yazın..."
                    height="400px"
                    toolbar="full"
                    :required="false"
                    class="mb-2" />
                <p class="mt-1 text-xs text-gray-500">
                    Zengin metin editörü ile içeriğinizi formatlayabilirsiniz. Başlık, kalın, italik, liste ve daha fazla seçenek mevcuttur.
                </p>
                @error('seo_content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Durum</h3>

            <div class="flex items-center">
                <input type="checkbox"
                       id="status"
                       name="status"
                       value="1"
                       {{ old('status', $service->status) ? 'checked' : '' }}
                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="status" class="ml-2 block text-sm text-gray-900">
                    Hizmet aktif olsun
                </label>
            </div>
            <p class="mt-1 text-xs text-gray-500">Pasif hizmetler frontend'de görünmez</p>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.services.index') }}"
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
                    document.getElementById('hero_image').value = '';
                }
            };
        }

        function processSteps(initialSteps = []) {
            return {
                steps: initialSteps.length > 0 ? initialSteps : [],
                addStep() {
                    this.steps.push({
                        title: '',
                        description: ''
                    });
                },
                removeStep(index) {
                    this.steps.splice(index, 1);
                }
            };
        }

        function galleryImagesUpload() {
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
                }
            };
        }
    </script>
</x-admin-layout>
