
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Kategori Obat')
@endsection

@section('content')

 <div class="loadingmodal"></div>
 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
     <li class="breadcrumb-item active ml-auto" aria-current="page">     
      <a class="btn btn-outline-light" href="{{ route('report.drug-category') }}" target="_blank"><i class="fas fa-print text-white"></i></a>
      <button class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal">+</button></form>
    </ol>
  </nav>

<div class="mb-3">{{ $kategoriobat->links('vendor.pagination.bootstrap-4') }}</div> 
<div class="table-responsive">
<table class="table table-hover">
  <thead class="table-bordered">
      <tr>
        <th scope="col">Kode Kategori Obat</th>
        <th scope="col">Nama Kategori Obat</th>
      </tr>
  </thead>
  <tbody>

    @php
      $kodektgrobat = ($kodektrobt !== null) ? $kodektrobt->kode_kategoriobat : "KOB000";
      $noUrut = substr($kodektgrobat,3);
      $noUrut++;
      $char = "KOB";
      $kode = $char.sprintf("%03s",$noUrut);
    @endphp
    @foreach($kategoriobat as $data)
      <tr class="detail asd" data-toggle="modal" data-target="modalDetail" data-id="{{ $data->id_kategoriobat }}"  data-placement="bottom" title="klik untuk melihat detail data lengkapnya">
        <td>{{ $data->kode_kategoriobat }}</td>
        <td>{{ $data->nama_kategoriobat }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
</div>
<div class="mt-3">{{ $kategoriobat->links('vendor.pagination.bootstrap-4') }}</div>

 <div class="modaldetail"></div>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg mr-auto" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kategori Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>

                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-prevent" action="{{ route('drug-category.store') }}" method="POST">
                      @csrf
                      Kode Kategori Obat <input type="text" class="form-control" name="kode_kategoriobat" value="{{ $kode }}" readonly="">
                      Nama Kategori Obat <input type="text" class="form-control" name="nama_kategoriobat">
                      Deskripsi Kategori Obat <textarea class="form-control" name="deskripsi_kategoriobat" id="deskripsi_kategoriobat" cols="30" rows="10"></textarea>
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

    $(".detail").click(function(){

      $(".loadingmodal").append('Loading...');
      
      $.ajax({
        type:'GET',
        url:'/drug-category/detail?id='+$(this).data("id"),
        success: function(result){
          var data = result[0];

           $(".modaldetail").html(`
             <div class='modal fade' id='modalDetail' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabell' aria-hidden='true'>
                        <div class='modal-dialog modal-lg' role='document'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='exampleModalLabel'>${data.nama_kategoriobat}</h5>
                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                                <form class='form-prevent' action='/drug-category/${data.id_kategoriobat}' method='POST' enctype='multipart/form-data'>
                                  @method('PUT')
                                  @csrf
                                 Kode kategori obat <input value='${data.kode_kategoriobat}' type='text' name='kode_kategoriobat' class='form-control' readonly=''>
                                 Nama kategori obat <input value='${data.nama_kategoriobat}' type='text' name='nama_kategoriobat' class='form-control'>
                                 Deskripsi kategori obat <textarea class='form-control mb-3' name='deskripsi_kategoriobat' cols='30' rows='10'>${data.deskripsi_kategoriobat}</textarea>
                              
                                   <button type='submit' class='btn btn-warning button-prevent'>Ubah Data</button>
                                 </form>
                                 
                                 <form class='form-prevent' action='/drug-category/${data.id_kategoriobat}' method='POST'>
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

    function prevent(){
      $(".form-prevent").on("submit",function(){

        $(".button-prevent").attr('disabled','true');
      
      });
    }
  });





</script>


@endsection