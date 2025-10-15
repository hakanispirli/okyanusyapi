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
                    <span class="text-gray-900 font-medium">Hizmetlerimiz</span>
                </li>
            </ol>
        </div>
    </nav>

    {{-- Hero Section with Gradient --}}
    <section class="bg-gradient-to-br from-corporate-950 via-corporate-900 to-primary-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white mb-3">
                    Hizmetlerimiz
                </h1>
                <p class="text-gray-200 max-w-2xl mx-auto text-base">
                    30 yılı aşkın deneyimimizle sunduğumuz profesyonel hizmetler
                </p>
            </div>
        </div>
    </section>

    {{-- Services List Section --}}
    <section class="py-8 md:py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($services as $service)
                        <div
                            class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                            {{-- Service Image --}}
                            <a href="{{ route('services.show', $service) }}" class="block">
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    @if ($service->hero_image)
                                        <img src="{{ asset($service->hero_image) }}" alt="{{ $service->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div
                                            class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                            <x-lucide-building class="w-16 h-16 text-primary-600" />
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                    <div class="absolute top-4 right-4">
                                        <span
                                            class="px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-sm font-medium text-corporate-900">
                                            {{ $service->name }}
                                        </span>
                                    </div>
                                </div>
                            </a>

                            {{-- Service Content --}}
                            <div class="p-6">
                                <a href="{{ route('services.show', $service) }}" class="block">
                                    <h3
                                        class="text-xl font-semibold text-corporate-900 mb-3 group-hover:text-primary-600 transition-colors duration-200 hover:text-primary-600 cursor-pointer">
                                        {{ $service->title ?? $service->name }}
                                    </h3>
                                </a>

                                @if ($service->description)
                                    <div class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                        {!! Str::limit($service->description_with_breaks, 120) !!}
                                    </div>
                                @endif

                                {{-- Service Features --}}
                                @if ($service->process_steps && count($service->process_steps) > 0)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-corporate-900 mb-2">Süreç Adımları:</h4>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach (array_slice($service->process_steps, 0, 3) as $step)
                                                <span
                                                    class="px-2 py-1 bg-primary-100 text-primary-700 text-xs rounded-full">
                                                    {{ $step['title'] ?? 'Adım ' . $loop->iteration }}
                                                </span>
                                            @endforeach
                                            @if (count($service->process_steps) > 3)
                                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                    +{{ count($service->process_steps) - 3 }} daha
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                {{-- Action Button --}}
                                <a href="{{ route('services.show', $service) }}"
                                    class="inline-flex items-center justify-center w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 group-hover:shadow-md">
                                    <span>Detayları Gör</span>
                                    <x-lucide-arrow-right class="w-4 h-4 ml-2" />
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- No Services Found --}}
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-lucide-building class="w-12 h-12 text-gray-400" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Henüz hizmet eklenmemiş</h3>
                    <p class="text-gray-600">Yakında hizmetlerimizi burada görebileceksiniz.</p>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
