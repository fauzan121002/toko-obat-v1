<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DrugCategory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class DrugCategoryController extends Controller {
    public function index(){
        if(Session::has('email')){               
            $kategoriobat = DrugCategory::paginate(5);
            $kodektrobt = DrugCategory::orderBy('kode_kategoriobat','DESC')->first();
        	return view('feature/drug-category',['kategoriobat'=>$kategoriobat])->with(['kodektrobt'=>$kodektrobt]);
        }else{
            return redirect()->route('login');             
        }
    }  

    public function store(Request $request){
        $messages = [
            'required'=>'mohon isi :attribute'
        ];
        $this->validate($request,[
            "nama_kategoriobat"=>"required|min:1|max:30",
            "deskripsi_kategoriobat"=>"required|min:1|max:2000"
        ],$messages);

        DrugCategory::create([
            'kode_kategoriobat'=>$request->kode_kategoriobat,
            'nama_kategoriobat'=>$request->nama_kategoriobat,
            'deskripsi_kategoriobat'=>$request->deskripsi_kategoriobat
        ]);

        return redirect('/drug-category')->with('itemAdded','Data Berhasil Ditambahkan!');
    }

    public function getModalDrugCategory(Request $request){
        if(Session::has('email')){        
            $kategoriobat = DrugCategory::where('id_kategoriobat',$request->id)->get();
            return Response()->json($kategoriobat);
        }else{
            return redirect()->route('login');           
        }
    }

    public function update($id,Request $request){
        
        $messages = [
            'required'=>'mohon isi :attribute'
        ];
        $this->validate($request,[
            "nama_kategoriobat"=>"required|min:1|max:30",
            "deskripsi_kategoriobat"=>"required|min:1|max:2000"
        ],$messages);

        $kategoriobat = DrugCategory::find($id);
        $kategoriobat->nama_kategoriobat = $request->nama_kategoriobat;
        $kategoriobat->deskripsi_kategoriobat = $request->deskripsi_kategoriobat;
        $kategoriobat->save();

        return redirect('/drug-category')->with('itemUpdated','Data Berhasil Diubah!');
    }

    public function destroy($id){
        DrugCategory::where('id_kategoriobat',$id)->delete();

        return redirect('/drug-category')->with('itemDeleted','Data Berhasil Dihapus!');
    }
}