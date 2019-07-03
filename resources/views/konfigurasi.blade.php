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
          <div class="box box-default ">
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
                  <div class="text-center"><h3>Alamat IP yang digunakan saat ini : <strong>{{ $session_d }}</strong></h3></div>
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

        <div class="col-md-6">
          <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" id="wipe_modal" data-target="#modal_wipe">
            <div class="col-md-6 col-lg-4 col-xs-6">
            <!-- small box -->
                <div class="inner">
                  <h3>Wipe Data <i class="fa fa-trash"></i></h3>

                  <p>Hapus semua data</p>
                </div>
                <p class="small-box-footer"></p>
            </div>
          </button>
        </div>

      </div> <!--/.Row -->

      <div class="row"><!--Row 2 -->
        <div class="col-md-6">
            <!-- Cek Koneksi -->
            <div class="box box-default ">
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="" id="hasil"></div>
                    <div class="" id="progress" style="display:none;">
                      <div id="progress_b" class="">
                        <div class="progress active">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                      </div>
                    </div>
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

      <div class="row"> <!-- Row 3 -->
        <div class="col-md-6">
            <!-- Konfigurasi IP -->
            <div class="box box-default ">
              <div class="box-header with-border">
                <h3 class="box-title">Daftar Alamat IP yang biasa digunakan :</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    @if (session('pesan_ip'))
                        <div class="alert alert-warning fade in alert-dismissible text-center">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <i class="fa fa-warning"></i> <strong>{{ session('pesan_ip') }}</strong>
                        </div>
                    @endif
                    @if (session('success_ip'))
                        <div class="alert alert-success fade in alert-dismissible text-center">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <i class="fa fa-warning"></i> <strong>{{ session('success_ip') }}</strong>
                        </div>
                    @endif
                    @if ($errors->has('alamatip'))
                        <div class="alert alert-danger fade in alert-dismissible text-center">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <i class="fa fa-warning"></i> <strong>{{ $errors->first('alamatip') }}</strong>
                        </div>
                    @endif
                    <hr>
                    <form action="{{route('alamatip.store')}}" method="post">
                      <div class="input-group">
                        @csrf
                        <input type="text" name="alamatip" placeholder="Isikan Alamat IP ..." class="form-control">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-success btn-flat" style=" width: 100px;"><i class="fa fa-save"></i></button>
                        </span>

                      </div>
                    </form>
                    <hr>
                    <table class="table table-bordered thead-dark table-striped table-hover dataTable no-footer">
                      <tbody>
                        @foreach($alamatips as $alamatip)
                            <tr role="row">
                              <td class="col-md-1">{{ $loop->iteration }}</td>
                              <td class="col-md-11">{{ $alamatip->alamat }}</td>
                              <td><input id="toggle-one" type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"></td>
                              <td class="col-md-1"><i class="fas fa-lightbulb fa-2x border border-dark" style="color:yellow; text-shadow: 2px 2px 4px #000000;"></i></td>
                              <td class="col-md-1">
                                <form action="{{route('alamatip.destroy',$alamatip->id)}}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                              </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">

              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.Konfigurasi IP -->
          </div>


        </div> <!--/.Row 3-->


      <!-- modal Wipe data-->
      <div class="modal modal-danger fade" id="modal_wipe">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title text-center text-error"><b>Wipe semua Data <i class="fa fa-warning"></i><b></h3>
            </div>
            <div class="modal-body">
              <div class="error alert-danger alert-dismissible">
              </div>
              <form id="formpegawaiadd" method="post" role="form" enctype="multipart/form-data" action="">


                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group text-center">
                        <h3>Semua Data yang ada di dalam mesin Finger Scan akan dihapus</h3>
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
                        <button type="button" id="wipedata_" class="btn btn-outline btn-warning col-md-5"><b>Ya !</b></button>
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
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<!--css custom section   -->
<!-- code below -->
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
<!--javascript custom section   -->
<!-- code below -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="/js/fm/mesinkon.js"></script>
@stop
