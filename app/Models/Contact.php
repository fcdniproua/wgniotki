<?php

// app/Models/Contact.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'address',
        'opening_hours',
        'map_embed'
    ];

    protected $casts = [
        'opening_hours' => 'array'
    ];
}