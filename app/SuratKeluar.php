<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table='surat_keluars';
    protected $fillable = [
        'no_suratkeluar', 'tgl_surat','pengirim','kepada','perihal','isi_surat','sifat','alamat','ekspedisi','lampiran'
    ];


}
