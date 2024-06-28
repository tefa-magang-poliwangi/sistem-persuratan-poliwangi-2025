<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_disposisis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('surat_masuk_id');
            $table->bigInteger('induk');
            $table->dateTime('waktu');
            $table->char('disposisi_singkat', 100)->nullable();
            $table->text('disposisi_narasi')->nullable();
            $table->enum('jenis', ['turun', 'kembali'])->default('turun');
            $table
                ->enum('status', ['proses', 'selesai'])
                ->default('proses');
            $table->char('lampiran_tindak_lanjut', 200);
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
        Schema::dropIfExists('surat_disposisis');
    }
}
