<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatingSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function softwareLicenses()
    {
        return $this->belongsToMany(Software::class)->as('details')->withPivot('price', 'stock')->withTimestamps();
    }
}
