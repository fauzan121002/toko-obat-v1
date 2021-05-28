<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kasir;
use App\KategoriObat;
use App\JenisObat;
use App\Obat;
use App\Supplier;
use App\AlatKesehatan;
use App\Suplemen;
use App\RiwayatPengiriman;
use App\Pengumuman;
use Illuminate\Support\Facades\Hash;
use File;

class FeatureController extends Controller
{
    public function tambahkategoriobat(Request $request){
        $messages = [
            'required'=>'mohon isi :attribute'
        ];
        $this->validate($request,[
            "nama_kategoriobat"=>"required|min:1|max:30",
            "deskripsi_kategoriobat"=>"required|min:1|max:2000"
        ],$messages);

        kategoriobat::create([
            'kode_kategoriobat'=>$request->kode_kategoriobat,
            'nama_kategoriobat'=>$request->nama_kategoriobat,
            'deskripsi_kategoriobat'=>$request->deskripsi_kategoriobat
        ]);

        return redirect('/kategoriobat')->with('berhasilTambah','Data Berhasil Ditambahkan!');
    }

    public function ubahkategoriobat($id,Request $request){
        
        $messages = [
            'required'=>'mohon isi :attribute'
        ];
        $this->validate($request,[
            "nama_kategoriobat"=>"required|min:1|max:30",
            "deskripsi_kategoriobat"=>"required|min:1|max:2000"
        ],$messages);

        $kategoriobat = kategoriobat::find($id);
        $kategoriobat->nama_kategoriobat = $request->nama_kategoriobat;
        $kategoriobat->deskripsi_kategoriobat = $request->deskripsi_kategoriobat;
        $kategoriobat->save();

        return redirect('/kategoriobat')->with('berhasilUbah','Data Berhasil Diubah!');
    }

    public function hapuskategoriobat($id){
        kategoriobat::where('id_kategoriobat',$id)->delete();

        return redirect('/kategoriobat')->with('berhasilHapus','Data Berhasil Dihapus!');
    }

