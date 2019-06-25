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
              <table id="datapegawaifinger" class="table table-bordered thead-dark table-striped table-hover">
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

                </tbody>
              </table>
              <hr>
              <a href="/absensi/daftarabsensi_m" class="btn btn-info form-control">Cek data Absensi <i class="fa fa-search"></i></a>
              <hr>
              <button class="btn btn-danger form-control" id="peringatanwipe">Hapus Semua Data di dalam mesin fingerscan<i class="fa fa-trash"></i></button>
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
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
<!--javascript custom section   -->
<!-- code below -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
//komentar?
          $(document).ready(function() {
            var datatabelf = $('#datapegawaifinger').DataTable( {
                                "processing": true,
                                "serverSide": true,
                                "ajax": "{{route('dt.datapegawai')}}",
                                columns: [
                                      { data: 'PIN'},
                                      { data: 'PIN2' },
                                      { data: 'Name' },
                                      { data: 'Privilege' },
                                      { data: null }, //jika ingin mengisi data pada opsi columnDefs, parameter bagian ini harus diisi oleh null

                                  ],
                                  columnDefs: [
                                      { targets: [0,1,3] , className: 'text-right' },
                                      { targets: [2] , className: 'text-left' },
                                      {
                                        targets: [4] ,className: 'text-center',
                                        'render': function (data, type, row) {
                                            var aksi = '<a href="/pegawai/jumlahfingerpegawai_m/'+data.PIN2+'/'+data.Name+'" class="btn btn-primary">Cek/Tambah Finger <i class="fa fa-search"></i></a><a href="" class="btn btn-primary">Cek Absensi <i class="fa fa-search"></i></a><button class="hapus_'+data.PIN2+' hapusfinger btn btn-danger" id="hapusf"><i class="fa fa-trash"></i></button>';
                                            return aksi;
                                        }
                                     },
                                  ]
                                } );
              $('#refresh').click(function(){
                datatabelf.ajax.reload();
                console.log('reload');
              });

              //hapus data pegawai
              $(document).on('click','.hapusfinger',function (){
                var currentRow = $(this).closest('tr');
                var id = currentRow.find('td:eq(1)').text();
                var nama = currentRow.find('td:eq(2)').text();
                var _token= $("input[name=_token]").val();

                //alert("data "+nama);
                $.ajax({
                    type:'post',
                    url:'{{route("mesin.hapuspegawai")}}',
                    data : {
                            id:id,
                            nama:nama,
                            _token:_token
                            },
                    success:function(response){
                      if((response.status==1)){
                          $('.error').addClass('hidden');
                          swal("Sukses Menghapus Data "+response.nama, "", "warning");
                          $('#modal_add').modal('hide');
                          //console.log(response.nama);
                          datatabelf.ajax.reload();
                      }
                      else
                        {
                          $('.error').addClass('hidden');
                          swal("Terjadi Kesalahan", "", "error");
                          $('#modal_add').modal('hide');
                          //console.log(response);
                          datatabelf.ajax.reload();
                          }
                    },
                });
              });

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
                        if((response.status!=0)){
                            $('.error').addClass('hidden');
                            swal("Sukses Menambah Data "+response.nama, "", "success");
                            $('#modal_add').modal('hide');
                            //console.log(response.nama);
                            datatabelf.ajax.reload();
                        }
                        else
                          {
                            $('.error').addClass('hidden');
                            swal(response.pesan, "", "error");
                            $('#modal_add').modal('hide');
                            //console.log(response);
                            datatabelf.ajax.reload();
                            }
                      },
                  });
                });
          } ); //END LINE FUNCTION


</script>
@stop
