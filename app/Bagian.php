<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    protected $table='bagians';
    protected $fillable = [
    'kd_bagian', 'nama_bagian',
    ];

    public function kodebagian()
    {
        return $this->hasMany('App\Disposisi');
    }
}
