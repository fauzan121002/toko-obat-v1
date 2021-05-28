<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drug;
use App\DrugCategory;
use App\DrugType;
use App\Supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class DrugTypeController extends Controller {
    public function index(){
        if(Session::has('email')){                
            $jenisobat = DrugType::paginate(5); 
            $kodejenisobat = DrugType::orderBy('id_jenisobat','DESC')->first();
        	return view('feature/drug-type',['jenisobat'=>$jenisobat])->with(['kodejenisobat'=>$kodejenisobat]);
        }else{
            return redirect()->route('login');              
        }
    }    

    public function store(Request $request){
        
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "nama_jenisobat"=>"required|min:1|max:20",
            "deskripsi_jenisobat"=>"required|min:1|max:2000"
        ],$messages);

        DrugType::create([
            "kode_jenisobat"=>$request->kode_jenisobat,
            "nama_jenisobat"=>$request->nama_jenisobat,
            "deskripsi_jenisobat"=>$request->deskripsi_jenisobat
        ]);

        return redirect('/drug-type')->with('itemAdded','Data Berhasil Ditambahkan!');
    }

    public function getModalDrugTypes(Request $request){
        if(Session::has('email')){        
            $jenisobat = DrugType::where('id_jenisobat',$request->id)->get();
            return Response()->json($jenisobat);
        }else{
            return redirect()->route('login');             
        }
    }

    public function update($id,Request $request){

        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "nama_jenisobat"=>"required|min:1|max:20",
            "deskripsi_jenisobat"=>"required|min:1|max:2000"
        ],$messages);

        $jenisobat = DrugType::find($id);

        $jenisobat->nama_jenisobat = $request->nama_jenisobat;
        $jenisobat->deskripsi_jenisobat = $request->deskripsi_jenisobat;

        $jenisobat->save();

        return redirect('/drug-type')->with('itemUpdated','Data Berhasil Diubah!');
    }

    public function destroy($id){
        DrugType::find($id)->delete();

        return redirect('/drug-type')->with('itemDeleted','Data Berhasil Dihapus!');
    }
}