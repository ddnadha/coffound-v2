<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    public function messages()
    {
        return $this->hasMany(ReviewMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function message()
    {
        return $this->hasMany(ReviewMessage::class);
    }

    public function report()
    {
        return $this->hasOne(ReportReview::class);
    }

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }
}
