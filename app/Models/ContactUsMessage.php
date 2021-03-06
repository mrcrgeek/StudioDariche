<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsMessage extends Model
{
    use HasFactory;

    protected $table = 'contact_us_messages';

    protected $fillable = [
        'name',
        'email',
        'phoneNumber',
        'message'
    ];
}
