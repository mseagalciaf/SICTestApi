<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[''];

    //Relacion uno a muchos (inversa)
    public function category()
    {
        return $this->belongsTo(category::class);
    }
}
