<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dusun extends Model
{
    use HasFactory;

    public $table = 'dusun';
    protected $fillable = [
        'nama',
    ];

    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }
}
