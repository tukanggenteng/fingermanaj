{{-- resources/views/datapegawai_m.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Pegawai di Mesin Finger')

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
              <button class="btn btn-info" id="refresh">Refresh <i class="fa fa-refresh"></i></button>
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
              <button class="btn btn-danger form-control" id="peringatanwipe" data-toggle="modal" data-target="#modal_swipe">Hapus Semua Data di dalam mesin fingerscan <i class="fa fa-trash"></i></button>
            </div>
            <div class="box-footer">
            </div>
          </form>
          </div>
      </div>
    </div>

    <!-- modal tambah data pegawai-->
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

      <!-- modal Wipe data-->
      <div class="modal modal-danger fade" id="modal_swipe">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title text-center text-error"><b>Wipe semua Data<i class="fa fa-warning"></i><b></h3>
            </div>
            <div class="modal-body">
              <div class="error alert-danger alert-dismissible">
              </div>
              <form id="formpegawaiadd" method="post" role="form" enctype="multipart/form-data" action="">

                @csrf
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group text-center">
                        <h3>Semua Data yang ada di dalam mesin Finger Scan akan dihapus</h3>
                      </div>
                      <div class="form-group text-center">
                        <h3>Apakah anda yakin ???</h3>
                        <h4>ClearData(1)</h4>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group col-md-6" >
                        <button type="button" class="btn btn-outline btn-success pull-right col-md-5" data-dismiss="modal"><b>Tidak</b></button>
                      </div>
                      <div class="form-group col-md-6" >
                        <button type="button" id="swipedatapegawai" class="btn btn-outline btn-warning col-md-5"><b>Ya !</b></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
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
<script src="/js/fm/mesinfingerprint.js"></script>
@stop
