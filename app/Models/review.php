<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(user::class);
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
