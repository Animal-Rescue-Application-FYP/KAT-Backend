<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    //use HasFactory;
    public $table = "assistance";

    protected $fillable = [
        'query',
        'url',
        'description'
    ];

    public $timestamps = false;
}
