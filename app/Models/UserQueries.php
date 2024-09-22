<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQueries extends Model
{
    use HasFactory;

    protected $fillable = [
        'jewel_id',
        'user_id',
        'image_url',
        'query',
        'jewel_image',
    ];

    public function jewel()
    {
        return $this->belongsTo(Jewel::class, 'jewel_id'); // Adjust the foreign key as needed
    }

    public function customQuery()
    {
        return $this->hasOne(CustomQueries::class, 'user_id'); // Adjust the foreign key as necessary
    }

}
