<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'service', 'brand', 'model', 'message', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all photos for the application.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    protected $appends = ['photo_urls'];

    public function getPhotoUrlsAttribute()
    {
        return $this->photos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'url' => asset('storage/' . $photo->path),
                'thumbnail' => asset('storage/' . $photo->path) // Можна додати логіку для thumbnail
            ];
        });
    }

}