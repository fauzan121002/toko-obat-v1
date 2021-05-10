
@extends('layouts.main-app')

@section('judul','Obat')


@section('content')

 <div class="loadingmodal"></div>
 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
     <li class="breadcrumb-item active ml-auto" aria-current="page">   
      <a class="btn btn-outline-light" href="{{ route('laporan.obat') }}" target="_blank"><i class="fas fa-print text-white"></i></a>  
      <button class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal">{{ Session::get('obat') }}+</button></form>
    </ol>
  </nav>

<div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Tulis Nama Obat..." aria-label="Tulis Nama Obat..." aria-describedby="button-addon2">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari Obat!</button>
  </div>
</div>


<div class="mb-3">{{ $obat->links('vendor.pagination.bootstrap-4') }}</div>
<div class="table-responsive">
<table class="table">
  <thead class="table-bordered">
      <tr>
        <th scope="col">Kode Obat</th>
        <th scope="col">Foto Obat</th>
        <th scope="col">Nama Obat</th>
        <th scope="col">Detail</th>
        <th scope="col">Checkout</th>
        <th scope="col">Tambah Stok</th>
      </tr>
  </thead>
  <tbody>
    @php
        $kodeob = ($kodeobat !== null) ? $kodeobat->kode_obat : "OBT000";
        $noUrut = substr($kodeob,3);
        $noUrut++;
        $char = "OBT";
        $kode = $char.sprintf("%03s",$noUrut);
    @endphp
    @foreach($obat as $data)
      <tr>
        <td>{{ $data->kode_obat }}</td>
        <td><img src="{{ $data->foto_obat }}" alt="{{ $data->foto_obat }}" width="100" height="100" class="img-fluid"></td>
        <td>{{ $data->nama_obat }}</td> 
        <td><button class="btn btn-outline-primary detail" data-id="{{ $data->id_obat }}">Lihat Detail</button></td>
        <td><button class="btn btn-outline-success detailtransaksi" data-id="{{ $data->id_obat }}">Mulai Transaksi</button></td>
        <td><button class="btn btn-outline-secondary tambahstok" data-id="{{ $data->id_obat }}">Tambah Stok</button></td>
      </tr>
    @endforeach
  </tbody>
</table>
</div>
<div class="mt-3">{{ $obat->links('vendor.pagination.bootstrap-4') }}</div>

 <div class="modaldetail">
   
 </div>
  <div class="modal fade mx-auto" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg mr-auto" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>

                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-prevent" action="/obat/tambahobat" method="POST" enctype="multipart/form-data">
                      @csrf
                      Kode Obat <input type="text" class="form-control" name="kode_obat" value="{{ $kode }}" readonly="">
                      Foto Obat <input type="file" name="foto_obat" class="h-auto form-control"> 
                      Nama Obat <input type="text" class="form-control" name="nama_obat">
                      Fungsi Obat <textarea name="fungsi_obat" class="form-control" cols="30" rows="10"></textarea>
                      Kategori Obat 
                      <select name="nama_kategoriobat" class="form-control">
                      	<option disabled selected value=""> -- select an option -- </option>
                      @foreach ($kategoriobat as $data)
                      	<option value="{{ $data->nama_kategoriobat }}">{{ $data->nama_kategoriobat }}</option>
                      @endforeach              	
                      </select>
                      Jenis Obat
                      <select name="nama_jenisobat" class="form-control">
                      	<option disabled selected value=""> -- select an option -- </option>
                      @foreach ($jenisobat as $data)
                      	<option value="{{ $data->nama_jenisobat }}">{{ $data->nama_jenisobat }}</option>
                      @endforeach	              	
                      </select> 
          					  Supplier 
          					  <select name="nama_supplier" class="form-control">
          					    <option disabled selected value=""> -- select an option -- </option>
          					  @foreach($supplier as $data)
                        <option value="{{ $data->id_supplier }}">{{ $data->nama_supplier }}</option>
                      @endforeach
                      </select>
          					  Harga Obat <input type="number" class="form-control" name="harga_obat">
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary button-prevent">Tambah!</button>
                      </form>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>  
</div>


 <div class="tambahstokmodal">
   
 </div>

 <div class="detailtransaksimodal">
   
 </div>

@endsection

@section('footer')
@parent


