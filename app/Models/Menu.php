<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected function mainImage() :Attribute
    {
        $img = MenuImage::where('menu_id', $this->id);
        if(!$img->exists()){
            $main_image = 'storage/cafe/default.jpg';
        }elseif($img->where('is_priority', 1)->exists()){
            $main_image =  $img->where('is_priority', 1)->first()->img;
        }else{
            $main_image = $img->first()->img;
        }

        return Attribute::make(
            get: fn() => $main_image
        );
    }

    public function image(){
        return $this->hasMany(MenuImage::class)->orderBy('is_priority', 'desc');
    }

    public function cafe(){
        return $this->belongsTo(Cafe::class);
    }
}
