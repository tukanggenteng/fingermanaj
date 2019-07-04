{{-- resources/views/datamac.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data MAC address di Masin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Data MAC Address</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <h3><b>Data MAC :</b></h3>
              <h4>{{$mac}}</h4>
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
              <button type="button" id="simpanaddpegawai" class="btn btn-primary">Simpan</button>
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
@stop
