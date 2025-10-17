<x-app-layout :seoData="$seoData">
    {{-- Breadcrumb --}}
    <nav class="bg-gray-50 border-b border-gray-200" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600 transition-colors duration-200">
                        <x-lucide-house class="w-4 h-4" />
                    </a>
                </li>
                <li class="flex items-center">
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-400 mx-2" />
                    <a href="{{ route('blogs') }}" class="text-gray-500 hover:text-primary-600 transition-colors duration-200">Uygulamalar</a>
                </li>
                <li class="flex items-center">
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-400 mx-2" />
                    <span class="bg-primary-100 text-primary-800 px-2 py-1 rounded-full text-xs font-medium">
                        {{ $blog->category->name }}
                    </span>
                </li>
                <li class="flex items-center">
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-400 mx-2" />
                    <span class="text-gray-900 font-medium truncate max-w-xs">{{ $blog->title }}</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section with Gradient --}}
    <section class="bg-gradient-to-br from-corporate-950 via-corporate-900 to-primary-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-2 text-sm text-gray-300 mb-4">
                    <span class="bg-primary-500/20 text-primary-200 px-3 py-1 rounded-full text-xs font-medium">
                        {{ $blog->category->name }}
                    </span>
                    <span>{{ $blog->published_at->format('d.m.Y') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white mb-3">
                    {{ $blog->title }} Uygulaması
                </h1>
                @if($blog->excerpt)
                    <p class="text-gray-200 max-w-3xl mx-auto text-base leading-relaxed">
                        {{ $blog->excerpt }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="py-8 md:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <article class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <!-- Featured Image -->
                        @if($blog->featured_image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ $blog->featured_image_url }}"
                                     alt="{{ $blog->featured_image_alt ?? $blog->title }}"
                                     class="w-full h-64 md:h-96 object-cover">
                            </div>
                        @endif

                        <!-- Article Meta -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-2">
                                        <x-lucide-user class="w-4 h-4" />
                                        <span>{{ $blog->author->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <x-lucide-calendar class="w-4 h-4" />
                                        <span>{{ $blog->published_at->format('d.m.Y') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <x-lucide-clock class="w-4 h-4" />
                                        <span>{{ $blog->reading_time }} dakika okuma</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <x-lucide-eye class="w-4 h-4" />
                                        <span>{{ $blog->views }} görüntüleme</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <x-lucide-heart class="w-4 h-4" />
                                        <span>{{ $blog->likes }} beğeni</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Article Content -->
                        <div class="p-6">
                            @include('frontend.blogs.partials.content')
                        </div>

                        <!-- Photo Gallery -->
                        @if($blog->gallery_images && count($blog->gallery_images) > 0)
                            <div class="px-6 pb-6">
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="text-xl font-semibold text-corporate-900 mb-4">Uygulama Galerisi</h3>
                                    <div x-data="photoGallery" @keydown.window="handleKeydown($event)">
                                        {{-- Mobile Gallery --}}
                                        <div class="block sm:hidden">
                                            <div class="relative -mx-2 overflow-x-auto scrollbar-hide">
                                                <div class="flex gap-3 pb-4 snap-x snap-mandatory touch-pan-x px-2">
                                                    @foreach($blog->gallery_images as $index => $image)
                                                        <div class="flex-shrink-0 w-64 snap-center">
                                                            <div class="relative aspect-[4/3] rounded-xl overflow-hidden cursor-pointer group" @click="openGallery({{ $index }})">
                                                                <img
                                                                    src="{{ $image['url'] ?? $image }}"
                                                                    alt="{{ $image['alt'] ?? $blog->title . ' - Galeri Resmi ' . ($index + 1) }}"
                                                                    class="w-full h-full object-cover transition-transform duration-500 group-active:scale-95"
                                                                    data-gallery-image>
                                                                <div class="absolute inset-0 bg-black/20 group-active:bg-black/40 transition-colors duration-300"></div>
                                                                <div class="absolute top-2 right-2 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center">
                                                                    <x-lucide-expand class="w-4 h-4 text-corporate-900" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tablet Gallery --}}
                                        <div class="hidden sm:block lg:hidden">
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                                @foreach($blog->gallery_images as $index => $image)
                                                    <div class="relative aspect-[4/3] rounded-xl overflow-hidden cursor-pointer group" @click="openGallery({{ $index }})">
                                                        <img
                                                            src="{{ $image['url'] ?? $image }}"
                                                            alt="{{ $image['alt'] ?? $blog->title . ' - Galeri Resmi ' . ($index + 1) }}"
                                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                            data-gallery-image>
                                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                                                        <div class="absolute top-2 right-2 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                            <x-lucide-expand class="w-4 h-4 text-corporate-900" />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Desktop Gallery --}}
                                        <div class="hidden lg:block">
                                            <div class="grid grid-cols-3 gap-4">
                                                @foreach($blog->gallery_images as $index => $image)
                                                    <div class="relative aspect-[4/3] rounded-xl overflow-hidden cursor-pointer group" @click="openGallery({{ $index }})">
                                                        <img
                                                            src="{{ $image['url'] ?? $image }}"
                                                            alt="{{ $image['alt'] ?? $blog->title . ' - Galeri Resmi ' . ($index + 1) }}"
                                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                            data-gallery-image>
                                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                                                        <div class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                            <x-lucide-expand class="w-5 h-5 text-corporate-900" />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Gallery Modal --}}
                                        <div
                                            x-show="isOpen"
                                            x-cloak
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 bg-black z-50"
                                            @touchstart="handleTouchStart($event)"
                                            @touchend="handleTouchEnd($event)">

                                            <div class="relative w-full h-full flex items-center justify-center">
                                                {{-- Close Button --}}
                                                <button
                                                    @click="closeGallery()"
                                                    class="absolute top-4 right-4 sm:top-6 sm:right-6 z-30 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 active:scale-95 transition-all duration-200">
                                                    <x-lucide-x class="w-6 h-6" />
                                                </button>

                                                {{-- Previous Button --}}
                                                <button
                                                    @click="previousImage()"
                                                    class="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 z-30 w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 hover:scale-105 active:scale-95 transition-all duration-200">
                                                    <x-lucide-chevron-left class="w-6 h-6 sm:w-7 sm:h-7" />
                                                </button>

                                                {{-- Next Button --}}
                                                <button
                                                    @click="nextImage()"
                                                    class="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 z-30 w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 hover:scale-105 active:scale-95 transition-all duration-200">
                                                    <x-lucide-chevron-right class="w-6 h-6 sm:w-7 sm:h-7" />
                                                </button>

                                                {{-- Main Image --}}
                                                <div class="relative w-full h-full flex items-center justify-center p-4 sm:p-6 md:p-12">
                                                    <img
                                                        :src="currentImage"
                                                        alt="Gallery Image"
                                                        class="max-w-full max-h-full w-auto h-auto object-contain select-none transition-opacity duration-300"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0 scale-95"
                                                        x-transition:enter-end="opacity-100 scale-100"
                                                        draggable="false">
                                                </div>

                                                {{-- Image Counter --}}
                                                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 px-5 py-2.5 bg-white/20 backdrop-blur-md rounded-full text-white text-sm font-medium">
                                                    <span x-text="currentIndex + 1"></span> / <span x-text="totalImages"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tags -->
                        @if($blog->tags && count($blog->tags) > 0)
                            <div class="px-6 py-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Etiketler</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($blog->tags as $tagSlug)
                                        @if(isset($tagModels[$tagSlug]))
                                            <a href="{{ route('blogs.tag', $tagModels[$tagSlug]) }}"
                                               class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded-full hover:bg-primary-100 hover:text-primary-700 transition-colors">
                                                #{{ $tagModels[$tagSlug]->name }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Social Share -->
                        <div class="px-6 py-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Paylaş</h4>
                            <div class="flex items-center space-x-4">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                   target="_blank"
                                   class="flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                                    <x-lucide-facebook class="w-4 h-4" />
                                    <span class="text-sm">Facebook</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}"
                                   target="_blank"
                                   class="flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                                    <x-lucide-twitter class="w-4 h-4" />
                                    <span class="text-sm">Twitter</span>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                                   target="_blank"
                                   class="flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                                    <x-lucide-linkedin class="w-4 h-4" />
                                    <span class="text-sm">LinkedIn</span>
                                </a>
                                <button onclick="copyToClipboard('{{ request()->url() }}')"
                                        class="flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                                    <x-lucide-copy class="w-4 h-4" />
                                    <span class="text-sm">Kopyala</span>
                                </button>
                            </div>
                        </div>

                        <!-- Author Info -->
                        <div class="px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-semibold text-lg">{{ substr($blog->author->name, 0, 2) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $blog->author->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">Yazar</p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Related Blogs -->
                    @if($relatedBlogs->count() > 0)
                        <div class="mt-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">İlgili Yazılar</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($relatedBlogs as $relatedBlog)
                                    <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                        @if($relatedBlog->featured_image)
                                            <div class="aspect-w-16 aspect-h-9">
                                                <img src="{{ $relatedBlog->featured_image_url }}"
                                                     alt="{{ $relatedBlog->featured_image_alt ?? $relatedBlog->title }}"
                                                     class="w-full h-48 object-cover">
                                            </div>
                                        @endif
                                        <div class="p-6">
                                            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                                                <span class="bg-primary-100 text-primary-800 px-2 py-1 rounded-full text-xs font-medium">
                                                    {{ $relatedBlog->category->name }}
                                                </span>
                                                <span>{{ $relatedBlog->published_at->format('d.m.Y') }}</span>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                                <a href="{{ route('blogs.show', $relatedBlog) }}" class="hover:text-primary-600 transition-colors">
                                                    {{ $relatedBlog->title }}
                                                </a>
                                            </h3>
                                            @if($relatedBlog->excerpt)
                                                <p class="text-gray-600 text-sm line-clamp-3">{{ $relatedBlog->excerpt }}</p>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="mt-8 lg:mt-0">
                    <div class="space-y-6">
                        <!-- Recent Blogs -->
                        @if($recentBlogs->count() > 0)
                            <div class="bg-white border border-gray-200 rounded-lg">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                        <x-lucide-clock class="w-4 h-4 mr-2 text-gray-600" />
                                        Son Yazılar
                                    </h3>
                                </div>
                                <div class="p-4 space-y-3">
                                    @foreach($recentBlogs as $recentBlog)
                                        <div class="flex space-x-3">
                                            @if($recentBlog->featured_image)
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $recentBlog->featured_image_url }}"
                                                         alt="{{ $recentBlog->featured_image_alt ?? $recentBlog->title }}"
                                                         class="w-16 h-16 object-cover rounded-lg">
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 line-clamp-2">
                                                    <a href="{{ route('blogs.show', $recentBlog) }}" class="hover:text-orange-600 transition-colors">
                                                        {{ $recentBlog->title }}
                                                    </a>
                                                </h4>
                                                <p class="text-xs text-gray-500 mt-1">{{ $recentBlog->published_at->format('d.m.Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Popular Tags -->
                        @if($popularTags->count() > 0)
                            <div class="bg-white border border-corporate-200 rounded-lg">
                                <div class="px-4 py-3 border-b border-corporate-200">
                                    <h3 class="text-lg font-medium text-corporate-900 flex items-center">
                                        <x-lucide-tag class="w-4 h-4 mr-2 text-corporate-600" />
                                        Popüler Etiketler
                                    </h3>
                                </div>
                                <div class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($popularTags as $tag)
                                            <a href="{{ route('blogs.tag', $tag) }}"
                                               class="text-xs bg-corporate-100 text-corporate-700 px-2 py-1 rounded hover:bg-primary-100 hover:text-primary-700">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Blog Categories -->
                        @if($categories->count() > 0)
                            <div class="bg-white border border-corporate-200 rounded-lg">
                                <div class="px-4 py-3 border-b border-corporate-200">
                                    <h3 class="text-lg font-medium text-corporate-900 flex items-center">
                                        <x-lucide-folder class="w-4 h-4 mr-2 text-corporate-600" />
                                        Kategoriler
                                    </h3>
                                </div>
                                <div class="divide-y divide-corporate-100">
                                    @foreach($categories->take(5) as $category)
                                        <a href="{{ route('blogs.category', $category) }}"
                                           class="block px-4 py-3 hover:bg-corporate-50">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-corporate-700">{{ $category->name }}</span>
                                                <span class="text-xs text-corporate-500 bg-corporate-100 px-2 py-1 rounded">
                                                    {{ $category->published_blogs_count }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<x-lucide-check class="w-5 h-5" /><span class="text-sm">Kopyalandı!</span>';
                button.classList.add('text-green-600');

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('text-green-600');
                }, 2000);
            });
        }
    </script>
</x-app-layout>
