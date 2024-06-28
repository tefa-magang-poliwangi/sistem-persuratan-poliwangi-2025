<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id')->nullable();
            $table->string('no_surat');
            $table->text('perihal')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('tujuan_disposisi')->nullable();
            $table->string('foto_surat')->nullable();
            $table->string('foto_disposisi')->nullable();
            $table->date('tanggal_surat');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('surats');
    }
}
