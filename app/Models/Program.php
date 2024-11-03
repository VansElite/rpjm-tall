<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    public $table = 'program';
    protected $fillable = [
        'id_bidang',
        'nama',
        'cangkupan_program',
    ];

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }

    public function kegiatan(): HasMany
    {
        return $this->hasMany(Bidang::class);
    }
}