<script>
  $(document).ready(function(){

   

    function prevent(){
      $(".form-prevent").on("submit",function(){

        $(".button-prevent").attr('disabled','true');
          
      });    
    }

    $(".detailtransaksi").on('click',function(){

      $(".loadingmodal").append('Loading...');      

      $.ajax({
        type:'GET',
        url:'/obat/detailtransaksi?id='+$(this).data("id"),
        success: function(result){
          var data = result.obat[0];

          $(".detailtransaksimodal").append(`
                    <div class='modal fade' id=modalDetailTransaksi tabindex=-1 role=dialog aria-labelledby=exampleModalLabell aria-hidden=true>
                        <div class='modal-dialog modal-lg' role='document'>
                          <div class=modal-content>
                            <div class=modal-header>
                              <h5 class=modal-title id=exampleModalLabel>${data.nama_obat}</h5>
                              <button type=button class=close data-dismiss=modal aria-label=Close>
                                <span aria-hidden=true>&times;</span>
                              </button>
                            </div>
                            <div class=modal-body>
                              <div class=container>
                                <div class=row>
                                  <div class=col>

                                    <div class=row>
                                        <div class=col-md-6>
                                            <img src='${data.foto_obat}' class='img-fluid w-100 d-block' alt='${data.foto_obat}'>
                                        </div>
                                        <div class=col-md-6>
                                        <form action='/transaksi/${data.id_obat}/obat' method='POST'>
                                            @csrf
                                            Kode Pesanan
                                            <input type=text name=kode_transaksi value='${result.kode_transaksi}' class=form-control readonly>
                                            Nama Pesanan
                                            <input type=text name=nama_pesanan value='${data.nama_obat}' class=form-control readonly>                                            
                                            Jumlah Pesanan
                                            <input type='number' name='jumlah_pesanan' class='form-control jumlah_pesanan' required>
                                            Total Harga
                                            <input type='number' name='uang_diterima' class='form-control total_harga' required readonly value='0'>
                                            <hr/>
                                            <button type='submit' class='btn bg-success mt-3 text-white'><span class='mr-1'><i class='fas fa-cash-register'></i></span>Checkout</button>
                                            <button type='button' class='btn btn-secondary mt-3 text-white' data-dismiss='modal'>Tutup</button>
                                            </form>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class='modal-footer'>
                                &copy Smartpharmacy                                                         
                            </div>
                          </div>
                        </div>
                      </div>              
          `);

          $(".jumlah_pesanan").on('input',function(){
            var jumlah_pesanan = $(".jumlah_pesanan").val();
            var total_harga = data.harga_obat * jumlah_pesanan;
            $(".total_harga").val(`${total_harga}`).change();
          });

          
          $(".loadingmodal").html('');
          $("#modalDetailTransaksi").modal("show");
           $("#modalDetailTransaksi").on("hide.bs.modal", function () {
              $(".detailtransaksimodal").html('');
              $(".modal-backdrop").remove();
              $("#modalDetailTransaksi").modal("hide");
           });        
        }
      });
    });

/////////////////////////////////////////////////////////

    $(".tambahstok").on('click',function(){

      $(".loadingmodal").append('Loading...');

      $.ajax({
        type:'GET',
        url:'/obat/detailtambahstokobat?id='+$(this).data("id"),
        success: function(result){
          var data = result[0];
          var tambahstokmodal = `
          <div class='modal fade' id='modalTambahStok' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel2' aria-hidden='true'>
                        <div class='modal-dialog modal-lg' role='document'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='exampleModalLabel'>${data.nama_obat}</h5>
                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                              <div class='container'>
                                <div class='row'>
                                  <div class='col'>

                                    <form class='form-prevent' action='/obat/tambahstokobat/${data.id_obat}' method='POST'>
                                      @method('PUT')
                                      @csrf
                                      <input type='hidden' value='${data.id_supplier}' name='id_supplier'>
                                      Tambah Stok Obat <input type='number' name='stok' class='form-control mb-3' required>
                                      <button class='btn btn-primary button-prevent' type='submit'>Tambah</button>
                                      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
                                    </form>

                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class='modal-footer'>
                              &copy Smartpharmacy 
                            </div>
                          </div>
                        </div>
                      </div>`;

          $(".tambahstokmodal").append(tambahstokmodal);
          $(".loadingmodal").html('');
          $("#modalTambahStok").modal("show");
          $("#modalTambahStok").on("hide.bs.modal", function () {
              $(".tambahstokmodal").html('');
              $(".modal-backdrop").remove();
              $("#modalTambahStok").modal("hide");
           });
          prevent();
        }


      });       
    });
  

  /////////////////////////////////////////////////////////


    $(".detail").on('click',function(){

      $(".loadingmodal").append('Loading...');     

      $.ajax({
        type:'GET',
        url:'/obat/detailobat?id='+$(this).data("id"),
        success: function(result){
          var obat = result.obat[0];
          var jenisobat = result.jenisobat;
          var kategoriobat = result.kategoriobat;
          var supplier = result.supplier;

          var modaldetail = `
                    <div class='modal fade' id=modalDetail tabindex=-1 role=dialog aria-labelledby=exampleModalLabel300 aria-hidden=true>
                        <div class='modal-dialog modal-lg' role=document>
                          <div class=modal-content>
                            <div class=modal-header>
                              <h5 class=modal-title id=exampleModalLabel300>${obat.nama_obat}</h5>
                              <button type=button class=close data-dismiss=modal aria-label=Close>
                                <span aria-hidden=true>&times;</span>
                              </button>
                            </div>
                            <div class=modal-body>
                              <div class=container>
                                <div class=row>
                                  <div class=col>

                                 

                                      <img src='${obat.foto_obat}' class=img-fluid alt='${obat.foto_obat}'>
                                      


                                        <div class='alert alert-primary mb-auto' role=alert>
                                         Obat masuk pada : ${obat.created_at}
                                        </div>
                                        <div class='alert alert-info mb-auto' role=alert>
                                         obat diperbarui pada : ${obat.updated_at}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role=alert>
                                          Stok : ${obat.stok}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role=alert>
                                          Total Penjualan : ${obat.total_penjualan}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role=alert>
                                          Total Pemasukan : ${obat.total_pemasukan}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role=alert>
                                          Dikirim Oleh : ${obat.nama_supplier}
                                        </div>
                                        
                                     
                                  </div>`;

                        modaldetail += `<div class=h-100></div>
                                  <div class=col>
                                <form class=form-prevent action=/obat/${obat.id_obat} method=POST enctype=multipart/form-data>
                                @method('PUT')
                                @csrf
                                 Kode Obat <input value='${obat.kode_obat}' type=text name=kode_obat class='form-control' readonly>
                                 Foto Obat <input type=file name=foto_obat class='form-control h-auto'>
                                 Nama Obat <input value='${obat.nama_obat}' type=text name=nama_obat class=form-control>
                                 Fungsi Obat <textarea name=fungsi_obat class=form-control cols=30 rows=10>${obat.fungsi_obat}</textarea>
                 Kategori Obat 
                            <select name=nama_kategoriobat class='form-control selectko'>
                              <option disabled selected value=''> -- select an option -- </option>`;

                            $.each(kategoriobat, function( index, value ) {
                            modaldetail += `   
                              <option value='${ value.nama_kategoriobat }'>${ value.nama_kategoriobat }</option>
                            `;
                            });
                              
                            modaldetail += `
                            </select>
                            Jenis Obat
                            <select name=nama_jenisobat class='form-control selectjo'>
                              <option disabled selected value=''> -- select an option -- </option>
                            `;


                            $.each(jenisobat, function( index, value ) {
                              modaldetail += ` 
                                <option value='${ value.nama_jenisobat }'>${ value.nama_jenisobat }</option>
                              `;
                            });

                            modaldetail += `  
                            </select> 
                            Supplier 
                            <select name=nama_supplier class='form-control selectsp'>
                              <option disabled selected value=''> -- select an option -- </option>
                            `;

                            $.each(supplier, function( index, value ) {
                            modaldetail += `
                              <option value="${value.id_supplier}">${value.nama_supplier}</option>
                            `;
                            });

                            modaldetail += `
                            </select>

                            Harga Obat <input type=number value=${obat.harga_obat} class='form-control mb-3' name=harga_obat>
      
                                   <button type=submit class='btn btn-warning button-prevent'>Ubah Data</button>
                                 </form>
                                 
                                 <form class=form-prevent action=/obat/${obat.id_obat} method=POST>
                                 @method('DELETE')
                                 @csrf
                                 <button type=submit class='btn btn-danger button-prevent'>Hapus Data</button>
                                 </form>
                                 <button type=button class='btn btn-secondary' data-dismiss=modal>Tutup</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class=modal-footer>
                              &copy Smartpharmacy 
                            </div>
                          </div>
                        </div>
                      </div>
                  `;

           $(".modaldetail").append(modaldetail);

           $(".loadingmodal").html('');
           $("#modalDetail").modal('show');
           $(".selectko").val(obat.nama_kategoriobat).change();
           $(".selectjo").val(obat.nama_jenisobat).change();
           $(".selectsp").val(obat.id_supplier).change();
           $("#modalDetail").on("hide.bs.modal", function () {
              $(".modaldetail").html('');
              $(".modal-backdrop").remove();
              $("#modalDetail").modal('hide');
           });
          
           prevent();
        }

    });
  });

    $(".form-prevent").on("submit",function(){

      $(".button-prevent").attr('disabled','true');
        
    });

});
</script>

@endsection

