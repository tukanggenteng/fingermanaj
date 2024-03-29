{{-- resources/views/konfigurasi.blade.php --}}

@extends('adminlte::page')

@section('title', 'Konfigurasi')

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
                      <h3 class="box-title">Daftar Alamat IP yang biasa digunakan :</h3>
                    <hr>
                      <button type="button" class="btn btn-success cek_ip form-control flat" id="cek_kondisi_ip">Cek Kondisi Alamat IP di dalam daftar</button>
                    <hr>
                    <table class="table table-bordered thead-dark table-striped table-hover dataTable no-footer" id="daftaralamatip">
                      <thead>
                        <tr class="bg-navy text-center">
                          <td>No</td>
                          <td>Alamat IP</td>
                          <td>Status</td>
                          <td>Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($alamatips as $alamatip)
                            <tr role="row">
                              <td class="col-md-1 text-right">{{ $loop->iteration }}</td>
                              <td class="col-md-8">{{ $alamatip->alamat }}</td>
                              <td class="col-md-1 text-center">
                                <span id="lightbulb_{{$loop->iteration}}" class="lightbulb"><i class="fas fa-lightbulb fa-2x" style=""></i></span>
                                <span id="load_{{$loop->iteration}}" style="position:absolute"></span>
                              </td>
                              <td class="col-md-2 text-center">
                                <form action="{{route('alamatip.destroy',$alamatip->id)}}" method="post">
                                  <button type="button" class="btn btn-success set-ip">SET</button>
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

          <div class="col-md-6">
              <!-- Konfigurasi IP -->
              <div class="box box-default ">
                <div class="box-header with-border">
                  <h3 class="box-title"><strong>Konfigurasi Alamat IP</strong></h3>
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
                      <div class="text-center"><h3>Alamat IP yang digunakan saat ini : <strong><span id="data_ip" class="data_ip"></span></strong></h3></div>
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
                        <button type="button" class="btn btn-success btn-flat form-control" id="cekkon">Cek Koneksi Alamat IP yang digunakan</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.box-footer-->
                </div>
                <!--/.Cek Koneksi -->

                <!-- Konfigurasi IP -->
                <div class="box box-default ">
                  <div class="box-header with-border">
                    <h3 class="box-title"><strong>Konfigurasi Server Absensi yang digunakan</strong></h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        @if (session('pesan_sv'))
                            <div class="alert alert-warning fade in alert-dismissible text-center">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <i class="fa fa-warning"></i> <strong>{{ session('pesan_sv') }}</strong>
                            </div>
                        @endif
                        @if (session('success_sv'))
                            <div class="alert alert-success fade in alert-dismissible text-center">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <i class="fa fa-warning"></i> <strong>{{ session('success_sv') }}</strong>
                            </div>
                        @endif
                        @if (session('error_sv'))
                            <div class="alert alert-danger fade in alert-dismissible text-center">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <i class="fa fa-warning"></i> <strong>{{ session('error_sv') }}</strong>
                            </div>
                        @endif
                        <hr>
                        <div class="text-center"><h3>Server yang digunakan saat ini : <strong><span id="data_sv" class="data_sv"></span></strong></h3></div>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <form action="{{route('urlaccess.store')}}" method="post">
                      <div class="input-group">
                        @csrf
                        <input type="text" name="url_server" placeholder="Isikan Alamat URL Server ..." class="form-control">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-success btn-flat" style=" width: 100px;"><i class="fa fa-save"></i></button>
                            </span>
                      </div>
                    </form>
                    <hr>
                    <table class="table table-bordered thead-dark table-striped table-hover dataTable no-footer" id="daftaralamatip">
                      <thead>
                        <tr class="bg-navy text-center">
                          <td>No</td>
                          <td>Alamat Server</td>
                          <td>Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($alamatservers as $alamatserver)
                            <tr role="row">
                              <td class="col-md-1 text-right">{{ $loop->iteration }}</td>
                              <td class="col-md-9">{{ $alamatserver->url_server }}<span id="loadsv_{{$loop->iteration}}" style="position:absolute"></span></td>
                              <td class="col-md-2 text-center">
                                <form action="{{route('urlaccess.destroy',$alamatserver->id)}}" method="post">
                                  <button type="button" class="btn btn-success set-sv">SET</button>
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
                  <!-- /.box-footer-->
                </div>
                <!--/.Konfigurasi IP -->

              </div>


      </div> <!--/.Row -->

      <div class="row"><!--Row 2 -->
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
      </div> <!--/.Row 2 -->

      <div class="row"> <!-- Row 3 -->



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
                        <h4>ClearData(1)</h4>
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
<link href="{{ asset('/css/gitcdn.github.io/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css') }}" rel="stylesheet">
<!--css custom section   -->
<!-- code below -->
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
<!--javascript custom section   -->
<!-- code below -->
<script src="/js/unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/gitcdn.github.io/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
<script src="/js/fm/mesinkon.js"></script>
@stop
