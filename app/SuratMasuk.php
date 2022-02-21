<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table='surat_masuks';
    protected $fillable = [
        'no_surat', 'tgl_surat','tgl_diterima','kode_surat','sifat','pengirim','perihal','lampiran'
    ];

    public function disposisi()
    {
        return $this->hasMany('App\Disposisi');
    }
}
