<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingHistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class ShippingController extends Controller {
    public function index(){
        if(Session::has('email')){                
            $riwayatpengiriman = ShippingHistory::orderBy('id_riwayatpengiriman','DESC')->paginate(10);
            return view('feature/shipping-history',['riwayatpengiriman'=>$riwayatpengiriman]);
        }else{
            return redirect()->route('login');             
        }
    } 

    public function destroy($id){
        ShippingHistory::find($id)->delete();

        return redirect('/shipping-history')->with('berhasilHapus','Riwayat Pengiriman Berhasil Dihapus!');        
    }
}