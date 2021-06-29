<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = "supplier";
    protected $fillable = [
    	"kode_supplier",
    	"nama_supplier",
    	"deskripsi_supplier",
    	"jumlah_pengiriman",
    	"status"
    ];
    protected $primaryKey = "id_supplier";
}
