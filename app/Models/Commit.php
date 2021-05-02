<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plugin() {
        return $this->belongsTo(Plugin::class);
    }
    public function collections() {
        return $this->belongsToMany(Collection::class,'collection_commits');
    }
}
