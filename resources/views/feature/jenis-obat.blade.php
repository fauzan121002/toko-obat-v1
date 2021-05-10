
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Jenis Obat')
@endsection

@section('content')

 <div class="loadingmodal"></div>
 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
     <li class="breadcrumb-item active ml-auto" aria-current="page">     
      <a class="btn btn-outline-light" href="{{ route('laporan.jenis') }}" target="_blank"><i class="fas fa-print text-white"></i></a>
      <button class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal">+</button></form>
    </ol>
  </nav>

<div class="mb-3">{{ $jenisobat->links('vendor.pagination.bootstrap-4') }}</div> 
<div class="table-responsive">
<table class="table table-hover">
  <thead class="table-bordered">
      <tr>
        <th scope="col">Kode Jenis Obat</th>
        <th scope="col">Nama Jenis Obat</th>
      </tr>
  </thead>
  <tbody>

    @php
      $kodejo = ($kodejenisobat !== null) ? $kodejenisobat->kode_jenisobat : "JEO000";
      $noUrut = substr($kodejo,3);
      $noUrut++;
      $char = "JEO";
      $kode = $char.sprintf("%03s",$noUrut);
    @endphp
    @foreach($jenisobat as $data)
      <tr class="detail" data-id="{{ $data->id_jenisobat }}">
        <td>{{ $data->kode_jenisobat }}</td>
        <td>{{ $data->nama_jenisobat }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
</div>
<div class="mt-3">{{ $jenisobat->links('vendor.pagination.bootstrap-4') }}</div> 

 <div class="modaldetail"></div>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg mr-auto" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jenis Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>

                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-prevent" action="/jenisobat/tambahjenisobat" method="POST">
                      @csrf
                      Kode Jenis Obat <input type="text" class="form-control" name="kode_jenisobat" value="{{ $kode }}" readonly="">
                      Nama Jenis Obat <input type="text" class="form-control" name="nama_jenisobat">
                      Deskripsi Jenis Obat <textarea class="form-control" name="deskripsi_jenisobat" id="deskripsi_jenisobat" cols="30" rows="10"></textarea>
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

@endsection

@section('footer')
@parent

<script> 
  
  $(document).ready(function(){
  prevent();

    $(".detail").on('click',function(){

      $(".loadingmodal").append('Loading...');
      
      $.ajax({
        type:'GET',
        url:'/jenisobat/detailjenisobat?id='+$(this).data("id"),
        success: function(result){
          var data = result[0];

           $(".modaldetail").append(`
             <div class='modal fade' id='modalDetail' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabell' aria-hidden='true'>
                        <div class='modal-dialog modal-xl' role='document'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='exampleModalLabel'>${data.nama_jenisobat}</h5>
                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                                <form class='form-prevent' action='/jenisobat/${data.id_jenisobat}' method='POST' enctype='multipart/form-data'>
                                  @method('PUT')
                                  @csrf
                                 Kode Jenis obat <input value='${data.kode_jenisobat}' type='text' name='kode_jenisobat' class='form-control' readonly>
                                 Nama Jenis obat <input value='${data.nama_jenisobat}' type='text' name='nama_jenisobat' class='form-control'>
                                 Deskripsi Jenis obat <textarea class='form-control mb-3' name='deskripsi_jenisobat' cols='30' rows='10'>${data.deskripsi_jenisobat}</textarea>
                              
                                   <button type='submit' class='btn btn-warning button-prevent'>Ubah Data</button>
                                 </form>
                                 
                                 <form class='form-prevent' action='/jenisobat/${data.id_jenisobat}' method='POST'>
                                 @method('DELETE') 
                                 @csrf 
                                 <button type='submit' class='btn btn-danger button-prevent'>Hapus Data</button>
                                 </form>

                                 <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
                                  </div>
                                
                            <div class='modal-footer'>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                  `);

           $(".loadingmodal").html('');           
           $("#modalDetail").modal("show");
           $("#modalDetail").on("hide.bs.modal", function () {
              $(".modaldetail").html('');
              $(".modal-backdrop").remove();
              $("#modalDetail").modal("hide");
           });
          
           prevent();
        }

    });
    });
  });


function prevent(){
    $(".form-prevent").on("submit",function(){

      $(".button-prevent").attr('disabled','true');
    
    });
}


</script>

@endsection