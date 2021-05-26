<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
	protected $fillable = ["kode_kasir",'foto_kasir','nama_kasir','username','password','email','jenis_kelamin','tanggal_lahir','pendidikan_terakhir','nomor_telepon','alamat','jumlah_transaksi'];
	protected $primaryKey = "id_kasir";
    protected $table = "kasir";
}
