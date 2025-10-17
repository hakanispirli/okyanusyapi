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
                            <div class="prose prose-lg max-w-none">
                                {!! $blog->content !!}
                            </div>
                        </div>

                        <!-- Tags -->
                        @if($blog->tags && count($blog->tags) > 0)
                            <div class="px-6 py-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Etiketler</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($blog->tags as $tag)
                                        @if(isset($tagModels[$tag]))
                                            <a href="{{ route('blogs.tag', $tagModels[$tag]) }}"
                                               class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded-full hover:bg-primary-100 hover:text-primary-700 transition-colors">
                                                #{{ $tag }}
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
