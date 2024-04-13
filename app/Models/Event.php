<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'image_cover', 'image_background'];

    public function concerts()
    {
        return $this->hasMany(Concert::class);
    }
}
