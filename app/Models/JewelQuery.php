<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JewelQuery extends Model
{
    use HasFactory;

    protected $table = 'jewel_queries'; // Example if table name is different

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
