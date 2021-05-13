<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rescue extends Model
{
    //use HasFactory;
    public $table = "rescue";

    protected $fillable = [
        'animalName',
        'image',
        'category',
        'year',
        'gender',
        'address',
        'phone',
        'postedBy',
        'description',
        'user_id'
    ];

    public $timestamps = false;
}
