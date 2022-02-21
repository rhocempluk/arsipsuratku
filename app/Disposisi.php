<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $table='disposisis';
    protected $fillable = [
        'id_suratmasuk','tgl_disposisi','id_bagian','isi',
    ];

    public function suratmasuk()
    {
        return $this->belongsTo('App\SuratMasuk', 'id_suratmasuk');

    }

    public function dispobagian()
    {
        return $this->belongsTo('App\Bagian', 'id_bagian');

    }
}