<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SmtpSetting extends Model
{
    protected $fillable = [
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'is_active',
        'description',
    ];

    protected $casts = [
        'port' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active SMTP settings.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the current active SMTP setting.
     */
    public static function getActive()
    {
        return static::active()->first();
    }

    /**
     * Get formatted SMTP configuration for mail config.
     */
    protected function mailConfig(): Attribute
    {
        return Attribute::make(
            get: function () {
                return [
                    'transport' => $this->mailer,
                    'host' => $this->host,
                    'port' => $this->port,
                    'username' => $this->username,
                    'password' => $this->password,
                    'encryption' => $this->encryption,
                    'timeout' => null,
                    'local_domain' => parse_url(config('app.url'), PHP_URL_HOST),
                ];
            },
        );
    }

    /**
     * Get formatted from configuration.
     */
    protected function fromConfig(): Attribute
    {
        return Attribute::make(
            get: function () {
                return [
                    'address' => $this->from_address,
                    'name' => $this->from_name,
                ];
            },
        );
    }
}
