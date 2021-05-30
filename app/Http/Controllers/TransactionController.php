<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Cashier;
use App\Drug;
use App\MedicalDevice;
use App\Supplement;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class TransactionController extends Controller {
    public function index(){
        $transaction = Transaction::select('kode_transaksi','nama_pesanan','jumlah_pesanan','uang_diterima','nama_kasir')->paginate(5);
        return view('feature/transaction-history', [ 'transaksi'=> $transaction ]);
    }

    public function store($id,$nama,Request $request){
        if(Session::has('email')){ 
            
            $this->validate($request,[
                "kode_transaksi"=>"required|min:1|max:20",
                "nama_pesanan"=>"required|min:1|max:30",
                "jumlah_pesanan"=>"required|numeric|digits_between:1,11",
                "uang_diterima"=>"required|numeric|digits_between:1,20"
            ]);

            $obat = Drug::where(['id_obat'=>$id,'nama_obat'=>$request->nama_pesanan])->first();
            $suplemen = Supplement::where(['id_suplemen'=>$id,'nama_suplemen'=>$request->nama_pesanan])->first();
            $alatkesehatan = MedicalDevice::where(['id_alatkesehatan'=>$id,'nama_alatkesehatan'=>$request->nama_pesanan])->first();
            
            if ($nama === "drug"){
               $data = $obat;
               if($obat->stok - $request->jumlah_pesanan < 0){
                    return redirect()->back()->withError("Stok tidak cukup");
                }
            }else if($nama === "supplement"){
                $data = $suplemen;            
                if($suplemen->stok - $request->jumlah_pesanan < 0){
                    return redirect()->back()->withError("Stok tidak cukup");
                }
            }else if($nama === "medical-device"){
                $data = $alatkesehatan;        
                if($alatkesehatan->stok - $request->jumlah_pesanan < 0){
                    return redirect()->back()->withError("Stok tidak cukup");
                }
            }else{
                return redirect('/dashboard');
            }
            
            try{
                DB::transaction(function () use ($request,$data){
                    Transaction::create([
                        "kode_transaksi"=>$request->kode_transaksi,
                        "nama_pesanan"=>$request->nama_pesanan,
                        "jumlah_pesanan"=>$request->jumlah_pesanan,
                        "uang_diterima"=>$request->uang_diterima,
                        "kode_kasir"=>Session::get("kode_kasir"),
                        "nama_kasir"=>Session::get("nama_kasir")
                    ]);

                    $data->stok = $data->stok-$request->jumlah_pesanan;
                    $data->stok_terjual = $data->stok_terjual+$request->jumlah_pesanan;
                    $data->total_penjualan = $data->total_penjualan+1;
                    $data->total_pemasukan = $data->total_pemasukan+$request->uang_diterima;
                    $data->save();

                    $kasir = Cashier::where('id_kasir',Session::get('id_kasir'))->first();
                    if($kasir){
                        $kasir->jumlah_transaksi = $kasir->jumlah_transaksi+1;
                        $kasir->save();               
                    }
                }); 
            }catch(\Illuminate\Database\QueryException $ex){
                return redirect()->back();
            }
        
            return view('feature/receipt')->with('kode_transaksi',$request->kode_transaksi)->with('nama_pesanan',$request->nama_pesanan)->with('jumlah_pesanan',$request->jumlah_pesanan)->with('uang_diterima',$request->uang_diterima)->with('barang',$nama)->with('tanggal_transaksi',$data->updated_at);
        }else{
            return redirect()->route('login');
        }
    }
}