<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat');
            $table->date('tgl_surat');
            $table->date('tgl_diterima');
            $table->string('kode_surat');
            $table->string('sifat');
            $table->string('pengirim');
            $table->string('perihal');
            $table->string('lampiran');
            $table->string('status_dispo')->default('Belum Didisposisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_masuks');
    }
}
