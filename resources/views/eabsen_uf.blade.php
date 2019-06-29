{{-- resources/views/datapegawai_m.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Pegawai di Masin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Upload Data Finger ke eabsen.kalselprov.go.id</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
              <div class="alert alert-warning fade in alert-dismissible text-center">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-warning"></i> <strong> Fungsi Menu ini belum dikembangkan...</strong>
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
            </div>
            <div class="box-footer">
              <button class="btn btn-info form-control" id="upload" id="upload">Upload Semua Data Sidik Jari di dalam mesin fingerprint scan <i class="fa fa-upload"></i></button>
            </div>
          </form>
          </div>
      </div>
    </div>

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
<script src="/js/fm/eabsenuf.js"></script>
@stop
