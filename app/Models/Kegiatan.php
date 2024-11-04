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
        'tahun_1',
        'tahun_2',
        'tahun_3',
        'tahun_4',
        'tahun_5',
        'tahun_6',
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

    public function dusun(): HasMany
    {
        return $this->hasMany(Dusun::class);
    }
}
