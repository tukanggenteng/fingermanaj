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
              <button class="btn btn-info form-control" id="peringatanwipe" data-toggle="modal" id="tambah" data-target="#modal_swipe">Donwload Semua Data Sidik Jari ke dalam mesin fingerprint scan <i class="fa fa-download"></i></button>
              <hr>
              <button class="btn btn-danger form-control" id="peringatanwipe" data-toggle="modal" id="tambah" data-target="#modal_swipe">Hapus Semua Data Sidik Jari di dalam mesin fingerprint scan <i class="fa fa-trash"></i></button>
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
<script src="/js/fm/eabsendf.js"></script>
<script>
//komentar?
</script>
@stop
