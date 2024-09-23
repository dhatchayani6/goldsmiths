<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customqueries extends Model
{
    use HasFactory;
    public function jewel()
{
    return $this->belongsTo(Jewel::class);
}

public function customQuery()
{
    return $this->hasOne(CustomQueries::class, 'user_id'); // Adjust the foreign key as necessary
}

}
