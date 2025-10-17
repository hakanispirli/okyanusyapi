@extends('errors.layout')

@section('title', 'Sayfa Süresi Doldu')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="max-w-lg mx-auto text-center">
        <!-- Error Icon -->
        <div class="mx-auto h-16 w-16 text-primary-500 mb-6">
            <x-lucide-clock class="w-full h-full" />
        </div>

        <!-- Error Code -->
        <div class="text-5xl font-bold text-primary-500 mb-3">419</div>

        <!-- Error Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Sayfa Süresi Doldu</h1>

        <!-- Error Message -->
        <p class="text-gray-600 mb-8">
            Güvenlik nedeniyle sayfa süresi dolmuştur. Lütfen sayfayı yenileyin ve tekrar deneyin.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button onclick="location.reload()"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <x-lucide-refresh-cw class="w-4 h-4 mr-2" />
                Sayfayı Yenile
            </button>

            <a href="{{ url('/') }}"
                class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <x-lucide-house class="w-4 h-4 mr-2" />
                Ana Sayfaya Dön
            </a>
        </div>

        <!-- Help Text -->
        <div class="mt-6 text-sm text-gray-500">
            <p>Bu hata genellikle form gönderimi sırasında oluşur. Lütfen formu tekrar doldurun.</p>
        </div>
    </div>
</div>
@endsection
