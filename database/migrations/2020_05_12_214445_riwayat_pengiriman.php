
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RiwayatPengiriman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pengiriman', function (Blueprint $table) {
            $table->increments('id_riwayatpengiriman');
            $table->string('kode_pengiriman');
            $table->integer('id_supplier');
            $table->string('nama_supplier');
            $table->string('barang_dikirim');
            $table->string('jumlah_dikirim');
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
        //
    }
}
