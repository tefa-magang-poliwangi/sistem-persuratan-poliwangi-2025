<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->bigInteger('induk');
            $table->char('nomor', 100);
            $table->date('tanggal_surat');
            $table->dateTime('tanggal_diterima');
            $table->char('pengirim', 100);
            $table->char('diterima_dari', 100)->nullable();
            $table->char('perihal', 200);
            $table
                ->enum('sifat', [
                    'Biasa',
                    'Segera',
                    'Penting',
                    'Penting Segera',
                    'Rahasia',
                ])
                ->default('Biasa');
            $table->unsignedBigInteger('user_id');
            $table->char('catatan_sekretariat', 200)->nullable();
            $table->char('file', 200)->nullable();

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
