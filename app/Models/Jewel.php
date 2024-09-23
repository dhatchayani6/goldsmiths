<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jewel extends Model
{

    use HasFactory;
    protected $table = 'jewels';

    // Specify the fillable attributes
    protected $fillable = [
        'name',
        'description',
        'price',
        'jewel_image', // Make sure this matches your database column
        // Add any other relevant fields
    ];

  
}
