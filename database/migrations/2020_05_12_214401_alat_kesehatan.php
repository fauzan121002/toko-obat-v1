
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlatKesehatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alat_kesehatan', function (Blueprint $table) {
            $table->increments('id_alatkesehatan');
            $table->string('foto_alatkesehatan');
            $table->string('kode_alatkesehatan');
            $table->string('nama_alatkesehatan');
            $table->text('fungsi_alatkesehatan');
            $table->bigInteger('id_supplier');
            $table->string('nama_supplier');
            $table->bigInteger('harga_alatkesehatan')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('stok_terjual')->nullable();
            $table->integer('total_penjualan')->nullable();
            $table->integer('total_pemasukan')->nullable();
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
