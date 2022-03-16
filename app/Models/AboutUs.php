<?php

namespace App\Models;

use App\Services\KeyObjectConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends KeyObjectConfig
{
    protected $key = 'About_Us_Content';

    protected $fields = [
        'Awards' => 'string|max:2000',
        'Vision' => 'string|max:2000',
        'Services' => 'string|max:2000',
        'Mission' => 'string|max:2000'
    ];
}
