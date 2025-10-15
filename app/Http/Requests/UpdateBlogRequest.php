<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
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
        $blogId = $this->route('blog')->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blogs', 'slug')->ignore($blogId)],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:blog_categories,id'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'featured_image_alt' => ['nullable', 'string', 'max:255'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'meta_og' => ['nullable', 'array'],
            'meta_og.title' => ['nullable', 'string', 'max:60'],
            'meta_og.description' => ['nullable', 'string', 'max:160'],
            'meta_og.image' => ['nullable', 'string', 'max:255'],
            'reading_time' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable', 'boolean'],
            'featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'tags' => ['nullable', 'string'],
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
            'title' => 'başlık',
            'slug' => 'URL slug',
            'excerpt' => 'özet',
            'content' => 'içerik',
            'category_id' => 'kategori',
            'featured_image' => 'kapak resmi',
            'featured_image_alt' => 'kapak resmi alt metni',
            'gallery_images' => 'galeri resimleri',
            'gallery_images.*' => 'galeri resmi',
            'meta_title' => 'meta başlık',
            'meta_description' => 'meta açıklama',
            'meta_keywords' => 'meta anahtar kelimeler',
            'meta_og' => 'Open Graph verileri',
            'meta_og.title' => 'Open Graph başlık',
            'meta_og.description' => 'Open Graph açıklama',
            'meta_og.image' => 'Open Graph resim',
            'reading_time' => 'okuma süresi',
            'status' => 'durum',
            'featured' => 'öne çıkan',
            'published_at' => 'yayın tarihi',
            'tags' => 'etiketler',
            'tags.*' => 'etiket',
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
            'exists' => 'Seçilen :attribute geçersizdir.',
            'date' => ':attribute geçerli bir tarih olmalıdır.',
            'integer' => ':attribute geçerli bir sayı olmalıdır.',
            'min' => ':attribute en az :min olmalıdır.',
        ];
    }
}
