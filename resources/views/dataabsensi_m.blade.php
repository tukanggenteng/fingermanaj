{{-- resources/views/dataabsensi_m.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Absensi di Mesin Fingerprint')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Data Absensi di Mesin Finger</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <button class="btn btn-info" id="refresh">Refresh <i class="fa fa-refresh"></i></button>
              <hr>
              <table id="datasemuaabsensi" class="table table-bordered thead-dark table-striped table-hover">
                <thead class="bg-navy">
                  <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-1">ID</th>
                    <th class="col-md-3">Nama</th>
                    <th class="col-md-1">Tanggal</th>
                    <th class="col-md-1">Jam</th>
                    <th class="col-md-3">Ket Absen</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
            <div class="box-footer">
              <button class="btn btn-danger form-control" id="peringatanwipeabsen" data-toggle="modal" data-target="#modal_swipe_a">Hapus Semua Data Absensi di dalam mesin fingerscan <i class="fa fa-trash"></i></button>
            </div>
          </form>
          </div>
      </div>
    </div>

    <!-- modal Wipe data Absensi-->
    <div class="modal modal-danger fade" id="modal_swipe_a">
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
                      <h3>Semua Data Absensi yang ada di dalam mesin Fingerprint Scan akan dihapus</h3>
                    </div>
                    <div class="form-group text-center">
                      <h3>Apakah anda yakin ???</h3>
                      <h4>ClearData(3)</h4>
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
                      <button type="button" id="swipedataabsensi" class="btn btn-outline btn-warning col-md-5"><b>Ya !</b></button>
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
<script src="/js/fm/absensi.js"></script>
@stop
