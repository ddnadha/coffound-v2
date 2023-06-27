<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Cafe extends Model
{
    use HasFactory, SoftDeletes;

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function image()
    {
        return $this->hasMany(CafeImage::class);
    }

    public function visit()
    {
        return $this->hasMany(Visit::class);
    }

    public function url()
    {
        return $this->hasMany(CafeUrl::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    public function category()
    {
        return $this->hasMany(CategoryCafe::class);
    }

    public function favourite()
    {
        return $this->hasMany(Favourite::class);
    }

    protected function isFav(): Attribute
    {
        $is_fav = Favourite::where('cafe_id', $this->id)
            ->where('user_id', Auth::id())->exists();
        return Attribute::make(
            get: fn () => $is_fav
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deletion()
    {
        return $this->hasOne(Deletion::class)->latest();
    }

    public function activation()
    {
        return $this->hasOne(Activation::class)->latest();
    }

    protected function mainImage(): Attribute
    {
        $img = CafeImage::where('cafe_id', $this->id);
        if (!(clone $img)->exists()) {
            $main_image = 'storage/cafe/default.jpg';
        } elseif ((clone $img)->where('is_priority', 1)->exists()) {
            $main_image =  $img->where('is_priority', 1)->first()->img;
        } else {
            $main_image = $img->first()->img;
        }

        return Attribute::make(
            get: fn () => $main_image
        );
    }
}
