<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Laravel Relationship Types:
    // hasOne, hasMany, belongsTo, belongsToMany

    public function commits() {
        return $this->belongsToMany(Commit::class,'collection_commits');
    }

    public function plugins() {
        return $this->belongsToMany(Plugin::class,'collection_plugins');
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }
}

