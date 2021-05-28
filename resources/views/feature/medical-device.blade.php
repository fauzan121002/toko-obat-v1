
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Alat Kesehatan')
@endsection

@section('content')

<div class="loadingmodal"></div>
 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
     <li class="breadcrumb-item active ml-auto" aria-current="page">     
      <a class="btn btn-outline-light" href="{{ route('report.medical-device') }}" target="_blank"><i class="fas fa-print text-white"></i></a> 
      <button class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal">+</button></form>
    </ol>
  </nav>

<div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Tulis Nama Alat Kesehatan..." aria-label="Tulis Nama Alat Kesehatan..." aria-describedby="button-addon2">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari Alat Kesehatan!</button>
  </div>
</div>

<div class="mb-3">{{ $alatkesehatan->links('vendor.pagination.bootstrap-4') }}</div> 
<div class="table-responsive">
<table class="table">
  <thead class="table-bordered">
      <tr>
        <th scope="col">Kode Alat Kesehatan</th>
        <th scope="col">Foto Alat Kesehatan</th>
        <th scope="col">Nama Alat Kesehatan</th>
        <th scope="col">Detail</th>
        <th scope="col">Checkout</th>
        <th scope="col">Tambah Stok</th>
      </tr>
  </thead>
  <tbody>

    @php
      $kodeak = ($kodealatkesehatan !== null) ? $kodealatkesehatan->kode_alatkesehatan : "AKT000";
      $noUrut = substr($kodeak,3);
      $noUrut++;
      $char = "AKT";
      $kode = $char.sprintf("%03s",$noUrut);
    @endphp

    @foreach($alatkesehatan as $data)
      <tr>
        <td>{{ $data->kode_alatkesehatan }}</td>
        <td><img src="{{ $data->foto_alatkesehatan }}" alt="{{ $data->foto_alatkesehatan }}" width="100" height="100" class="img-fluid"></td>
        <td>{{ $data->nama_alatkesehatan }}</td> 
        <td><span class="btn btn-outline-primary detail" data-id="{{ $data->id_alatkesehatan }}">Lihat Detail</span></td>
        <td><span class="btn btn-outline-success detailtransaksi" data-id="{{ $data->id_alatkesehatan }}">Mulai Transaksi</span></td>
        <td><span class="btn btn-outline-secondary tambahstok" data-id="{{ $data->id_alatkesehatan }}">Tambah Stok</span></td>
      </tr>
    @endforeach
  </tbody>
