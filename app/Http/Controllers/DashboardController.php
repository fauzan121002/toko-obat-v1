<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Session;

use App\Kasir;
use App\KategoriObat;
use App\JenisObat;
use App\Obat;
use App\Supplier;
use App\AlatKesehatan;
use App\Suplemen;
use App\RiwayatPengiriman;
use App\Pengumuman;
use App\Transaksi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class DashboardController extends Controller
{
    public function login(){
        if(Session::has('email')){
            return redirect()->back();
        }else{
            return view('login');        
        }
    }

    public function dashboard(){
        if(Session::has('email')){
            $pengumumanget = pengumuman::orderBy('id_pengumuman','ASC')->first();
            $pengumuman = $pengumumanget->isi_pengumuman;       
            $total_transaksi = transaksi::count("id_transaksi");
            $uang_diterima = transaksi::max("uang_diterima");
            $jumlah_kasir = kasir::count('id_kasir');
            $transaksi_bulanan = transaksi::whereMonth('created_at',now()->format('m'))->count('id_transaksi');

            return view('dashboard',["pengumuman"=>$pengumuman])          
            ->with('total_transaksi',$total_transaksi)
            ->with('uang_diterima',$uang_diterima)
            ->with('jumlah_kasir',$jumlah_kasir)
            ->with('transaksi_bulanan',$transaksi_bulanan);
        }else{
            return redirect()->route('formlogin');
        }
    }

    public function drugs(){
        if(Session::has('email')){               
            $obat = obat::paginate(5);
            $kodeobat = obat::orderBy('kode_obat','DESC')->first();
            $kategoriobat = kategoriobat::orderBy('nama_kategoriobat','ASC')->get();
            $jenisobat = jenisobat::orderBy('nama_jenisobat','ASC')->get();
            $supplier = supplier::orderBy('nama_supplier','ASC')->where('status','Aktif')->get();

        	return view('feature/obat',['obat'=>$obat])->with(['kodeobat'=>$kodeobat])->with(['kategoriobat'=>$kategoriobat])->with(['jenisobat'=>$jenisobat])->with(['supplier'=>$supplier]);
        }else{
            return redirect()->route('formlogin');            
        }
    }


    public function medicalDevices(){
        if(Session::has('email')){                   
            $alatkesehatan = alatkesehatan::paginate(5);
            $kodealatkesehatan = alatkesehatan::orderBy('nama_alatkesehatan','DESC')->first();
            $supplier = supplier::orderBy('nama_supplier','ASC')->where('status','Aktif')->get();
        	return view('feature/alat-kesehatan',['alatkesehatan'=>$alatkesehatan])->with(['kodealatkesehatan'=>$kodealatkesehatan])->with(['supplier'=>$supplier]);
        }else{
            return redirect()->route('formlogin');               
        }
    }  

    public function drugTypes(){
        if(Session::has('email')){                
            $jenisobat = jenisobat::paginate(5); 
            $kodejenisobat = jenisobat::orderBy('id_jenisobat','DESC')->first();
        	return view('feature/jenis-obat',['jenisobat'=>$jenisobat])->with(['kodejenisobat'=>$kodejenisobat]);
        }else{
            return redirect()->route('formlogin');              
        }
    }    

    public function drugCategory(){
        if(Session::has('email')){               
            $kategoriobat = kategoriobat::paginate(5);
            $kodektrobt = kategoriobat::orderBy('kode_kategoriobat','DESC')->first();
        	return view('feature/kategori-obat',['kategoriobat'=>$kategoriobat])->with(['kodektrobt'=>$kodektrobt]);
        }else{
            return redirect()->route('formlogin');             
        }
    }    

    public function customer(){
        if(Session::has('email')){                
        	return view('feature/pelanggan');
        }else{
            return redirect()->route('formlogin');            
        }
    }    

    public function supplements(){
        if(Session::has('email')){               
            $suplemen = suplemen::paginate(5);
            $kodesuplemen = suplemen::orderBy('kode_suplemen','DESC')->first();
            $supplier = supplier::orderBy('nama_supplier')->where('status','Aktif')->get();
        	return view('feature/suplemen',['kodesuplemen'=>$kodesuplemen])->with(['suplemen'=>$suplemen])->with(['supplier'=>$supplier]);
        }else{
            return redirect()->route('formlogin');  
        }
    }    

    public function suppliers(){
        if(Session::has('email')){               
            $supplier = supplier::paginate(5);
            $kodesupplier = supplier::orderBy('kode_supplier','DESC')->first();
        	return view('feature/supplier')->with(['supplier'=>$supplier])->with(['kodesupplier'=>$kodesupplier]);
        }else{
            return redirect()->route('formlogin');            
        }
    }    
    
    public function shippingHistory(){
        if(Session::has('email')){                
            $riwayatpengiriman = riwayatpengiriman::orderBy('id_riwayatpengiriman','DESC')->paginate(10);
            return view('feature/riwayat-pengiriman-supplier',['riwayatpengiriman'=>$riwayatpengiriman]);
        }else{
            return redirect()->route('formlogin');             
        }
    }

    public function getModalCashierData(Request $request){
        if(Session::has('email')){           
            $kasir = kasir::where('id_kasir',$request->id)->get();
            return Response()->json($kasir);
        }else{
            return redirect()->route('formlogin');             
        }
    }

    public function getModalDrugCategory(Request $request){
        if(Session::has('email')){        
            $kategoriobat = kategoriobat::where('id_kategoriobat',$request->id)->get();
            return Response()->json($kategoriobat);
        }else{
            return redirect()->route('formlogin');           
        }
    }

    public function getModalDrugTypes(Request $request){
        if(Session::has('email')){        
            $jenisobat = jenisobat::where('id_jenisobat',$request->id)->get();
            return Response()->json($jenisobat);
        }else{
            return redirect()->route('formlogin');             
        }
    }

    public function getModalSupplier(Request $request){
        if(Session::has('email')){          
            $supplier = supplier::where('id_supplier',$request->id)->get();
            return Response()->json($supplier);
        }else{
            return redirect()->route('formlogin');            
        }
    }

    public function getModalDrug(Request $request){
        if(Session::has('email')){        
            $obat = obat::where('id_obat',$request->id)->get();
            $kategoriobat = kategoriobat::orderBy('nama_kategoriobat','ASC')->get();
            $jenisobat = jenisobat::orderBy('nama_jenisobat','ASC')->get();
            $supplier = supplier::orderBy('nama_supplier','ASC')->where('status','Aktif')->get();            
            return Response()->json(array('obat'=>$obat,'kategoriobat'=>$kategoriobat,'jenisobat'=>$jenisobat,'supplier'=>$supplier));
        }else{
            return redirect()->route('formlogin');             
        }
    }

    public function getModalDrugStock(Request $request){
        if(Session::has('email')){         
            $stokobat = obat::where('id_obat',$request->id)->get();
            return Response()->json($stokobat);
        }else{
            return redirect()->route('formlogin');
        }        
    }

    public function getModalMedicalDevices(Request $request){
        if(Session::has('email')){ 
            $alatkesehatan = alatkesehatan::where('id_alatkesehatan',$request->id)->get();
            return Response()->json($alatkesehatan);
        }else{
            return redirect()->route('formlogin');            
        }
    }

    public function getModalMedicalDevicesStock(Request $request){
        if(Session::has('email')){         
            $stokalatkesehatan = alatkesehatan::where('id_alatkesehatan',$request->id)->get();
            return Response()->json($stokalatkesehatan);
        }else{
            return redirect()->route('formlogin');            
        }
    }    

    public function getModalSupplementStock(Request $request){
        if(Session::has('email')){         
            $stoksuplemen = suplemen::where('id_suplemen',$request->id)->get();
            return Response()->json($stoksuplemen);
        }else{
            return redirect()->route('formlogin');            
        }
    }

    public function getModalSupplement(Request $request){
        if(Session::has('email')){         
            $suplemen = suplemen::where('id_suplemen',$request->id)->get();
            return Response()->json($suplemen);
        }else{
            return redirect()->route('formlogin');              
        }
    }

    public function getModalDrugTransaction(Request $request){
        if(Session::has('email')){       
          $kodetransaksi = transaksi::orderBy('kode_transaksi','DESC')->first(); 
          $kodetr = ($kodetransaksi !== null) ? $kodetransaksi->kode_transaksi : "SMT000";
          $noUrut2 = substr($kodetr,3);
          $noUrut2++;
          $char2 = "SMT";
          $kode_transaksi = $char2.sprintf('%03s',$noUrut2);

            $obat = obat::where('id_obat',$request->id)->get();
            return Response()->json(array('obat'=>$obat,'kode_transaksi'=>$kode_transaksi));
        }else{
            return redirect()->route('formlogin');
        }        
    }

    public function getModalSupplementTransaction(Request $request){
        if(Session::has('email')){       
          $kodetransaksi = transaksi::orderBy('kode_transaksi','DESC')->first(); 
          $kodetr = ($kodetransaksi !== null) ? $kodetransaksi->kode_transaksi : "SMT000";
          $noUrut2 = substr($kodetr,3);
          $noUrut2++;
          $char2 = "SMT";
          $kode_transaksi = $char2.sprintf('%03s',$noUrut2);

            $suplemen = suplemen::where('id_suplemen',$request->id)->get();
            return Response()->json(array('suplemen'=>$suplemen,'kode_transaksi'=>$kode_transaksi));
        }else{
            return redirect()->route('formlogin');
        }        
    }    

    public function getModalMedicalDevicesTransaction(Request $request){
        if(Session::has('email')){       
          $kodetransaksi = transaksi::orderBy('kode_transaksi','DESC')->first(); 
          $kodetr = ($kodetransaksi !== null) ? $kodetransaksi->kode_transaksi : "SMT000";
          $noUrut2 = substr($kodetr,3);
          $noUrut2++;
          $char2 = "SMT";
          $kode_transaksi = $char2.sprintf('%03s',$noUrut2);

            $alatkesehatan = alatkesehatan::where('id_alatkesehatan',$request->id)->get();
            return Response()->json(array('alatkesehatan'=>$alatkesehatan,'kode_transaksi'=>$kode_transaksi));
        }else{
            return redirect()->route('formlogin');
        }        
    } 

    public function transaction($id,$nama,Request $request){
        if(Session::has('email')){ 
            
            $this->validate($request,[
                "kode_transaksi"=>"required|min:1|max:20",
                "nama_pesanan"=>"required|min:1|max:30",
                "jumlah_pesanan"=>"required|numeric|digits_between:1,11",
                "uang_diterima"=>"required|numeric|digits_between:1,20"
            ]);


            $obat = obat::where(['id_obat'=>$id,'nama_obat'=>$request->nama_pesanan])->first();
            $suplemen = suplemen::where(['id_suplemen'=>$id,'nama_suplemen'=>$request->nama_pesanan])->first();
            $alatkesehatan = alatkesehatan::where(['id_alatkesehatan'=>$id,'nama_alatkesehatan'=>$request->nama_pesanan])->first();
            
            if ($nama === "obat"){
               $data = $obat;
               if($obat->stok-$request->jumlah_pesanan < 0){
                    dd("Stok tidak cukup");
                }
            }else if($nama === "suplemen"){
                $data = $suplemen;            
                if($suplemen->stok-$request->jumlah_pesanan < 0){
                    dd("Stok tidak cukup");
                }
            }else if($nama === "alatkesehatan"){
                $data = $alatkesehatan;        
                if($alatkesehatan->stok-$request->jumlah_pesanan < 0){
                    dd("Stok tidak cukup");
                }
            }else{
                return redirect('/dashboard');
            }
            
            try{
                DB::transaction(function () use ($request,$data){
                    transaksi::create([
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

                    $kasir = kasir::where('id_kasir',Session::get('id_kasir'))->first();
                    if($kasir){
                        $kasir->jumlah_transaksi = $kasir->jumlah_transaksi+1;
                        $kasir->save();               
                    }
                }); 
            }catch(\Illuminate\Database\QueryException $ex){
                return redirect()->back();
            }
        

            return view('feature/struk')->with('kode_transaksi',$request->kode_transaksi)->with('nama_pesanan',$request->nama_pesanan)->with('jumlah_pesanan',$request->jumlah_pesanan)->with('uang_diterima',$request->uang_diterima)->with('barang',$nama)->with('tanggal_transaksi',$data->updated_at);
                
              

        }else{
            return redirect()->route('formlogin');
        }
      


    }

    public function cart(Request $request){
        dd(Session::get("nama_kasir"));
    }

    public function customReceipt(){
        return view('feature/custom-struk');
    }

}
