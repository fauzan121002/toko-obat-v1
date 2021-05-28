<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Cashier;
use App\Drug;
use App\DrugCategory;
use App\DrugType;
use App\Supplier;
use App\ShippingHistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class DrugController extends Controller {
    public function index(){
        if(Session::has('email')){               
            $obat = Drug::paginate(5);
            $kodeobat = Drug::orderBy('kode_obat','DESC')->first();
            $kategoriobat = DrugCategory::orderBy('nama_kategoriobat','ASC')->get();
            $jenisobat = DrugType::orderBy('nama_jenisobat','ASC')->get();
            $supplier = Supplier::orderBy('nama_supplier','ASC')->where('status','Aktif')->get();

        	return view('feature/drug',['obat'=>$obat])->with(['kodeobat'=>$kodeobat])->with(['kategoriobat'=>$kategoriobat])->with(['jenisobat'=>$jenisobat])->with(['supplier'=>$supplier]);
        }else{
            return redirect()->route('login');            
        }
    }

    public function store(Request $request){
        
        $messages = [
            'required'=>'mohon isi :attribute',
            'image'=>':attribute hanya untuk gambar!',
            'numeric'=>':attribute harus berbentuk angka'
        ];

        $this->validate($request,[
            'foto_obat'=>'image|mimes:jpeg,png,jpg|max:2250',
            'nama_obat'=>'required|min:1|max:20',
            'fungsi_obat'=>'required|min:1|max:2000',
            'nama_kategoriobat'=>'required|min:1|max:30',
            'nama_jenisobat'=>'required|min:1|max:30',
            'nama_supplier'=>'required|min:1|max:30',
            'harga_obat'=>'required|numeric|digits_between:1,10'
        ],$messages);

        $file = $request->file('foto_obat');

        $tujuan = "foto_obat";

        $path = $file->move($tujuan,$file->getClientOriginalName());

        $supplier = Supplier::find($request->nama_supplier);

        Drug::create([
            "kode_obat"=>$request->kode_obat,
            "foto_obat"=>$path,
            "nama_obat"=>$request->nama_obat,
            "fungsi_obat"=>$request->fungsi_obat,
            "nama_kategoriobat"=>$request->nama_kategoriobat,
            "nama_jenisobat"=>$request->nama_jenisobat,
            "id_supplier"=>$request->nama_supplier,
            "nama_supplier"=>$supplier->nama_supplier,
            "harga_obat"=>$request->harga_obat,
            'stok'=>0,
            'stok_terjual'=>0,
            'total_penjualan'=>0,
            'total_pemasukan'=>0    
        ]);

        return redirect('/drug')->with('berhasilTambah','Data Berhasil Ditambahkan!');
    }

    public function getModalDrug(Request $request){
        if(Session::has('email')){        
            $obat = Drug::where('id_obat',$request->id)->get();
            $kategoriobat = DrugCategory::orderBy('nama_kategoriobat','ASC')->get();
            $jenisobat = DrugType::orderBy('nama_jenisobat','ASC')->get();
            $supplier = Supplier::orderBy('nama_supplier','ASC')->where('status','Aktif')->get();            
            return Response()->json(array('obat'=>$obat,'kategoriobat'=>$kategoriobat,'jenisobat'=>$jenisobat,'supplier'=>$supplier));
        }else{
            return redirect()->route('login');             
        }
    }

    public function getModalDrugStock(Request $request){
        if(Session::has('email')){         
            $stokobat = Drug::where('id_obat',$request->id)->get();
            return Response()->json($stokobat);
        }else{
            return redirect()->route('login');
        }        
    }

    public function getModalDrugTransaction(Request $request){
        if(Session::has('email')){       
          $kodetransaksi = Transaction::orderBy('kode_transaksi','DESC')->first(); 
          $kodetr = ($kodetransaksi !== null) ? $kodetransaksi->kode_transaksi : "SMT000";
          $noUrut2 = substr($kodetr,3);
          $noUrut2++;
          $char2 = "SMT";
          $kode_transaksi = $char2.sprintf('%03s',$noUrut2);

            $obat = Drug::where('id_obat',$request->id)->get();
            return Response()->json(array('obat'=>$obat,'kode_transaksi'=>$kode_transaksi));
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

        $kodepengiriman = ShippingHistory::orderBy('kode_pengiriman','DESC')->first(); 
        $kodetr = ($kodepengiriman !== null) ? $kodepengiriman->kode_pengiriman : "XSP000";
        $noUrut2 = substr($kodetr,3);
        $noUrut2++;
        $char2 = "XSP";
        $kode_pengiriman = $char2.sprintf('%03s',$noUrut2);        

        $supplier = Supplier::find($request->id_supplier);
        $obat = Drug::find($id);

        ShippingHistory::create([
            "id_supplier"=>$supplier->id_supplier,
            "kode_pengiriman"=>$kode_pengiriman,
            "nama_supplier"=>$supplier->nama_supplier,
            "barang_dikirim"=>$obat->nama_obat,
            "jumlah_dikirim"=>$request->stok
        ]);

        $jumlahpengiriman = $supplier->jumlah_pengiriman;
        $stokobat = $obat->stok;

        $supplier->jumlah_pengiriman = $jumlahpengiriman + 1;
        $obat->stok = $stokobat + $request->stok;
        $obat->save();
        $supplier->save();        

        return redirect('/drug')->with('berhasilTambahStok','Stok Berhasil Ditambahkan!');
    }

    public function update($id,Request $request){
        $messages = [
            'required'=>'mohon isi :attribute',
            'image'=>':attribute hanya untuk gambar!',
            'numeric'=>':attribute harus berbentuk angka'
        ];

        $this->validate($request,[
            'foto_obat'=>'image|mimes:jpeg,png,jpg|max:2250',
            'nama_obat'=>'required|min:1|max:20',
            'fungsi_obat'=>'required|min:1|max:2000',
            'nama_kategoriobat'=>'required|min:1|max:30',
            'nama_jenisobat'=>'required|min:1|max:30',
            'nama_supplier'=>'required|min:1|max:30',
            'harga_obat'=>'required|numeric|digits_between:1,10'
        ],$messages);

        $obat = Drug::find($id);

        if($request->file('foto_obat') != null){
            $foto = $request->file('foto_obat');

            $dir = 'foto_obat';

            $path = $foto->move($dir,$foto->getClientOriginalName());

            \File::delete($obat->foto_obat);

            $obat->foto_obat = $path;
        }

        $supplier = Supplier::find($request->nama_supplier);
        $obat->kode_obat = $request->kode_obat;
        $obat->nama_obat = $request->nama_obat;
        $obat->fungsi_obat = $request->fungsi_obat;
        $obat->nama_kategoriobat = $request->nama_kategoriobat;
        $obat->nama_jenisobat = $request->nama_jenisobat;
        $obat->id_supplier = $request->nama_supplier;
        $obat->nama_supplier = $supplier->nama_supplier;
        $obat->harga_obat = $request->harga_obat;

        $obat->save();

        return redirect('/drug')->with('berhasilUbah','Data Berhasil Diubah!');
    }

    public function destroy($id){
        $hapusFileFotoObat = Drug::where('id_obat',$id)->first();
        \File::delete($hapusFileFotoObat->foto_obat);

        Drug::find($id)->delete();

       return redirect('/drug')->with('berhasilHapus','Data Berhasil Dihapus!');
    }
}