</table>
</div>
<div class="mt-3">{{ $alatkesehatan->links('vendor.pagination.bootstrap-4') }}</div> 

 <div class="modaldetail"></div>
  <div class="modal fade mx-auto" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg mr-auto" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Alat Kesehatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>

                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-prevent" action="{{ route('medical-device.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      Kode Alat Kesehatan <input type="text" class="form-control" name="kode_alatkesehatan" value="{{ $kode }}" readonly="">
                      Foto Alat Kesehatan <input type="file" name="foto_alatkesehatan" class="h-auto form-control"> 
                      Nama Alat Kesehatan <input type="text" class="form-control" name="nama_alatkesehatan">
                      Fungsi Alat Kesehatan <textarea name="fungsi_alatkesehatan" class="form-control" cols="30" rows="10"></textarea>
					  Supplier 
					  <select name="nama_supplier" class="form-control">
					  	<option disabled selected value=""> -- select an option -- </option>
					  @foreach($supplier as $data)
                      	<option value="{{ $data->id_supplier }}">{{ $data->nama_supplier }}</option>
                      @endforeach
                      </select>
					  Harga Alat Kesehatan <input type="number" class="form-control" name="harga_alatkesehatan">
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

<div class="tambahstokmodal"></div>

<div class="detailtransaksimodal"></div>
@endsection


@section('footer')
@parent

<script> 
  
  $(document).ready(function(){
  prevent();


    $(".detailtransaksi").on('click',function(){

      $(".loadingmodal").append('Loading...');      

      $.ajax({
        type:'GET',
        url:`{{ route('medical-device.transaction') }}?id=${$(this).data("id")}`,
        success: function(result){
          var data = result.alatkesehatan[0];

          $(".detailtransaksimodal").append(`
                    <div class='modal fade' id=modalDetailTransaksi tabindex=-1 role=dialog aria-labelledby=exampleModalLabell aria-hidden=true>
                        <div class='modal-dialog modal-lg' role='document'>
                          <div class=modal-content>
                            <div class=modal-header>
                              <h5 class=modal-title id=exampleModalLabel>${data.nama_alatkesehatan}</h5>
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
                                            <img src='${data.foto_alatkesehatan}' class='img-fluid w-100 d-block' alt='${data.foto_alatkesehatan}'>
                                        </div>
                                        <div class=col-md-6>
                                        <form action='/transaction/${data.id_alatkesehatan}/medical-device' method='POST'>
                                            @csrf
                                            Kode Pesanan
                                            <input type=text name=kode_transaksi value='${result.kode_transaksi}' class=form-control readonly>
                                            Nama Pesanan
                                            <input type=text name=nama_pesanan value='${data.nama_alatkesehatan}' class=form-control readonly>                                            
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
            var total_harga = data.harga_alatkesehatan * jumlah_pesanan;
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


    $(".tambahstok").click(function(){

      $(".loadingmodal").append('Loading...');

      $.ajax({
        type:'GET',
        url:'/medical-device/stock-detail',
        data:{
          'id':$(this).data('id')
        },
        success: function(result){
          var data = result[0];
          $(".tambahstokmodal").append(`
<div class='modal fade' id='modalTambahStok' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabell' aria-hidden='true'>
                        <div class='modal-dialog modal-lg' role='document'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='exampleModalLabel'>${data.nama_alatkesehatan}</h5>
                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                              <div class='container'>
                                <div class='row'>
                                  <div class='col'>

                                    <form action='/medical-device/update-stock/${data.id_alatkesehatan}' method='POST'>
                                      @method('PUT')
                                      @csrf
                                      <input type='hidden' value='${data.id_supplier}' name='id_supplier'>
                                      Tambah Stok Alat Kesehatan <input type='number' name='stok' class='form-control mb-3' required>
                                      <button class='btn btn-primary' type='submit'>Tambah</button>
                                      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
                                    </form>

                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class='modal-footer'>
                              
                            </div>
                          </div>
                        </div>
                      </div>              
          `);

          
          $(".loadingmodal").html('');
          $("#modalTambahStok").modal("show");
           $("#modalTambahStok").on("hide.bs.modal", function () {
              $(".tambahstokmodal").html('');
              $(".modal-backdrop").remove();
              $("#modalTambahStok").modal("hide");
           });    
        }
      });

    });



    $(".detail").click(function(){

      $(".loadingmodal").append('Loading...');     

      $.ajax({
        type:'GET',
        url:'/medical-device/detail',
        data:{
          'id':$(this).data('id')
        },
        success:function(result){
          var data = result[0];

           $(".modaldetail").append(`
<div class='modal fade' id='modalDetail' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabell2' aria-hidden='true'>
                        <div class='modal-dialog modal-lg' role='document'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='exampleModalLabel'>${data.nama_alatkesehatan}</h5>
                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                              <div class='container'>
                                <div class='row'>
                                  <div class='col'>

                                 

                                      <img src='${data.foto_alatkesehatan}' class='img-fluid' alt=''s>
                                      


                                        <div class='alert alert-primary mb-auto' role='alert'>
                                         Obat masuk pada : ${data.created_at}
                                        </div>
                                        <div class='alert alert-info mb-auto' role='alert'>
                                         Data diperbarui pada : ${data.updated_at}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role='alert'>
                                          Stok : ${data.stok}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role='alert'>
                                          Total Penjualan : ${data.total_penjualan}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role='alert'>
                                          Total Pemasukan : ${data.total_pemasukan}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role='alert'>
                                          Dikirim Oleh : ${data.nama_supplier}
                                        </div>
                                        
                                     
                                  </div>
                                  <div class='h-100'></div>
                                  <div class='col'>
                                <form class='form-prevent' action='/medical-device/${data.id_alatkesehatan}' method='POST' enctype='multipart/form-data'>
                                  @method('PUT')
                                  @csrf
                                 Kode Obat <input value='${data.kode_alatkesehatan}' type='text' name='kode_alatkesehatan' class='form-control' readonly>
                                 Foto Alat Kesehatan <input type='file' name='foto_alatkesehatan' class='form-control h-auto'>
                                 Nama Alat Kesehatan <input value='${data.nama_alatkesehatan}' type='text' name='nama_alatkesehatan' class='form-control'>
                                 Fungsi Alat Kesehatan <textarea name='fungsi_alatkesehatan' class='form-control' cols='30' rows='10'>${data.fungsi_alatkesehatan}</textarea>
								 
								  Supplier 
								  <select name='nama_supplier' class='form-control'>
								  	<option disabled selected value='> -- select an option -- </option>
								  @foreach($supplier as $data)
			                      	<option value='{{ $data->id_supplier }}'>{{ $data->nama_supplier }}</option>
			                      @endforeach
			                      </select>

			                      Harga Alat Kesehatan <input type='number' value='${data.harga_alatkesehatan}' class='form-control mb-3' name='harga_alatkesehatan'>
		
                                   <button type='submit' class='btn btn-warning button-prevent'>Ubah Data</button>
                                 </form>
                                 
                                 <form class='form-prevent' action='/medical-device/${data.id_alatkesehatan}' method='POST'>
                                 @method('DELETE') 
                                 @csrf 
                                 <button type='submit' class='btn btn-danger button-prevent'>Hapus Data</button>
                                 </form>
                                 <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class='modal-footer'>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                  `);

           $(".loadingmodal").html('');
           $("#modalDetail").modal("show");
           $("select[name=nama_supplier]").val(data.id_supplier).change();
           $("#modalDetail").on("hide.bs.modal", function () {
              $(".modaldetail").html('');
              $(".modal-backdrop").remove();
              $("#modalDetail").modal("hide");
           });
          
           prevent();

        }

     });
    });

    function prevent(){
        $(".form-prevent").on("submit",function(){

          $(".button-prevent").attr('disabled','true');
        
        });
    }

  });


</script>

@endsection