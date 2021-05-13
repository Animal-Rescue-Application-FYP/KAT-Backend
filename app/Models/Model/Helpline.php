<?php

namespace App\Models\Model;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helpline extends Model
{
    // use HasFactory;
    public $table = "helpline";

    protected $fillable = [
        'name',
        'address',
        'phone'
    ];

    public $timestamps = false;
}
