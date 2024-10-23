<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpprdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpprd', function (Blueprint $table) {
            $table->id('tpprd_pk');
            $table->string('tpprd_nomor_peserta')->unique();
            $table->string('tpprd_nama');
            $table->date('tpprd_tanggal_lahir');
            $table->integer('tpprd_umur')->nullable();
            $table->string('tpprd_bank');
            $table->date('tpprd_tanggal_awal')->nullable();
            $table->integer('tpprd_masa_bulan');
            $table->date('tpprd_tanggal_akhir')->nullable();
            $table->decimal('tpprd_up', 15, 2);
            $table->decimal('tpprd_tarif', 8, 2)->nullable();
            $table->decimal('tpprd_premi', 15, 2)->nullable();
            $table->string('tpprd_user_input');
            $table->timestamp('tpprd_date_input')->nullable();
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
        Schema::dropIfExists('tpprd');
    }
}
