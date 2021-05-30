<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\MedicalDevice;
use App\Supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class MedicalDeviceController extends Controller {
    public function index(){
        if(Session::has('email')){                   
            $alatkesehatan = MedicalDevice::paginate(5);
            $kodealatkesehatan = MedicalDevice::orderBy('nama_alatkesehatan','DESC')->first();
            $supplier = Supplier::orderBy('nama_supplier','ASC')->where('status','Aktif')->get();
        	return view('feature/medical-device',['alatkesehatan'=>$alatkesehatan])->with(['kodealatkesehatan'=>$kodealatkesehatan])->with(['supplier'=>$supplier]);
        }else{
            return redirect()->route('login');               
        }
    }  

    public function store(Request $request){
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "foto_alatkesehatan"=>"required|image|file|max:2250",
            "nama_alatkesehatan"=>"required|min:1|max:30",
            "fungsi_alatkesehatan"=>"required|min:1|max:2000",
            "nama_supplier"=>"required|min:1|max:30",
            "harga_alatkesehatan"=>"required|numeric|digits_between:1,10"
        ],$messages);

        if($request->file('foto_alatkesehatan') != null){
            $file = $request->file('foto_alatkesehatan');
            $dir = "foto_alatkesehatan";
            $path = $file->move($dir,$file->getClientOriginalName());
        }   

        $supplier = Supplier::find($request->nama_supplier);

        MedicalDevice::create([
            "kode_alatkesehatan"=>$request->kode_alatkesehatan,
            "foto_alatkesehatan"=>$path,
            "nama_alatkesehatan"=>$request->nama_alatkesehatan,
            "fungsi_alatkesehatan"=>$request->fungsi_alatkesehatan,
            "id_supplier"=>$request->nama_supplier,
            "nama_supplier"=>$supplier->nama_supplier,
            "harga_alatkesehatan"=>$request->harga_alatkesehatan,
            "stok"=>0,
            "stok_terjual"=>0,
            "total_penjualan"=>0,
            "total_pemasukan"=>0
        ]);

        return redirect('/medical-device')->with('itemAdded','Data Berhasil Ditambahkan!');
    }

    public function getModalMedicalDevice(Request $request){
        if(Session::has('email')){ 
            $alatkesehatan = MedicalDevice::where('id_alatkesehatan',$request->id)->get();
            return Response()->json($alatkesehatan);
        }else{
            return redirect()->route('login');            
        }
    }

    public function getModalMedicalDeviceStock(Request $request){
        if(Session::has('email')){         
            $stokalatkesehatan = MedicalDevice::where('id_alatkesehatan',$request->id)->get();
            return Response()->json($stokalatkesehatan);
        }else{
            return redirect()->route('login');            
        }
    }  

    public function getModalMedicalDeviceTransaction(Request $request){
        if(Session::has('email')){       
          $kodetransaksi = Transaction::orderBy('kode_transaksi','DESC')->first(); 
          $kodetr = ($kodetransaksi !== null) ? $kodetransaksi->kode_transaksi : "SMT000";
          $noUrut2 = substr($kodetr,3);
          $noUrut2++;
          $char2 = "SMT";
          $kode_transaksi = $char2.sprintf('%03s',$noUrut2);

            $alatkesehatan = MedicalDevice::where('id_alatkesehatan',$request->id)->get();
            return Response()->json(array('alatkesehatan'=>$alatkesehatan,'kode_transaksi'=>$kode_transaksi));
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
        $alatkesehatan = MedicalDevice::find($id);

        $jumlahpengiriman = $supplier->jumlah_pengiriman;
        $stokalatkesehatan = $alatkesehatan->stok;

        $supplier->jumlah_pengiriman = $jumlahpengiriman + 1;
        $alatkesehatan->stok = $stokalatkesehatan + $request->stok;
        $alatkesehatan->save();
        $supplier->save();

        return redirect('/medical-device')->with('stockUpdated','Stok Berhasil Ditambahkan!');
    }    

    public function update($id,Request $request){
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "foto_alatkesehatan"=>"image|file|max:2250",
            "nama_alatkesehatan"=>"required|min:1|max:30",
            "fungsi_alatkesehatan"=>"required|min:1|max:2000",
            "nama_supplier"=>"required|min:1|max:30",
            "harga_alatkesehatan"=>"required|numeric|digits_between:1,10"
        ],$messages);

        $alatkesehatan = MedicalDevice::find($id);
        
        if($request->file('foto_alatkesehatan') != null){
            $file = $request->file('foto_alatkesehatan');
            
            $dir = "foto_alatkesehatan";
            
            $path = $file->move($dir,$file->getClientOriginalName());
            
            \File::delete($alatkesehatan->foto_alatkesehatan);            
            
            $alatkesehatan->foto_alatkesehatan = $path;
        }          

        $supplier = Supplier::find($request->nama_supplier);

        $alatkesehatan->nama_alatkesehatan = $request->nama_alatkesehatan;
        $alatkesehatan->fungsi_alatkesehatan = $request->fungsi_alatkesehatan;
        $alatkesehatan->id_supplier = $request->nama_supplier;
        $alatkesehatan->nama_supplier = $supplier->nama_supplier;
        $alatkesehatan->harga_alatkesehatan = $request->harga_alatkesehatan;

        $alatkesehatan->save();

        return redirect('/medical-device')->with('itemUpdated','Data Berhasil Diubah!');
    }

    public function destroy($id){
        $alatkesehatan = MedicalDevice::find($id);
        \File::delete($alatkesehatan->foto_alatkesehatan);

        $alatkesehatan->delete();
        return redirect('/medical-device')->with('itemDeleted','Data Berhasil Dihapus!');
    }
}