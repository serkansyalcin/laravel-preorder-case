<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'price', 'sku', 'image'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceAttribute()
    {
        return $this->attributes['price'];
    }

    public function setImageAttribute($value)
    {
        // Check if the value is an uploaded file
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            // Store the file in the 'products' disk and save the path
            $this->attributes['image'] = $value->store('images', 'products');
        } else {
            // If it's not a file, assume it's a string (e.g., when updating without a file)
            $this->attributes['image'] = $value;
        }
    }

    public function getImageAttribute()
    {
        // Return the full URL of the stored image
        return $this->attributes['image']
            ? Storage::url($this->attributes['image'])
            : null;
    }
}
