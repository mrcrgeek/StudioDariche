<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\KeyObjectConfig;

class ContactUsContent extends KeyObjectConfig
{
    protected $key = 'contact_us_content';

    protected $fields = [
        'Instagram' => 'string|max:255',
        'LinkedIn' => 'string|max:255',
        'Twitter' => 'string|max:255',
        'Email' => 'email|max:255'
    ];
}
