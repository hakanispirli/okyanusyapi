<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Profil Ayarları
        </h2>
        <p class="text-sm text-gray-600 mt-1">Hesap bilgilerinizi ve ayarlarınızı yönetin</p>
    </x-slot>

    <div class="space-y-6">
        <div class="p-6 bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="max-w-xl">
                @include('admin.profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="max-w-xl">
                @include('admin.profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="max-w-xl">
                @include('admin.profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-admin-layout>
