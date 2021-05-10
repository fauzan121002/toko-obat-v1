
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Suplemen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suplemen', function (Blueprint $table) {
            $table->increments('id_suplemen');
            $table->string('kode_suplemen');
            $table->string('foto_suplemen');
            $table->string('nama_suplemen');
            $table->text('fungsi_suplemen');
            $table->integer('id_supplier');
            $table->string('nama_supplier');
            $table->bigInteger('harga_suplemen')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('stok_terjual')->nullable();
            $table->integer('total_penjualan')->nullable();
            $table->bigInteger('total_pemasukan')->nullable();
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
