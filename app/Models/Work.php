<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $table = 'works';

    protected $fillable = [
        'information',
        'img',
        'work_name',
        'type',
        'is_index'
    ];

    protected $casts = [
        'is_index' => 'boolean'
    ];
}