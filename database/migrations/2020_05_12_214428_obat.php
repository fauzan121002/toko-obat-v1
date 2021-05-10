
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Obat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->increments('id_obat');
            $table->string('kode_obat');
            $table->string('foto_obat');
            $table->string('nama_obat');
            $table->text('fungsi_obat');
            $table->string('nama_kategoriobat');
            $table->string('nama_jenisobat');
            $table->integer('id_supplier');
            $table->string('nama_supplier');
            $table->bigInteger('harga_obat')->nullable();
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
