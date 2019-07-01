{{-- resources/views/datapegawai_m.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Pegawai di Masin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Download Data Finger dari eabsen.kalselprov.go.id</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
              <div class="alert alert-info fade in alert-dismissible text-center">
                <i class="fa fa-warning"></i> Tombol 'Download Semua'/'Hapus Semua' menambahkan/menghapuskan sesuai dengan jumlah baris yang tampil pada halaman <i class="fa fa-warning"></i></br>
                Bila ingin menambahkan/menghapuskan semua data sidik jari sejumlah total data entri,</br>
                PILIH [Show Entri] sejumlah lebih atau sama dengan total Entri data!
                </br></br>
                *<i>Fungsi perbaris tidak terpengaruh kondisi seperti yang diterangka di atas!</i>
              </div>
              <button class="btn btn-info" id="refresh">Refresh <i class="fa fa-refresh"></i></button>
              <button class="btn btn-info" id="clearprogres">Clear Laporan Progres <i class="fa fa-refresh"></i></button>
            </div>
            <div class="box-body">
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
              <div id="progresstambah"></div>
              <div class="container">
                <div class="row">
                  <div id="datatambah" class="timeline" style="overflow-y: scroll; max-height: 600px"></div>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button class="btn btn-info form-control" id="download" >Donwload Semua Data Sidik Jari ke dalam mesin fingerprint scan <i class="fa fa-download"></i></button>
              <hr>
              <button class="btn btn-danger form-control" id="peringatanhapus" data-toggle="modal" data-target="#modal_hapus">Hapus Semua Data Sidik Jari di dalam mesin fingerprint scan <i class="fa fa-trash"></i></button>
            </div>
          </form>
          </div>
      </div>
    </div>

    <!-- modal Hapus data Fingerprint-->
    <div class="modal modal-danger fade" id="modal_hapus">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title text-center text-error"><b>Hapus Data Sidik Jari<i class="fa fa-warning"></i><b></h3>
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
                      <h3>Semua Data Sidik Jari Pegawai akan dihapus</h3>
                    </div>
                    <div class="form-group text-center">
                      <h3>Apakah anda yakin ???</h3>
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
                      <button type="button" id="hapussemuadatafp" class="btn btn-outline btn-warning col-md-5"><b>Ya !</b></button>
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
<script src="/js/fm/eabsendf.js"></script>
<script>
//komentar?
</script>
@stop
