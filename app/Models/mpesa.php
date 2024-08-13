<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mpesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'shortcode',
        'name',
        'username',
        'key',
        'secret',
        'passkey',
        'b2cPassword',
        'created_by',
    ];
}