    public function tambahjenisobat(Request $request){
        
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "nama_jenisobat"=>"required|min:1|max:20",
            "deskripsi_jenisobat"=>"required|min:1|max:2000"
        ],$messages);

        jenisobat::create([
            "kode_jenisobat"=>$request->kode_jenisobat,
            "nama_jenisobat"=>$request->nama_jenisobat,
            "deskripsi_jenisobat"=>$request->deskripsi_jenisobat
        ]);

        return redirect('/jenisobat')->with('berhasilTambah','Data Berhasil Ditambahkan!');
    }

    public function ubahjenisobat($id,Request $request){

        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "nama_jenisobat"=>"required|min:1|max:20",
            "deskripsi_jenisobat"=>"required|min:1|max:2000"
        ],$messages);

        $jenisobat = jenisobat::find($id);

        $jenisobat->nama_jenisobat = $request->nama_jenisobat;
        $jenisobat->deskripsi_jenisobat = $request->deskripsi_jenisobat;

        $jenisobat->save();

        return redirect('/jenisobat')->with('berhasilUbah','Data Berhasil Diubah!');
    }

    public function hapusjenisobat($id){
        jenisobat::find($id)->delete();

        return redirect('/jenisobat')->with('berhasilHapus','Data Berhasil Dihapus!');
    }

    public function tambahobat(Request $request){
        
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

        $supplier = supplier::find($request->nama_supplier);

        obat::create([
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

        return redirect('/obat')->with('berhasilTambah','Data Berhasil Ditambahkan!');
    }

    public function tambahstokobat($id,Request $request){
        $message = [
            "required"=>"mohon isi :attribute",
            "numeric"=>"data harus berupa angka!"
        ];
        $this->validate($request,[
            "stok"=>"required|numeric|digits_between:1,11"
        ],$message);

        $kodepengiriman = riwayatpengiriman::orderBy('kode_pengiriman','DESC')->first(); 
        $kodetr = ($kodepengiriman !== null) ? $kodepengiriman->kode_pengiriman : "XSP000";
        $noUrut2 = substr($kodetr,3);
        $noUrut2++;
        $char2 = "XSP";
        $kode_pengiriman = $char2.sprintf('%03s',$noUrut2);        

        $supplier = supplier::find($request->id_supplier);
        $obat = obat::find($id);

        riwayatpengiriman::create([
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

        return redirect('/obat')->with('berhasilTambahStok','Stok Berhasil Ditambahkan!');
    }

    public function ubahobat($id,Request $request){
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

        $obat = obat::find($id);

        if($request->file('foto_obat') != null){
            $foto = $request->file('foto_obat');

            $dir = 'foto_obat';

            $path = $foto->move($dir,$foto->getClientOriginalName());

            File::delete($obat->foto_obat);

            $obat->foto_obat = $path;
        }

        $supplier = supplier::find($request->nama_supplier);
        $obat->kode_obat = $request->kode_obat;
        $obat->nama_obat = $request->nama_obat;
        $obat->fungsi_obat = $request->fungsi_obat;
        $obat->nama_kategoriobat = $request->nama_kategoriobat;
        $obat->nama_jenisobat = $request->nama_jenisobat;
        $obat->id_supplier = $request->nama_supplier;
        $obat->nama_supplier = $supplier->nama_supplier;
        $obat->harga_obat = $request->harga_obat;

        $obat->save();

        return redirect('/obat')->with('berhasilUbah','Data Berhasil Diubah!');
    }

    public function hapusobat($id){
        $hapusFileFotoObat = obat::where('id_obat',$id)->first();
        File::delete($hapusFileFotoObat->foto_obat);

        obat::find($id)->delete();

       return redirect('/obat')->with('berhasilHapus','Data Berhasil Dihapus!');
    }

    public function tambahsupplier(Request $request){
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "nama_supplier"=>"required|min:1|max:30",
            "deskripsi_supplier"=>"required|min:1|max:2000"
        ],$messages);

        supplier::create([
            "kode_supplier"=>$request->kode_supplier,
            "nama_supplier"=>$request->nama_supplier,
            "deskripsi_supplier"=>$request->deskripsi_supplier,
            "status"=>"Aktif",
            "jumlah_pengiriman"=>0
        ]);

        return redirect('/supplier')->with('berhasilTambah','Data Berhasil Ditambahkan!');
    }

    public function ubahsupplier($id,Request $request){
        $messages = [
            "required"=>"mohon isi :attribute"
        ];

        $this->validate($request,[
            "nama_supplier"=>"required|min:1|max:30",
            "deskripsi_supplier"=>"required|min:1|max:2000",
            "status"=>"required|min:1|max:11"
        ],$messages);

        $supplier = supplier::find($id);

        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->deskripsi_supplier = $request->deskripsi_supplier;
        $supplier->status = $request->status;

        $supplier->save();

        return redirect('/supplier')->with('berhasilUbah','Data Berhasil Diubahkan!');

    }

    public function hapussupplier($id){
        supplier::where('id_supplier',$id)->delete();

        return redirect('/supplier')->with('berhasilHapus','Data Berhasil Dihapus!');
    }

    public function tambahalatkesehatan(Request $request){
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

        $supplier = supplier::find($request->nama_supplier);

        alatkesehatan::create([
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

        return redirect('/alatkesehatan')->with('berhasilTambah','Data Berhasil Ditambahkan!');
    }

    public function tambahstokalatkesehatan($id,Request $request){

        $message = [
            "required"=>"mohon isi :attribute",
            "numeric"=>"data harus berupa angka!"
        ];
        $this->validate($request,[
            "stok"=>"required|numeric|digits_between:1,11"
        ],$message);
                
        $supplier = supplier::find($request->id_supplier);
        $alatkesehatan = alatkesehatan::find($id);

        $jumlahpengiriman = $supplier->jumlah_pengiriman;
        $stokalatkesehatan = $alatkesehatan->stok;

        $supplier->jumlah_pengiriman = $jumlahpengiriman + 1;
        $alatkesehatan->stok = $stokalatkesehatan + $request->stok;
        $alatkesehatan->save();
        $supplier->save();

        return redirect('/alatkesehatan')->with('berhasilTambahStok','Stok Berhasil Ditambahkan!');
    }    

    public function ubahalatkesehatan($id,Request $request){
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

        $alatkesehatan = alatkesehatan::find($id);
        
        if($request->file('foto_alatkesehatan') != null){
            $file = $request->file('foto_alatkesehatan');
            
            $dir = "foto_alatkesehatan";
            
            $path = $file->move($dir,$file->getClientOriginalName());
            
            File::delete($alatkesehatan->foto_alatkesehatan);            
            
            $alatkesehatan->foto_alatkesehatan = $path;
        }          

        $supplier = supplier::find($request->nama_supplier);

        $alatkesehatan->nama_alatkesehatan = $request->nama_alatkesehatan;
        $alatkesehatan->fungsi_alatkesehatan = $request->fungsi_alatkesehatan;
        $alatkesehatan->id_supplier = $request->nama_supplier;
        $alatkesehatan->nama_supplier = $supplier->nama_supplier;
        $alatkesehatan->harga_alatkesehatan = $request->harga_alatkesehatan;

        $alatkesehatan->save();

        return redirect('/alatkesehatan')->with('berhasilUbah','Data Berhasil Diubah!');
    }

    public function hapusalatkesehatan($id){
        $alatkesehatan = alatkesehatan::find($id);
        File::delete($alatkesehatan->foto_alatkesehatan);

        $alatkesehatan->delete();
        return redirect('/alatkesehatan')->with('berhasilHapus','Data Berhasil Dihapus!');
    }

    public function tambahsuplemen(Request $request){
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

        $supplier = supplier::find($request->nama_supplier);

        suplemen::create([
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

        return redirect('/suplemen')->with('berhasilTambah','Data Berhasil Ditambahkan!');   
    }

    public function tambahstoksuplemen($id,Request $request){
        $message = [
            "required"=>"mohon isi :attribute",
            "numeric"=>"data harus berupa angka!"
        ];
        $this->validate($request,[
            "stok"=>"required|numeric|digits_between:1,11"
        ],$message);

        $supplier = supplier::find($request->id_supplier);
        $suplemen = suplemen::find($id);

        $jumlahpengiriman = $supplier->jumlah_pengiriman;
        $stoksuplemen = $suplemen->stok;

        $supplier->jumlah_pengiriman = $jumlahpengiriman + 1;
        $suplemen->stok = $stoksuplemen + $request->stok;
        $suplemen->save();
        $supplier->save();

        return redirect('/suplemen')->with('berhasilTambahStok','Stok Berhasil Ditambahkan!');
    }     

    public function ubahsuplemen($id,Request $request){
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

        $suplemen = suplemen::find($id);
        
        if($request->file('foto_suplemen') != null){
            $file = $request->file('foto_suplemen');
            
            $dir = "foto_suplemen";

            $path = $file->move($dir,$file->getClientOriginalName());
            
            File::delete($suplemen->foto_suplemen);            
            
            $suplemen->foto_suplemen = $path;
        }          

        $supplier = supplier::find($request->nama_supplier);

        $suplemen->nama_suplemen = $request->nama_suplemen;
        $suplemen->fungsi_suplemen = $request->fungsi_suplemen;
        $suplemen->id_supplier = $request->nama_supplier;
        $suplemen->nama_supplier = $supplier->nama_supplier;
        $suplemen->harga_suplemen = $request->harga_suplemen;

        $suplemen->save(); 

        return redirect('/suplemen')->with('berhasilUbah','Data Berhasil Diubah!');
    }

    public function hapussuplemen($id){
        $suplemen = suplemen::find($id);
        File::delete($suplemen->foto_suplemen);

        $suplemen->delete();
        return redirect('/suplemen')->with('berhasilHapus','Data Berhasil Dihapus!');
    }

    public function ubahpengumuman(Request $request){
        $message = [
            "required"=>"mohon isi atribut :attribute"
        ];

        $this->validate($request,[
            "isi_pengumuman"=>"required|min:1|max:3000"
        ],$message);

        $pengumuman = pengumuman::find(1);
        $pengumuman->isi_pengumuman = $request->isi_pengumuman;
        $pengumuman->save();

        return redirect('/dashboard')->with('berhasilUbah','Pengumuman Berhasil Diubah!');
    }

    public function hapusriwayatpengiriman($id){
        riwayatpengiriman::find($id)->delete();

        return redirect('/riwayatpengiriman')->with('berhasilHapus','Riwayat Pengiriman Berhasil Dihapus!');        
    }


}
