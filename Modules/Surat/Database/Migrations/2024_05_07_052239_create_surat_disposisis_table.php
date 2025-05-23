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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->bigInteger('induk');
            $table->dateTime('waktu');
            $table->boolean('status')->default(0); // 0 : untuk surat disposisi yg belum di selesaikan, 1 : untuk surat disposisi yang berhasil di selesaikan
            $table->char('disposisi_singkat', 100)->nullable();
            $table->text('disposisi_narasi')->nullable();
            $table->string('tujuan_disposisi')->nullable();
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
