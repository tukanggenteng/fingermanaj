{{-- resources/views/konfigurasi.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Pegawai di Masin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Konfigurasi</h1>
@stop

@section('content')
      <div class="col-md-6">
          <!-- Konfigurasi IP -->
          <div class="box box-warning ">
            <div class="box-header with-border">
              <h3 class="box-title">Konfigurasi Alamat IP</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  Alamat IP yang digunakan saat ini :
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <form action="#" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Isikan Alamat IP ..." class="form-control">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-flat">Perbaharui</button>
                      </span>
                </div>
              </form>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.Konfigurasi IP -->
        </div>

        <div class="col-md-6">
            <!-- Cek Koneksi -->
            <div class="box box-warning ">
              <div class="box-header with-border">
                <h3 class="box-title">Cek Koneksi</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    Alamat IP yang digunakan saat ini :
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <form action="#" method="post">
                  <div class="">
                    <button type="button" class="btn btn-success btn-flat form-control">Cek Koneksi</button>
                  </div>
                </form>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.Cek Koneksi -->
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
<script src="/js/fm/eabsendp.js"></script>
@stop
