<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $casts = [
        'visit_date' => 'date'
    ];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }
}
