@extends('errors.layout')

@section('title', 'Erişim Engellendi')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="max-w-lg mx-auto text-center">
        <!-- Error Icon -->
        <div class="mx-auto h-16 w-16 text-primary-500 mb-6">
            <x-lucide-shield-x class="w-full h-full" />
        </div>

        <!-- Error Code -->
        <div class="text-5xl font-bold text-primary-500 mb-3">403</div>

        <!-- Error Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Erişim Engellendi</h1>

        <!-- Error Message -->
        <p class="text-gray-600 mb-8">
            @if($exception->getMessage())
                {{ $exception->getMessage() }}
            @else
                Bu sayfaya erişim yetkiniz bulunmamaktadır.
            @endif
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}"
                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <x-lucide-house class="w-4 h-4 mr-2" />
                Ana Sayfaya Dön
            </a>

            @auth
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <x-lucide-user class="w-4 h-4 mr-2" />
                    Hesabım
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <x-lucide-log-in class="w-4 h-4 mr-2" />
                    Giriş Yap
                </a>
            @endauth
        </div>

        <!-- Help Text -->
        <div class="mt-6 text-sm text-gray-500">
            <p>Eğer bu sayfaya erişim yetkiniz olduğunu düşünüyorsanız, lütfen yönetici ile iletişime geçin.</p>
        </div>
    </div>
</div>
@endsection
