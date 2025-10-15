{{-- Process Section --}}
@if($service->process_steps && count($service->process_steps) > 0)
    <section class="py-12 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-corporate-900 mb-4">
                    {{ $service->process_title ?? 'Çalışma Sürecimiz' }}
                </h2>
                @if($service->process_description)
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        {{ $service->process_description }}
                    </p>
                @endif
            </div>

            <div class="relative">
                {{-- Connection Line - Hidden on mobile --}}
                <div class="hidden md:block absolute top-12 left-0 right-0 h-0.5 bg-gradient-to-r from-primary-200 via-primary-300 to-primary-200" style="top: 48px;"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min(count($service->process_steps), 4) }} gap-8 md:gap-6">
                    @foreach($service->process_steps as $index => $step)
                        <div class="relative">
                            <div class="flex flex-col items-center text-center">
                                <div class="relative z-10 w-24 h-24 bg-primary-600 rounded-full flex items-center justify-center mb-6 shadow-lg">
                                    <span class="text-3xl font-bold text-white">{{ $index + 1 }}</span>
                                </div>
                                <h3 class="text-xl font-semibold text-corporate-900 mb-3">{{ $step['title'] ?? 'Adım ' . ($index + 1) }}</h3>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    {{ $step['description'] ?? 'Süreç açıklaması' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

