<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    use HasFactory;

    public $table = 'bidang';
    protected $fillable = [
        'nama',
    ];

    public function program(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
