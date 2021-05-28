
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Kasir')
@endsection



@section('content')

@if(session('ralatEmail'))
  <div class="alert alert-danger">
      {{ session('ralatEmail') }}
  </div>
@endif

<div class="loadingmodal"></div>
 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
     <li class="breadcrumb-item active ml-auto" aria-current="page">
      <a class="btn btn-outline-light" href="{{ route('report.cashier') }}" target="_blank"><i class="fas fa-print text-white"></i></a>     
      <button class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal">+</button></form>
    </ol>
  </nav>

<div class="mb-3">{{ $kasir->links('vendor.pagination.bootstrap-4') }}</div>
<div class="table-responsive">
<table class="table table-hover">
  <thead class="table-bordered">
      <tr>
        <th scope="col">Kode Kasir</th>
        <th scope="col">Foto Kasir</th>
        <th scope="col">Nama Kasir</th>
        <th scope="col">Jumlah Transaksi</th>
      </tr>
  </thead>
  <tbody>

    @php
      $kodekasir = ($kodeksr !== null) ? $kodeksr->kode_kasir : "KSR000";
      $noUrut = substr($kodekasir,3);
      $noUrut++;
      $char = "KSR";
      $kode = $char.sprintf("%03s",$noUrut);
    @endphp
    @foreach($kasir as $data)
      <tr class="detail asd" data-id="{{ $data->id_kasir }}" data-placement="bottom" title="klik untuk melihat detail data lengkapnya">
        <td>{{ $data->kode_kasir }}</td>
        <td><img src="{{ $data->foto_kasir }}" width="100" height="100" class="img-fluid" alt="{{ $data->foto_kasir }}"></td>
        <td>{{ $data->nama_kasir }}</td>
        <td>{{ $data->jumlah_transaksi }}</td> 
      </tr>
    @endforeach
  </tbody>
</table>
</div>

