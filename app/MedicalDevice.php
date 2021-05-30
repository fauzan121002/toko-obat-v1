<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalDevice extends Model
{
    protected $table = "alat_kesehatan";

    protected $primaryKey = "id_alatkesehatan";

    protected $fillable = [
        "kode_alatkesehatan",
    	"foto_alatkesehatan",
    	"nama_alatkesehatan",
        "fungsi_alatkesehatan",
    	"id_supplier",
    	"nama_supplier",
    	"harga_alatkesehatan",
    	"stok",
    	"total_penjualan",
    	"total_pemasukan"
    ];
}
