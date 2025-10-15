<x-app-layout :seoData="$seoData">
    <!-- Hero Section -->
    @include('frontend.home.sections.hero-section')

    <!-- Services Section -->
    @include('frontend.home.sections.services-section')

    <!-- Features Section -->
    @include('frontend.home.sections.features-section')

    <!-- Marquee Section -->
    @include('frontend.home.sections.marquee-section')

    <!-- Brands Section -->
    @include('frontend.home.sections.brands-section')

    <!-- Additional sections will be added here -->
    <!-- Example: Projects, About, Testimonials, etc. -->
</x-app-layout>
