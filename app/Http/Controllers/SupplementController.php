<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Supplement;
use App\Supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class SupplementController extends Controller {
    public function index(){
        if(Session::has('email')){               
            $suplemen = Supplement::paginate(5);
            $kodesuplemen = Supplement::orderBy('kode_suplemen','DESC')->first();
            $supplier = Supplier::orderBy('nama_supplier')->where('status','Aktif')->get();
        	return view('feature/supplement',['kodesuplemen'=>$kodesuplemen])->with(['suplemen'=>$suplemen])->with(['supplier'=>$supplier]);
        }else{
            return redirect()->route('login');  
        }
    }  
    public function store(Request $request){
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "foto_suplemen"=>"required|image|file|max:2250",
            "nama_suplemen"=>"required|min:1|max:30",
            "fungsi_suplemen"=>"required|min:1|max:2000",
            "nama_supplier"=>"required|min:1|max:30",
            "harga_suplemen"=>"required|numeric|digits_between:1,10"
        ],$messages);     

        if($request->file('foto_suplemen') != null){
            $file = $request->file('foto_suplemen');
            $dir = "foto_suplemen";
            $path = $file->move($dir,$file->getClientOriginalName());
        }   

        $supplier = Supplier::find($request->nama_supplier);

        Supplement::create([
            "kode_suplemen"=>$request->kode_suplemen,
            "foto_suplemen"=>$path,
            "nama_suplemen"=>$request->nama_suplemen,
            "fungsi_suplemen"=>$request->fungsi_suplemen,
            "id_supplier"=>$request->nama_supplier,
            "nama_supplier"=>$supplier->nama_supplier,
            "harga_suplemen"=>$request->harga_suplemen,
            "stok"=>0,
            "stok_terjual"=>0,
            "total_penjualan"=>0,
            "total_pemasukan"=>0
        ]);

        return redirect('/supplement')->with('berhasilTambah','Data Berhasil Ditambahkan!');   
    }

    public function getModalSupplement(Request $request){
        if(Session::has('email')){         
            $suplemen = Supplement::where('id_suplemen',$request->id)->get();
            return Response()->json($suplemen);
        }else{
            return redirect()->route('login');              
        }
    }

    public function getModalSupplementStock(Request $request){
        if(Session::has('email')){         
            $stoksuplemen = Supplement::where('id_suplemen',$request->id)->get();
            return Response()->json($stoksuplemen);
        }else{
            return redirect()->route('login');            
        }
    }

    public function getModalSupplementTransaction(Request $request){
        if(Session::has('email')){       
          $kodetransaksi = Transaction::orderBy('kode_transaksi','DESC')->first(); 
          $kodetr = ($kodetransaksi !== null) ? $kodetransaksi->kode_transaksi : "SMT000";
          $noUrut2 = substr($kodetr,3);
          $noUrut2++;
          $char2 = "SMT";
          $kode_transaksi = $char2.sprintf('%03s',$noUrut2);

            $suplemen = Supplement::where('id_suplemen',$request->id)->get();
            return Response()->json(array('suplemen'=>$suplemen,'kode_transaksi'=>$kode_transaksi));
        }else{
            return redirect()->route('login');
        }        
    }   

    public function updateStock($id,Request $request){
        $message = [
            "required"=>"mohon isi :attribute",
            "numeric"=>"data harus berupa angka!"
        ];
        $this->validate($request,[
            "stok"=>"required|numeric|digits_between:1,11"
        ],$message);

        $supplier = Supplier::find($request->id_supplier);
        $suplemen = Supplement::find($id);

        $jumlahpengiriman = $supplier->jumlah_pengiriman;
        $stoksuplemen = $suplemen->stok;

        $supplier->jumlah_pengiriman = $jumlahpengiriman + 1;
        $suplemen->stok = $stoksuplemen + $request->stok;
        $suplemen->save();
        $supplier->save();

        return redirect('/supplement')->with('berhasilTambahStok','Stok Berhasil Ditambahkan!');
    }     

    public function update($id,Request $request){
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "foto_suplemen"=>"image|file|max:2250",
            "nama_suplemen"=>"required|min:1|max:30",
            "fungsi_suplemen"=>"required|min:1|max:2000",
            "nama_supplier"=>"required|min:1|max:30",
            "harga_suplemen"=>"required|numeric|digits_between:1,10"
        ],$messages);

        $suplemen = Supplement::find($id);
        
        if($request->file('foto_suplemen') != null){
            $file = $request->file('foto_suplemen');
            
            $dir = "foto_suplemen";

            $path = $file->move($dir,$file->getClientOriginalName());
            
            \File::delete($suplemen->foto_suplemen);            
            
            $suplemen->foto_suplemen = $path;
        }          

        $supplier = Supplier::find($request->nama_supplier);

        $suplemen->nama_suplemen = $request->nama_suplemen;
        $suplemen->fungsi_suplemen = $request->fungsi_suplemen;
        $suplemen->id_supplier = $request->nama_supplier;
        $suplemen->nama_supplier = $supplier->nama_supplier;
        $suplemen->harga_suplemen = $request->harga_suplemen;

        $suplemen->save(); 

        return redirect('/supplement')->with('berhasilUbah','Data Berhasil Diubah!');
    }

    public function destroy($id){
        $suplemen = Supplement::find($id);
        \File::delete($suplemen->foto_suplemen);

        $suplemen->delete();
        return redirect('/supplement')->with('berhasilHapus','Data Berhasil Dihapus!');
    }
}