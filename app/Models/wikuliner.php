<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wikuliner extends Model
{
    /** @use HasFactory<\Database\Factories\WikulinerFactory> */
    use HasFactory;

    protected $fillable = [
        'id_user',
        'name',
        'rating',
        'imageUrl'
    ];

    protected $primaryKey = "id_wikul";
}
