<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $table = 'records';

    protected $fillable = [
        'category',
        'date',
        'content',
        'value'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public $timestamps = false;
}
