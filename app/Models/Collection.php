<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function commits() {
        // Laravel Relationship Types:
        // hasOne, hasMany, belongsTo, belongsToMany
//        die('wtff?');
        return $this->belongsToMany(Commit::class,'collection_commits');
    }
}

