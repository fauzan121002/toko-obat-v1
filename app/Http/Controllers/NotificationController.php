<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class NotificationController extends Controller {
    public function update(Request $request){
        $message = [
            "required"=>"mohon isi atribut :attribute"
        ];

        $this->validate($request,[
            "isi_pengumuman"=>"required|min:1|max:3000"
        ],$message);

        $pengumuman = Notification::find(1);
        $pengumuman->isi_pengumuman = $request->isi_pengumuman;
        $pengumuman->save();

        return redirect('/dashboard')->with('itemUpdated','Pengumuman Berhasil Diubah!');
    }
}