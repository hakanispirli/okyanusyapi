<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'header_logo' => ['required', 'image', 'mimes:jpeg,jpg,png,webp,svg', 'max:2048'],
            'footer_logo' => ['required', 'image', 'mimes:jpeg,jpg,png,webp,svg', 'max:2048'],
            'favicon' => ['required', 'image', 'mimes:jpeg,jpg,png,webp,svg,ico', 'max:1024'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'notification_email' => ['required', 'email', 'max:255'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'site adı',
            'phone' => 'telefon',
            'email' => 'e-posta',
            'address' => 'adres',
            'header_logo' => 'header logosu',
            'footer_logo' => 'footer logosu',
            'favicon' => 'favicon',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'whatsapp' => 'WhatsApp',
            'notification_email' => 'bildirim e-postası',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute alanı zorunludur.',
            'string' => ':attribute geçerli bir metin olmalıdır.',
            'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
            'url' => ':attribute geçerli bir URL olmalıdır.',
            'max' => ':attribute en fazla :max karakter olmalıdır.',
            'image' => ':attribute geçerli bir resim dosyası olmalıdır.',
            'mimes' => ':attribute dosya formatı :values olmalıdır.',
        ];
    }
}

