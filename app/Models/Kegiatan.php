<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    use HasFactory;

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
        'deskripsi',
    ];
    protected $casts = [
        'tahun_1' => 'boolean',
        'tahun_2' => 'boolean',
        'tahun_3' => 'boolean',
        'tahun_4' => 'boolean',
        'tahun_5' => 'boolean',
        'tahun_6' => 'boolean',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    public function dusun(): BelongsTo
    {
        return $this->belongsTo(Dusun::class, 'id_dusun');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_kegiatan');
    }

    public function latestProgress()
    {
        return $this->hasOne(Laporan::class,'id_kegiatan')->latestOfMany();
    }
}
