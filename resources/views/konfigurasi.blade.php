{{-- resources/views/konfigurasi.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Pegawai di Masin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Konfigurasi</h1>

@stop

@section('content')
    <div class="row">
      <div class="col-md-6">
          <!-- Konfigurasi IP -->
          <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Konfigurasi Alamat IP</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  @if (session('pesan'))
                      <div class="alert alert-warning fade in alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="fa fa-warning"></i> <strong>{{ session('pesan') }}</strong>
                      </div>
                  @endif
                  @if (session('success'))
                      <div class="alert alert-success fade in alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="fa fa-warning"></i> <strong>{{ session('success') }}</strong>
                      </div>
                  @endif
                  @if (session('error'))
                      <div class="alert alert-danger fade in alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="fa fa-warning"></i> <strong>{{ session('error') }}</strong>
                      </div>
                  @endif
                  <hr>
                  <div class="text-center">Alamat IP yang digunakan saat ini : <strong>{{ $session_d }}</strong></div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <form action="{{route('mesin.konfig_set')}}" method="post">
                <div class="input-group">
                  @csrf
                  <input type="text" name="alamat_ip" placeholder="Isikan Alamat IP ..." class="form-control">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-success btn-flat">Perbaharui</button>
                      </span>
                </div>
              </form>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.Konfigurasi IP -->
        </div>

      </div> <!--/.Row -->

      <div class="row"><!--Row 2 -->
        <div class="col-md-6">
            <!-- Cek Koneksi -->
            <div class="box box-info ">
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="" id="waktu"></div>
                    <div class="" id="progress"></div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <form action="#" method="post">
                  <div class="">
                    <button type="button" class="btn btn-success btn-flat form-control" id="cekkon">Cek Koneksi</button>
                  </div>
                </form>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.Cek Koneksi -->
          </div>
      </div> <!--/.Row 2 -->

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
