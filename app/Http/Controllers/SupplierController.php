<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class SupplierController extends Controller {
    public function index(){
        if(Session::has('email')){               
            $supplier = Supplier::paginate(5);
            $kodesupplier = Supplier::orderBy('kode_supplier','DESC')->first();
        	return view('feature/supplier')->with(['supplier'=>$supplier])->with(['kodesupplier'=>$kodesupplier]);
        }else{
            return redirect()->route('login');            
        }
    }   

    public function store(Request $request){
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "nama_supplier"=>"required|min:1|max:30",
            "deskripsi_supplier"=>"required|min:1|max:2000"
        ],$messages);

        Supplier::create([
            "kode_supplier"=>$request->kode_supplier,
            "nama_supplier"=>$request->nama_supplier,
            "deskripsi_supplier"=>$request->deskripsi_supplier,
            "status"=>"Aktif",
            "jumlah_pengiriman"=>0
        ]);

        return redirect('/supplier')->with('itemAdded','Data Berhasil Ditambahkan!');
    }

    public function getModalSupplier(Request $request){
        if(Session::has('email')){          
            $supplier = Supplier::where('id_supplier',$request->id)->get();
            return Response()->json($supplier);
        }else{
            return redirect()->route('login');            
        }
    }

    public function update($id,Request $request){
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "nama_supplier"=>"required|min:1|max:30",
            "deskripsi_supplier"=>"required|min:1|max:2000",
            "status"=>"required|min:1|max:11"
        ],$messages);

        $supplier = Supplier::find($id);

        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->deskripsi_supplier = $request->deskripsi_supplier;
        $supplier->status = $request->status;

        $supplier->save();

        return redirect('/supplier')->with('itemUpdated','Data Berhasil Diubahkan!');

    }

    public function destroy($id){
        Supplier::where('id_supplier',$id)->delete();

        return redirect('/supplier')->with('itemDeleted','Data Berhasil Dihapus!');
    }
}