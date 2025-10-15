<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSmtpRequest extends FormRequest
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
            'mailer' => ['required', 'string', 'in:smtp'],
            'host' => ['required', 'string', 'max:255'],
            'port' => ['required', 'integer', 'min:1', 'max:65535'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'encryption' => ['nullable', 'string', 'in:tls,ssl,null'],
            'from_address' => ['required', 'email', 'max:255'],
            'from_name' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:500'],
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
            'mailer' => 'mailer',
            'host' => 'SMTP sunucusu',
            'port' => 'port',
            'username' => 'kullanıcı adı',
            'password' => 'şifre',
            'encryption' => 'şifreleme',
            'from_address' => 'gönderen e-posta',
            'from_name' => 'gönderen adı',
            'is_active' => 'aktif durumu',
            'description' => 'açıklama',
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
            'integer' => ':attribute geçerli bir sayı olmalıdır.',
            'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
            'max' => ':attribute en fazla :max karakter olmalıdır.',
            'min' => ':attribute en az :min olmalıdır.',
            'in' => ':attribute geçerli bir değer olmalıdır.',
            'boolean' => ':attribute geçerli bir boolean değer olmalıdır.',
        ];
    }
}
