<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    protected $table = "suplemen";

    protected $primaryKey = "id_suplemen";

    protected $fillable = [
        "kode_suplemen",
    	"foto_suplemen",
    	"nama_suplemen",
        "fungsi_suplemen",
    	"id_supplier",
    	"nama_supplier",
    	"harga_suplemen",
    	"stok",
        "stok_terjual",
    	"total_penjualan",
    	"total_pemasukan"
    ];
}
