{{-- resources/views/datapegawai_m.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Pegawai di Masin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Data Pegawai di Mesin Finger</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <button class="btn btn-primary" data-toggle="modal" id="tambah" data-target="#modal_add">Tambah Pegawai <i class="fa fa-user"></i></button>
              <hr>
              <table class="table table-bordered thead-dark table-striped table-hover">
                <thead class="bg-navy">
                  <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-1">ID</th>
                    <th class="col-md-6">Nama</th>
                    <th class="col-md-1">Privilege</th>
                    <th class="col-md-3">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @for($i=0;$i<count($datapegawai);$i++)
                    @if($datapegawai[$i]['PIN']!='')
                    <tr>
                      <td>{{$datapegawai[$i]['PIN']}}</td>
                      <td>{{$datapegawai[$i]['PIN2']}}</td>
                      <td>{{$datapegawai[$i]['Name']}}</td>
                      <td>{{$datapegawai[$i]['Privilege']}}</td>
                      <td>
                          <a href="{{route('mesin.datafingerpegawai',[$datapegawai[$i]['PIN2'],$datapegawai[$i]['Name']])}}" class="btn btn-primary">Cek/Tambah Finger <i class="fa fa-search"></i></a>
                          <a href="" class="btn btn-primary">Cek Absensi <i class="fa fa-search"></i></a>
                          <button class="hapus_{{$datapegawai[$i]['PIN2']}} btn btn-danger"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                    @endif
                  @endfor
                </tbody>
              </table>
              <hr>
              <a href="" class="btn btn-info form-control">Cek data Absensi <i class="fa fa-search"></i></a>
              <hr>
              <button class="btn btn-danger form-control">Hapus Semua Data Pegawai <i class="fa fa-trash"></i></button>
            </div>
            <div class="box-footer">
            </div>
          </form>
          </div>
      </div>
    </div>

    <!-- modal tambah-->
    <div class="modal fade" id="modal_add">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tambah Pegawai <i class="fa fa-user"></i></h4>
          </div>
          <div class="modal-body">
            <div class="error alert-danger alert-dismissible">
            </div>
            <form id="formpegawaiadd" method="post" role="form" enctype="multipart/form-data" action="{{route('mesin.datapegawai')}}">

              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>ID</label>
                      <input id="ID" name="ID" class="form-control pull-right" type="text">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group" >
                      <label>Nama</label>
                      <input id="nama" name="nama" type="text" class="form-control pull-right">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
              <button type="button" id="addpegawai" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
@stop

@section('css')

<!--css custom section   -->
<!-- code below -->
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<!--javascript custom section   -->
<!-- code below -->
<script src="/js/unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
//komentar?
// Tambah Data Pegawai
        $(document).on('click','#addpegawai',function (){
            var pin=$('#ID').val();
            var nama=$('#nama').val();
            var _token=$("input[name=_token]").val();
            $.ajax({
                type:'post',
                url:'{{route("mesin.tambahpegawai")}}',
                data : {
                        pin:pin,
                        nama:nama,
                        _token:_token
                        },
                success:function(response){
                    if((response.error)){
                        $('.error').addClass('hidden');
                        swal(response.error, "", "error");
                        $('#modal_add').modal('hide');
                        //console.log(response);
                    }
                    else
                    {
                        $('.error').addClass('hidden');
                        swal("Sukses Menyimpan Data "+response.nama, "", "success");
                        $('#modal_add').modal('hide');
                        //console.log(response.nama);
                    }
                },
            });
        });
</script>
@stop
