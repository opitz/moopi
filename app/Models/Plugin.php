<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope(fn ($query) => $query->orderBy('install_path'));
    }

    public function category() {
        // Laravel Relationship Types:
        // hasOne, hasMany, belongsTo, belongsToMany
        return $this->belongsTo(Category::class);
    }

    public function commits() {
        return $this->hasMany(Commit::class);
    }

    public function collections() {
        return $this->belongsToMany(Collection::class,'collection_plugins');
    }
}
