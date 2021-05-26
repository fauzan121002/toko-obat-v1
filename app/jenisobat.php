<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisObat extends Model
{
    protected $table = "jenis_obat";
    protected $primaryKey = "id_jenisobat";
    protected $fillable = [
    	"kode_jenisobat",
    	"nama_jenisobat",
    	"deskripsi_jenisobat"
    ];
}
