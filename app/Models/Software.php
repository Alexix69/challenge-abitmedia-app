<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'type',
        'serial'
    ];

    public function operatingSystems()
    {
        return $this->belongsToMany(OperatingSystem::class)->as('details')->withPivot('price', 'stock')->withTimestamps();
    }
}
