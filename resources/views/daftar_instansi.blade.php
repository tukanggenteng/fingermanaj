{{-- resources/views/daftar_instansi.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Instansi di Basis Data')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Daftar nama Instansi di PemProv Kalimantan Selatan</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            </div>
            <div class="box-body">
              <button class="btn btn-primary" id="tambah" data-toggle="modal" data-target="#modal_add">Tambah Instansi <i class="fas fa-building"></i></button>
              <button class="btn btn-info" id="refresh">Refresh <i class="fa fa-refresh"></i></button>
              <hr>
              <table id="datainstansi" class="table table-bordered thead-dark table-striped table-hover">
                <thead class="bg-navy">
                  <tr>
                    <th class="col-md-1">ID</th>
                    <th class="col-md-1">Kode</th>
                    <th class="col-md-6">Nama Instansi</th>
                    <th class="col-md-3">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
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
            <h4 class="modal-title">Tambah Instansi <i class="fa fa-building"></i></h4>
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
                    <div class="form-group">
                      <label>Kode</label>
                      <input id="kode" name="kode" class="form-control pull-right" type="text">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group" >
                      <label>Nama Instansi</label>
                      <input id="nama_instansi" name="nama_instansi" type="text" class="form-control pull-right">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
              <button type="button" id="addinstansi" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- modal Edit Instansi data-->
      <div class="modal modal-warning fade" id="modal_edit_ins">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Instansi <i class="fa fa-building"></i></h4>
            </div>
            <div class="modal-body">
              <div class="error alert-danger alert-dismissible">
              </div>
              <form id="formpegawaiadd" method="post" role="form" enctype="multipart/form-data" action="{{route('mesin.datapegawai')}}">
                 @csrf
                <input id="ID_e" name="ID_e" class="form-control pull-right" type="hidden">

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Kode</label>
                        <input id="kode_e" name="kode_e" class="form-control pull-right" type="text">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group" >
                        <label>Nama Instansi</label>
                        <input id="nama_instansi_e" name="nama_instansi_e" type="text" class="form-control pull-right">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                <button type="button" id="updateinstansi" class="btn btn-primary">Update</button>
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
<script src="/js/fm/instansi.js"></script>
@stop
