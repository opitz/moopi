<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function plugin() {
        // Laravel Relationship Types:
        // hasOne, hasMany, belongsTo, belongsToMany
        return $this->hasMany(Plugin::class);
    }
}
