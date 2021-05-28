<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cashier;
use App\Notification;
use App\Transaction;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Response;

class DashboardController extends Controller
{
    public function login(){
        if(Session::has('email')){
            return redirect()->route('dashboard');
        }else{
            return view('login');        
        }
    }

    public function dashboard(){
        if(Session::has('email')){
            $pengumumanget = Notification::orderBy('id_pengumuman','ASC')->first();
            $pengumuman = $pengumumanget->isi_pengumuman;       
            $total_transaksi = Transaction::count("id_transaksi");
            $uang_diterima = Transaction::max("uang_diterima");
            $jumlah_kasir = Cashier::count('id_kasir');
            $transaksi_bulanan = Transaction::whereMonth('created_at',now()->format('m'))->count('id_transaksi');

            return view('dashboard',["pengumuman"=>$pengumuman])          
            ->with('total_transaksi',$total_transaksi)
            ->with('uang_diterima',$uang_diterima)
            ->with('jumlah_kasir',$jumlah_kasir)
            ->with('transaksi_bulanan',$transaksi_bulanan);
        }else{
            return redirect()->route('login');
        }
    }       
}
