<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('id_suratmasuk');
            $table->date('tgl_disposisi');
            $table->unsignedBigInteger('id_bagian');
            $table->string('isi');
            $table->timestamps();
            $table->foreign('id_suratmasuk')->references('id')->on('surat_masuks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_bagian')->references('id')->on('bagians')->onUpdate('cascade')->onDelete('cascade');
           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposisis');
    }
}
