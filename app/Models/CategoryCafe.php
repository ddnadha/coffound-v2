<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCafe extends Model
{
    use HasFactory;

    public function cafe(){
        return $this->belongsTo(Cafe::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
