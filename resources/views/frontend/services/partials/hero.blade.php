{{-- Hero Section --}}
<section class="relative bg-white py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            {{-- Content --}}
            <div class="order-2 lg:order-1">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-corporate-900 mb-6 leading-tight">
                    {{ $service->title ?? $service->name }}
                </h1>
                <div class="prose prose-lg max-w-none">
                    @if($service->description)
                        <div class="text-gray-600 leading-relaxed mb-4">
                            {!! $service->description_with_breaks !!}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Hero Image --}}
            <div class="order-1 lg:order-2">
                <div class="relative rounded-2xl overflow-hidden border border-gray-200 aspect-[4/3] shadow-xl">
                    @if($service->hero_image)
                        <img
                            src="{{ asset($service->hero_image) }}"
                            alt="{{ $service->name }}"
                            class="w-full h-full object-cover"
                            loading="eager">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                            <x-lucide-building class="w-24 h-24 text-primary-600" />
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-corporate-900/30 to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</section>

