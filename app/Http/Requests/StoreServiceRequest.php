<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'hero_image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'process_title' => ['nullable', 'string', 'max:255'],
            'process_description' => ['nullable', 'string', 'max:1000'],
            'process_steps' => ['nullable', 'array'],
            'process_steps.*.title' => ['required_with:process_steps', 'string', 'max:255'],
            'process_steps.*.description' => ['required_with:process_steps', 'string', 'max:500'],
            'gallery_title' => ['nullable', 'string', 'max:255'],
            'gallery_description' => ['nullable', 'string', 'max:1000'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'seo_content' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
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
            'name' => 'hizmet adı',
            'slug' => 'URL slug',
            'title' => 'başlık',
            'description' => 'açıklama',
            'hero_image' => 'hero resmi',
            'process_title' => 'süreç başlığı',
            'process_description' => 'süreç açıklaması',
            'process_steps' => 'süreç adımları',
            'process_steps.*.title' => 'süreç adımı başlığı',
            'process_steps.*.description' => 'süreç adımı açıklaması',
            'gallery_title' => 'galeri başlığı',
            'gallery_description' => 'galeri açıklaması',
            'gallery_images' => 'galeri resimleri',
            'gallery_images.*' => 'galeri resmi',
            'seo_content' => 'SEO içeriği',
            'status' => 'durum',
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
            'max' => ':attribute en fazla :max karakter olmalıdır.',
            'image' => ':attribute geçerli bir resim dosyası olmalıdır.',
            'mimes' => ':attribute dosya formatı :values olmalıdır.',
            'unique' => ':attribute zaten kullanılmaktadır.',
            'array' => ':attribute geçerli bir dizi olmalıdır.',
            'boolean' => ':attribute geçerli bir boolean değer olmalıdır.',
            'required_with' => ':attribute alanı zorunludur.',
        ];
    }
}
