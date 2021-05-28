<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kasir;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Response;

class CashierController extends Controller {
    public function index(){   
        if(Session::has('email')){
            if (session('level') == 'admin' || session('level') == 'developer'){        
                $kasir = kasir::paginate(5);
                $kodeksr = kasir::orderBy('kode_kasir','DESC')->first();
                return view('feature/kasir',['kasir'=>$kasir])->with(['kodeksr'=>$kodeksr]);
            }else{
                return redirect()->back();
            }       
        }else{
            return redirect()->route('formlogin');
        }         
    }

    public function store(Request $request)
    {
        $message = [
            'required'=>'mohon isi :attribute',
            'file'=>':attribute gagal di upload.',
            'image'=>'data file wajib berupa gambar.',
            'mimes'=>'data :attribute harus berekstensi jpeg,png,jpg'
        ];

        $this->validate($request,[
             'foto_kasir'=>'required|image|mimes:jpeg,png,jpg',
             'nama_kasir'=>'required|string|min:1|max:40',
             'email'=>'required|email',             
             'password'=>'required|min:1|max:255',
             'jenis_kelamin'=>'required',
             'tanggal_lahir'=>'required',
             'pendidikan_terakhir'=>'required|min:1|max:30',
             'nomor_telepon'=>'required|numeric|digits_between:11,12',
             'alamat'=>'required|min:1|max:80'
        ],$message);
            $email = $request->email;
            $kasir = kasir::where('email',$email)->first();

            // $namakasir = [$request->nama_kasir,$request->nama_kasir];
            // array_push($namakasir,"Namanya");
            // $implode = implode(",",$namakasir);        

            $passwordEncrypt = Hash::make($request->password);
        if($kasir){
            return redirect()->with('ralatEmail','Email Tidak Boleh Sama!');
        }else{
            $file = $request->file('foto_kasir');

            $tujuan_upload = 'foto_kasir';
            $path = $file->move($tujuan_upload,$file->getClientOriginalName());


            kasir::create([
                'kode_kasir'=>$request->kode_kasir,
                'foto_kasir'=>$path,
                'nama_kasir'=>$request->nama_kasir,
                'email'=>$email,            
                'password'=>$passwordEncrypt,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'pendidikan_terakhir'=>$request->pendidikan_terakhir,
                'nomor_telepon'=>$request->nomor_telepon,
                'alamat'=>$request->alamat,
                'jumlah_transaksi'=>"0"
            ]);

           return redirect('/kasir')->with('berhasilTambah','Data Berhasil Ditambahkan!');            
        }


    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $messages = [
            'required'=>':attribute wajib diisi',
            'string'=>':attribute tidak perbolehkan input numerik',
            'digits_between'=>'Nomor Telepon Maksimal 11-12 angka!'
        ];

        $this->validate($request,[
             'foto_kasir'=>'image|mimes:jpeg,png,jpg',
             'nama_kasir'=>'required|string|min:1|max:40',
             'email'=>'required|email',             
             'password'=>'required|min:1|max:255',
             'jenis_kelamin'=>'required',
             'tanggal_lahir'=>'required',
             'pendidikan_terakhir'=>'required|min:1|max:30',
             'nomor_telepon'=>'required|numeric|digits_between:11,12',
             'alamat'=>'required|min:1|max:80'
        ],$messages);



        $kasir = kasir::find($id);
        if($request->file('foto_kasir') != null){

            $file = $request->file('foto_kasir');

            $dir = 'foto_kasir';
            
            $move = $file->move($dir,$file->getClientOriginalName());
            
            File::delete($kasir->foto_kasir);
            
            $kasir->foto_kasir = $move;

        }
        $kasir->nama_kasir = $request->nama_kasir;
        $kasir->email = $request->email;
        $kasir->jenis_kelamin = $request->jenis_kelamin;
        $kasir->tanggal_lahir = $request->tanggal_lahir;
        $kasir->pendidikan_terakhir = $request->pendidikan_terakhir;
        $kasir->nomor_telepon = $request->nomor_telepon;
        $kasir->alamat = $request->alamat;
        $kasir->save();
        return redirect('/kasir')->with('berhasilUbah','Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapusFileFotoKasir = kasir::where('id_kasir',$id)->first();
        File::delete($hapusFileFotoKasir->foto_kasir);

        kasir::where('id_kasir',$id)->delete();

        return redirect('/kasir')->with('berhasilHapus','Data Berhasil Dihapus!');
    }
}