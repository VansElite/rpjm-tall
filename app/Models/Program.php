<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    public $table = 'program';
    protected $fillable = [
        'id_bidang',
        'nama',
        'cangkupan_program',
    ];

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class, 'id_bidang');
    }

    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }
}
