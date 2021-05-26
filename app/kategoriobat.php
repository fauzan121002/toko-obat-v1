<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriObat extends Model
{
	protected $fillable = ["kode_kategoriobat","nama_kategoriobat","deskripsi_kategoriobat"];
	protected $primaryKey = "id_kategoriobat";
    protected $table = "kategori_obat";
}
