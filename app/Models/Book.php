<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\review;

class Book extends Model
{
    use HasFactory;
    
    //Get data form review with join
    public function review(){
        return $this->hasMany(review::class);
    }
}
