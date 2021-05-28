<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transaksi";
    protected $primaryKey = "id_transaksi";
    protected $fillable = [ 
    	"kode_transaksi",
    	"nama_pesanan",
    	"jumlah_pesanan",
    	"uang_diterima",
    	"kode_kasir",
    	"nama_kasir"
    ];
}
