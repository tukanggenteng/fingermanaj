{{-- resources/views/datapegawai_m.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Pegawai di Masin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Download Data Pegawai dari eabsen.kalselprov.go.id</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <button class="btn btn-primary" data-toggle="modal" id="tambah_dpf" data-target="#modal_add_dpf">Tambah Data Pegawai yang sudah memiliki sidik jari <i class="fa fa-user"></i></button>
              <hr>
              <button class="btn btn-primary" data-toggle="modal" id="tambah_dptf" data-target="#modal_add_dptf">Tambah Data Pegawai yang belum memiliki sidik jari <i class="fa fa-user"></i></button>
              <hr>
                <div id="datadarieabsen" style="visibility:hidden;"></div>
                <div id="aksitambahdata"></div>
                <div id="progresstambah"></div>
                <div id="datatambah"></div>
            </div>
            <div class="box-footer">
            </div>
          </form>
          </div>
      </div>
    </div>

    <!-- modal tambah data pegawai yang sudah memiliki sidik jari-->
    <div class="modal fade" id="modal_add_dpf">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tambah Data Pegawai yang sudah memiliki sidik jari <i class="fa fa-user"></i></h4>
          </div>
          <div class="modal-body">
            <div class="error alert-danger alert-dismissible">
            </div>
            <form id="formpegawaiadd" method="post" role="form" enctype="multipart/form-data" action="">

              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Pilih asal Instansi data pegawai !</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group" >
                      <label>Instansi</label>
                      <input id="instansi" name="instansi" type="text" class="form-control pull-right">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
              <button type="button" id="addpegawai_dpf" class="btn btn-primary">Tambah</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- modal tambah data pegawai yang belum memiliki sidik jari-->
      <div class="modal fade" id="modal_add_dptf">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Tambah Data Pegawai yang belum memiliki sidik jari <i class="fa fa-user"></i></h4>
            </div>
            <div class="modal-body">
              <div class="error alert-danger alert-dismissible">
              </div>
              <form id="formpegawaiadd" method="post" role="form" enctype="multipart/form-data" action="">

                @csrf
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Pilih asal Instansi data pegawai !</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group" >
                        <label>Instansi</label>
                        <input id="instansi" name="instansi" type="text" class="form-control pull-right">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                <button type="button" id="addpegawai_dptf" class="btn btn-primary">Tambah</button>
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
<script src="/js/fm/eabsendp.js"></script>
@stop
