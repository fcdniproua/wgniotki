<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id',
        'service_id',
        'slider_1',
        'slider_2',
        'slider_tag',
        'is_gallery',
        'path',
        'original_name',
        'size',
        'mime_type',
    ];

    /**
     * Get the application that owns the photo.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the full public URL to the photo.
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }

    /**
     * Get the photo file name.
     */
    public function getFileNameAttribute()
    {
        return basename($this->path);
    }
}