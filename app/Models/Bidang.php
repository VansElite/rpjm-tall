<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    public $table = 'bidang';
    protected $fillable = [
        'nama',
    ];

    public function program(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
