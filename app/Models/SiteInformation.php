<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteInformation extends Model
{
    protected $table = 'site_information';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'header_logo',
        'footer_logo',
        'favicon',
        'facebook',
        'instagram',
        'twitter',
        'whatsapp',
        'notification_email',
    ];
}
