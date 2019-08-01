{{-- resources/views/daftar_instansi.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Back Up Sidik Jari')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Daftar Data Back Up Sidik Jari</h1>
@stop

@section('content')
    <div class="row">
      <div class="content">
        <div class="box box-default">
            <div class="box-header with-border">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            </div>
            <div class="box-body">
              <button class="btn btn-primary" id="tambah" data-toggle="modal" data-target="#modal_add">Tambah Data Sidik Jari <i class="fas fa-fingerprint"></i></button>
              <button class="btn btn-info" id="refresh">Refresh <i class="fa fa-refresh"></i></button>
              <hr>
              <table id="datasidikjari" class="table table-bordered thead-dark table-striped table-hover">
                <thead class="bg-navy">
                  <tr>
                    <th class="col-md-1">ID Sidik Jari</th>
                    <th class="col-md-1">Nama</th>
                    <th class="col-md-1">Keterangan</th>
                    <th class="col-md-1">ID Pegawai</th>
                    <th class="col-md-1">Ditambahkan</th>
                    <th class="col-md-1">Diperbaharui</th>
                    <th class="col-md-4">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
            <div class="box-footer">
            </div>
          </form>
          </div>
      </div>
    </div>

    <!-- modal tambah data pegawai-->
    <div class="modal fade" id="modal_add">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tambah Data Sidik Jari <i class="fas fa-fingerprint"></i></h4>
          </div>
          <div class="modal-body">
            <div class="error alert-danger alert-dismissible">
            </div>
            <form id="formfpadd" method="post" role="form" enctype="multipart/form-data" action="">

              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nama</label>
                      <input id="nama_t" name="pegawai_id_t" class="form-control pull-right" type="text">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Keterangan</label>
                      <textarea id="ket_t" name="ket_t" class="col-md-10 form-control" rows="2" cols="80"></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>ID Pegawai</label>
                      <input id="pegawai_id_t" name="pegawai_id_t" class="form-control pull-right" type="text">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Data Sidik Jari</label>
                      <textarea id="template_fp_t" name="template_fp_t" class="col-md-10 form-control" rows="10" cols="80"></textarea>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
              <button type="button" id="addfp" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- modal View data Sidik Jari-->
      <div class="modal modal-default fade" id="modal_fp">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Data Sidik Jari <i class="fas fa-fingerprint"></i></h4>
            </div>
            <div class="modal-body">
              <div class="error alert-danger alert-dismissible">
              </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Nama</label>
                        <input id="nama" name="nama" class="form-control pull-right" type="text" disabled>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Keterangan</label>
                        <textarea id="ket" name="ket" class="col-md-10 form-control" rows="2" cols="80" disabled></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                 <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>ID Pegawai</label>
                        <input id="pegawai_id" name="pegawai_id" class="form-control pull-right" type="text" disabled>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                 <div class="col-md-12">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label>ID Sidik Jari</label>
                       <input id="id_fp" name="id_fp" class="form-control pull-right" type="text" disabled>
                     </div>
                   </div>
                 </div>
               </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Data Sidik Jari</label>
                        <textarea id="template_fp" name="template_fp" class="col-md-10 form-control" rows="10" cols="80" disabled></textarea>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                <button type="button" id="edit_frm_show" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#modal_edit_fp">Edit</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

      <!-- modal Edit Instansi data-->
      <div class="modal modal-warning fade" id="modal_edit_fp">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Data Sidik Jari <i class="fas fa-fingerprint"></i></h4>
            </div>
            <div class="modal-body">
              <div class="error alert-danger alert-dismissible">
              </div>
              <form id="formfpupdate" method="post" role="form" enctype="multipart/form-data" action="">
                 @csrf

                 <div class="row">
                   <div class="col-md-12">
                     <div class="col-md-12">
                       <div class="form-group">
                         <label>Nama</label>
                         <input id="nama_e" name="nama_e" class="form-control pull-right" type="text">
                       </div>
                     </div>
                   </div>
                 </div>

                 <div class="row">
                   <div class="col-md-12">
                     <div class="col-md-12">
                       <div class="form-group">
                         <label>Keterangan</label>
                         <textarea id="ket_e" name="ket_e" class="col-md-10 form-control" rows="2" cols="80"></textarea>
                       </div>
                     </div>
                   </div>
                 </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>ID Pegawai</label>
                        <input id="pegawai_id_e" name="pegawai_id_e" class="form-control pull-right bg-yellow" type="text" disabled>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>ID Sidik Jari</label>
                        <input id="id_fp_e" name="id_fp_e" class="form-control pull-right bg-yellow" type="text" disabled>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Data Sidik Jari</label>
                        <textarea id="template_fp_e" name="template_fp_e" class="col-md-10 form-control" rows="10" cols="80"></textarea>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                <button type="button" id="updatefp" class="btn btn-primary">Update</button>
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
<script src="/js/unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/fm/sidikjari.js"></script>
@stop