<div class="mt-3">{{ $kasir->links('vendor.pagination.bootstrap-4') }}</div>

  <div class="modaldetail"></div>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0000" aria-hidden="true">
              <div class="modal-dialog modal-lg mr-auto" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kasir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>

                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-prevent" action="{{ route('cashier.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                       Kode Kasir <input value="{{ $kode }}" type="text" name="kode_kasir" class="form-control" readonly="">
                       Foto Kasir <input type="file" name="foto_kasir" class="h-auto form-control"> 
                       Nama Kasir <input type="text" name="nama_kasir" class="form-control">
                       Email <input type="email" name="email" class="form-control">
                       Password <div class="d-flex">
                          <input type="password" name="password" class="form-control passwordfield">
                          <div class="input-group-prepend">
                              <span id="passwordShow" class="input-group-text" id="inputGroupPrepend3"><i class="fas fa-eye"></i></span>
                          </div>
                        </div>
                        <div id="passwordAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                          Password harus sama.
                           <button type="button" class="close">
                            <span>&times;</span>
                          </button>
                        </div>
                       Konfirmasi Password <input type="password" class="form-control password2">
                       Jenis Kelamin <select class="form-control" name="jenis_kelamin">
                         <option value="L">Laki Laki</option>
                         <option value="P">Perempuan</option>
                       </select>
                       Tanggal Lahir <input type="date" name="tanggal_lahir" class="form-control form-control-feedback" value="{{ date('Y-m-d') }}">
                       Pendidikan Terakhir <select name="pendidikan_terakhir" class="form-control">
                         <option value="-">-</option>
                         <option value="SD">SD</option>
                         <option value="SMP">SMP</option>
                         <option value="SMA">SMA</option>
                         <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                       </select>
                       Nomor Telepon <input type="number" class="form-control" name="nomor_telepon">
                       Alamat <textarea name="alamat" cols="30" rows="10" class="form-control"></textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary button-prevent tambah">Tambah!</button>
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
  $("#passwordAlert").hide();
  prevent();

    $('.detail').click(function(){

      $('.loadingmodal').append(`Loading...`);
      
      $.ajax({
        url:'{{ route('cashier.detail') }}',
        type:'GET',
        data:{
          'id':$(this).data('id')
        },
        success:function(result){
          var data = result[0];
           $('.modaldetail').append(`
             <div class='modal fade' id=modalDetail tabindex=-1 role=dialog aria-labelledby=exampleModalLabell aria-hidden=true>
                        <div class='modal-dialog modal-lg' role=document>
                          <div class=modal-content>
                            <div class=modal-header>
                              <h5 class=modal-title id=exampleModalLabel>${data.nama_kasir}</h5>
                              <button type=button class=close data-dismiss=modal aria-label=Close>
                                <span aria-hidden=true>&times;</span>
                              </button>
                            </div>
                            <div class=modal-body>
                              <div class=container>
                                <div class=row>
                                  <div class=col>

                                 

                                      <img src='${data.foto_kasir}' class=img-fluid alt=>
                                      


                                        <div class='alert alert-primary mb-auto' role=alert>
                                         Mulai bekerja pada : ${data.created_at}
                                        </div>
                                        <div class='alert alert-info mb-auto' role=alert>
                                         Data diperbarui pada : ${data.updated_at}
                                        </div>
                                        <div class='alert alert-danger mb-auto' role=alert>
                                          Jumlah Transaksi : ${data.jumlah_transaksi}
                                        </div>
                                        
                                     
                                  </div>
                                  <div class=h-100></div>
                                  <div class=col>
                                <form class=form-prevent action=/cashier/${data.id_kasir} method=POST enctype=multipart/form-data>
                                  @method('PUT')
                                  @csrf
                                 Kode Kasir <input value='${data.kode_kasir}' type=text name=kode_kasir class=form-control readonly>
                                 Foto Kasir <input type=file name=foto_kasir class='form-control h-auto'>
                                 Nama Kasir <input value='${data.nama_kasir}' type=text name=nama_kasir class=form-control>
                                 Email <input value='${data.email}' type=email name=email class=form-control>                                  
                                 Password <div class="d-flex">
                                 <input type="password" name="password" class="form-control passwordfield">
                                    <div class="input-group-prepend">
                                        <span id="passwordShow" class="input-group-text" id="inputGroupPrepend3"><i class="fas fa-eye"></i></span>
                                    </div>
                                 </div>
                                 Jenis Kelamin <select id=jenis_kelamin class=form-control name=jenis_kelamin>
                                   <option value=L>Laki Laki</option>
                                   <option value=P>Perempuan</option>
                                 </select>
                                 Tanggal Lahir <input type=date name=tanggal_lahir class='form-control form-control-feedback' value='${data.tanggal_lahir}'>
                                 Pendidikan Terakhir <select name=pendidikan_terakhir class=form-control>
                                   <option value=->-</option>
                                   <option value=SD>SD</option>
                                   <option value=SMP>SMP</option>
                                   <option value=SMA>SMA</option>
                                   <option value=Perguruan Tinggi>Perguruan Tinggi</option>
                                 </select>
                                 Nomor Telepon <input type=text value='${data.nomor_telepon}' class=form-control name=nomor_telepon>
                                 Alamat <textarea name=alamat value= cols=30 rows=10 class='form-control mb-3'>${data.alamat}</textarea>

                                   <button type=submit class='btn btn-warning button-prevent'>Ubah Data</button>
                                 </form>
                                 
                                 <form class=form-prevent action=/cashier/${data.id_kasir} method=POST>
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
                  `);

           showPassword();

           $('.loadingmodal').html(``);
           $("#jenis_kelamin").val(data.jenis_kelamin).change();
           $("select[name=pendidikan_terakhir]").val(data.pendidikan_terakhir).change();
           $("#modalDetail").modal('show');
           $("#modalDetail").on("hide.bs.modal", function () {
              $(".modaldetail").html(``);
              $(".modal-backdrop").remove();
              $("#modalDetail").modal('hide');
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

  showPassword();
  function showPassword(){
    $(function(){
        $("#passwordShow").click(function(){
          $(this).children().toggleClass("fa-eye fa-eye-slash");
          if($(".passwordfield").attr("type") == "password"){
            $(".passwordfield").attr("type","text");
          }else{
            $(".passwordfield").attr("type","password");
          }
        });   
     });
  }

  $(".tambah").on('click',function(e){
     var password = $(".password").val();
     var confirmationPassword = $(".password2").val();

     if(password != null){
        if(password != confirmationPassword){
          e.preventDefault();
          $("#password").alert();
          $("#passwordAlert").show();
        }else{

        }
     }
  });

  $(".close").on('click',function(){
    $("#passwordAlert").hide();
  });

});

</script>


@endsection