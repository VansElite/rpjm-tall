<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kegiatan extends Model
{
    public $table = 'kegiatan';
    protected $fillable = [
        'id_program',
        'nama',
        'status',
        'volume',
        'satuan',
        'tahun1',
        'tahun2',
        'tahun3',
        'tahun4',
        'tahun5',
        'tahun6',
        'lokasi',
        'id_dusun',
        'longitude',
        'latitude',
        'progres',
        'deskripsi',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }
}
