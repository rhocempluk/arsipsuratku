<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table='jenis_surats';
    protected $fillable = [
        'kode_surat', 'nama_surat',
    ];
}
