<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'season', 'image_path'];

    public function scopeKeyword($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where('name', 'like', "%{$keyword}%");
        }
    }

    public function scopeSafeSort($query, $sort, $dir)
    {
        $allowed = ['id', 'name', 'price'];
        if (!in_array($sort, $allowed)) $sort = 'id';
        return $query->orderBy($sort, $dir ?? 'asc');
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path
        ? asset($this->image_path)
        : asset('images/noimage.png');
    }
    public function seasons() {
        return $this->belongsToMany(\App\Models\Season::class);
    }
}
