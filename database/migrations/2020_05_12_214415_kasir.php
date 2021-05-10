
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kasir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasir', function (Blueprint $table) {
            $table->increments('id_kasir');
            $table->string('kode_kasir');
            $table->string('foto_kasir');
            $table->string('nama_kasir');
            $table->string('email');
            $table->string('password');
            $table->char('jenis_kelamin',1);
            $table->date('tanggal_lahir');
            $table->string('pendidikan_terakhir');
            $table->string('nomor_telepon');
            $table->text('alamat');
            $table->bigInteger('jumlah_transaksi');
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
