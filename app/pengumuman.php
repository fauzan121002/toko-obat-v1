<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = "pengumuman";

    protected $primaryKey = "id_pengumuman";

    protected $fillable = [
    	"isi_pengumuman"
    ];
}
