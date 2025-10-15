<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
            'description' => ['nullable', 'string', 'max:1000'],
            'brands_images' => ['nullable', 'array'],
            'brands_images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
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
            'name' => 'bölüm başlığı',
            'description' => 'bölüm açıklaması',
            'brands_images' => 'marka resimleri',
            'brands_images.*' => 'marka resmi',
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
            'boolean' => ':attribute geçerli bir boolean değer olmalıdır.',
        ];
    }
}
