<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cashier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Response;

class CashierController extends Controller {
    public function index(){   
        if(Session::has('email')){
            if (session('level') == 'admin' || session('level') == 'developer'){        
                $kasir = Cashier::paginate(5);
                $kodeksr = Cashier::orderBy('kode_kasir','DESC')->first();
                return view('feature/cashier',['kasir'=>$kasir])->with(['kodeksr'=>$kodeksr]);
            }else{
                return redirect()->back();
            }       
        }else{
            return redirect()->route('login');
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
            $kasir = Cashier::where('email',$email)->first();

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


            Cashier::create([
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

           return redirect('/cashier')->with('itemAdded','Data Berhasil Ditambahkan!');            
        }
    }

    public function getModalCashierData(Request $request){
        if(Session::has('email')){           
            $kasir = Cashier::where('id_kasir',$request->id)->get();
            return Response()->json($kasir);
        }else{
            return redirect()->route('login');             
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



        $kasir = Cashier::find($id);
        if($request->file('foto_kasir') != null){

            $file = $request->file('foto_kasir');

            $dir = 'foto_kasir';
            
            $move = $file->move($dir,$file->getClientOriginalName());
            
            \File::delete($kasir->foto_kasir);
            
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
        return redirect('/cashier')->with('itemUpdated','Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapusFileFotoKasir = Cashier::where('id_kasir',$id)->first();
        \File::delete($hapusFileFotoKasir->foto_kasir);

        Cashier::where('id_kasir',$id)->delete();

        return redirect('/cashier')->with('itemDeleted','Data Berhasil Dihapus!');
    }
}