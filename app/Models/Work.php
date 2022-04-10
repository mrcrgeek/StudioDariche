<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $table = 'works';

    protected $fillable = [
        'title',
        'year',
        'img',
        'work_name',
        'type',
        'category',
        'is_index'
    ];

    protected $casts = [
        'is_index' => 'boolean'
    ];
}
