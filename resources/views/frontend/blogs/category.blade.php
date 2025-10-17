<x-app-layout :seoData="$seoData">
    {{-- Breadcrumb --}}
    <nav class="bg-gray-50 border-b border-gray-200" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}"
                        class="text-gray-500 hover:text-primary-600 transition-colors duration-200">
                        <x-lucide-house class="w-4 h-4" />
                    </a>
                </li>
                <li class="flex items-center">
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-400 mx-2" />
                    <a href="{{ route('blogs') }}" class="text-gray-500 hover:text-primary-600 transition-colors duration-200">
                        Uygulamalar
                    </a>
                </li>
                <li class="flex items-center">
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-400 mx-2" />
                    <span class="text-gray-900 font-medium">{{ $category->name }}</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section with Gradient --}}
    <section class="bg-gradient-to-br from-corporate-950 via-corporate-900 to-primary-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white mb-3">
                    {{ $category->name }} Kategorisi
                </h1>
                @if($category->description)
                    <p class="text-gray-200 max-w-2xl mx-auto text-base">
                        {{ $category->description }}
                    </p>
                @endif
                <div class="mt-4 text-sm text-gray-300">
                    <span>{{ $blogs->total() }} uygulama bulundu</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="py-8 md:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Search -->
                    <div class="mb-8">
                        <form method="GET" action="{{ route('blogs.category', $category) }}">
                            <div class="flex gap-3">
                                <div class="flex-1">
                                    <div class="relative">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="{{ $category->name }} kategorisinde ara..."
                                            class="w-full px-4 py-3 pl-12 border border-corporate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                        <x-lucide-search class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-corporate-500" />
                                    </div>
                                </div>
                                <button type="submit"
                                    class="px-6 py-3 bg-primary-600 text-white rounded-lg border border-primary-600 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    <x-lucide-search class="w-5 h-5 inline mr-2" />
                                    Ara
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Blog List -->
                    <div class="space-y-6">
                        @if ($blogs->count() > 0)
                            @foreach ($blogs as $blog)
                                <article class="bg-white border border-corporate-200 rounded-lg overflow-hidden">
                                    <div class="md:flex">
                                        @if ($blog->featured_image)
                                            <div class="md:w-1/3">
                                                <div class="aspect-w-16 aspect-h-9 md:h-full">
                                                    <img src="{{ $blog->featured_image_url }}"
                                                        alt="{{ $blog->featured_image_alt ?? $blog->title }}"
                                                        class="w-full h-48 md:h-full object-cover">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="{{ $blog->featured_image ? 'md:w-2/3' : 'w-full' }} p-6">
                                            <div class="flex items-center space-x-2 text-sm text-corporate-500 mb-3">
                                                <span class="bg-primary-100 text-primary-700 px-2 py-1 rounded text-xs font-medium">
                                                    {{ $blog->category->name }}
                                                </span>
                                                <span>{{ $blog->published_at->format('d.m.Y') }}</span>
                                            </div>
                                            <h2 class="text-xl font-semibold text-corporate-900 mb-3">
                                                <a href="{{ route('blogs.show', $blog) }}" class="hover:text-primary-600">
                                                    {{ $blog->title }}
                                                </a>
                                            </h2>
                                            @if ($blog->excerpt)
                                                <p class="text-corporate-600 mb-4 line-clamp-3">{{ $blog->excerpt }}</p>
                                            @endif

                                            <!-- Tags -->
                                            @if ($blog->tags && count($blog->tags) > 0)
                                                <div class="flex flex-wrap gap-2 mb-4">
                                                    @foreach (array_slice($blog->tags, 0, 3) as $tagSlug)
                                                        @if(isset($tagModels[$tagSlug]))
                                                            <a href="{{ route('blogs.tag', $tagModels[$tagSlug]) }}"
                                                                class="text-xs bg-corporate-100 text-corporate-700 px-2 py-1 rounded hover:bg-primary-100 hover:text-primary-700">
                                                                #{{ $tagModels[$tagSlug]->name }}
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                    @if (count($blog->tags) > 3)
                                                        <span class="text-xs text-corporate-500">+{{ count($blog->tags) - 3 }} daha</span>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="flex items-center justify-between pt-4 border-t border-corporate-100">
                                                <div class="flex items-center space-x-2 text-sm text-corporate-500">
                                                    <x-lucide-user class="w-4 h-4" />
                                                    <span>{{ $blog->author->name }}</span>
                                                </div>
                                                <div class="flex items-center space-x-4 text-sm text-corporate-500">
                                                    <div class="flex items-center space-x-1">
                                                        <x-lucide-eye class="w-4 h-4" />
                                                        <span>{{ $blog->views }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-1">
                                                        <x-lucide-clock class="w-4 h-4" />
                                                        <span>{{ $blog->reading_time }} dk</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach

                            <!-- Pagination -->
                            <div class="mt-8">
                                {{ $blogs->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <x-lucide-file-x class="mx-auto h-12 w-12 text-gray-400" />
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Uygulama bulunamadı</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    @if (request()->has('search') || request()->has('tag'))
                                        Arama kriterlerinize uygun uygulama bulunamadı.
                                    @else
                                        Bu kategoride henüz hiç uygulama yayınlanmamış.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="mt-8 lg:mt-0">
                    <div class="space-y-6">
                        <!-- Categories -->
                        @if ($categories->count() > 0)
                            <div class="bg-white border border-corporate-200 rounded-lg">
                                <!-- Header -->
                                <div class="px-4 py-3 border-b border-corporate-200">
                                    <h3 class="text-lg font-medium text-corporate-900 flex items-center">
                                        <x-lucide-folder class="w-4 h-4 mr-2 text-corporate-600" />
                                        Kategoriler
                                    </h3>
                                </div>

                                <!-- Category List -->
                                <div class="divide-y divide-corporate-100">
                                    @foreach ($categories as $cat)
                                        <a href="{{ route('blogs.category', $cat) }}"
                                           class="block px-4 py-3 hover:bg-corporate-50 {{ $cat->id == $category->id ? 'bg-primary-50 border-l-2 border-primary-500' : '' }}">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium {{ $cat->id == $category->id ? 'text-primary-700' : 'text-corporate-700' }}">
                                                    {{ $cat->name }}
                                                </span>
                                                <span class="text-xs text-corporate-500 bg-corporate-100 px-2 py-1 rounded">
                                                    {{ $cat->published_blogs_count }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Popular Tags -->
                        @if ($popularTags->count() > 0)
                            <div class="bg-white border border-corporate-200 rounded-lg">
                                <!-- Header -->
                                <div class="px-4 py-3 border-b border-corporate-200">
                                    <h3 class="text-lg font-medium text-corporate-900 flex items-center">
                                        <x-lucide-tag class="w-4 h-4 mr-2 text-corporate-600" />
                                        Popüler Etiketler
                                    </h3>
                                </div>

                                <!-- Tags List -->
                                <div class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($popularTags as $tag)
                                            <a href="{{ route('blogs.tag', $tag) }}"
                                               class="inline-flex items-center px-2 py-1 text-xs bg-corporate-100 text-corporate-700 hover:bg-primary-100 hover:text-primary-700 rounded">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
