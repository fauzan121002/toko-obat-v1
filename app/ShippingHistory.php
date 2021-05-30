<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingHistory extends Model
{
    protected $table = "riwayat_pengiriman";

    protected $primaryKey = "id_riwayatpengiriman";

    protected $fillable = [
    	"id_supplier",
    	"kode_pengiriman",
    	"nama_supplier",
    	"barang_dikirim",
    	"jumlah_dikirim"
    ];
}
