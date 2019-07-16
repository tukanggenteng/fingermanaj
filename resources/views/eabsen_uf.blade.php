{{-- resources/views/eabsen_uf.blade.php --}}

@extends('adminlte::page')

@section('title', 'Upload Data Fingerprint')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Upload Data Fingerprint ke eabsen.kalselprov.go.id</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
              <button class="btn btn-info" id="refresh">Refresh <i class="fa fa-refresh"></i></button>
              <button class="btn bg-teal" id="clearprogres">Clear Laporan Progres <i class="fa fa-refresh"></i></button>
            </div>
            <div class="box-body">
              <table id="datapegawaifinger" class="table table-bordered thead-dark table-striped table-hover">
                <thead class="bg-navy">
                  <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-1">ID</th>
                    <th class="col-md-5">Nama</th>
                    <th class="col-md-1">Privilege</th>
                    <th class="col-md-4">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
              <div id="progresstambah"></div>
              <div class="container">
                <div class="row">
                  <div id="datatambah" class="timeline" style="overflow-y: scroll; max-height: 600px"></div>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button class="btn btn-info form-control" id="uploadall_question" id="uploadall_question" data-toggle="modal" data-target="#modal_uploadall">Upload Semua Data Sidik Jari di dalam mesin fingerprint scan <i class="fa fa-upload"></i></button>
            </div>
          </form>
          </div>
      </div>
    </div>

    <!-- modal Upload data Sidik Jari Pegawai Manual-->
    <div class="modal modal-info fade" id="modal_uploadfp">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Upload Manual Data Sidik Jari/PIN/Password<i class="fa fa-user"></i></h4>
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
                      <label>Upload Data Sidik Jari yang IDnya berbeda dari data pada eabsen.kalselprov.go.id !</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group" >
                      <label>ID Pegawai pada eabsen.kalselprov.go.id</label>
                      <input id="iddarimesin_man" name="iddarimesin_man" type="hidden" class="form-control pull-right">
                      <input id="nama_man" name="nama_man" type="hidden" class="form-control pull-right">
                      <input id="iddarieabsen_man" name="iddarieabsen_man" type="text" class="form-control pull-right">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
              <button type="button" id="uploadman" class="btn btn-primary">Upload</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- modal Upload data Semua data sidik jari pegawai-->
      <div class="modal modal-warning fade" id="modal_uploadall">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Upload Semua Data Sidik Jari/PIN/Password dari Mesin<i class="fa fa-user"></i></h4>
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
                        <label>Apakah semua ID Pegawai pada mesin sudah sama dengan ID Pegawai pada eabsen.kalselprov.go.id ???</label>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak !</button>
                <button type="button" id="uploadf_all" class="btn btn-success md-col-3">Ya!</button>
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
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
<script src="/js/fm/eabsenuf.js"></script>
@stop
