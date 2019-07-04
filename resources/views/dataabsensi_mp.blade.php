{{-- resources/views/dataabsensi_mp.blade.php --}}

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
              <h2>Data Absensi dari : {{$nama}}</h2>
              <button class="btn btn-info" id="refresh">Refresh <i class="fa fa-refresh"></i></button>

              <hr>
              <table id="dataabsensipegawai" class="table table-bordered thead-dark table-striped table-hover">
                <thead class="bg-navy">
                  <tr>
                    <th class="col-md-1">No</th>
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
<script>

  var datatabelf = $('#dataabsensipegawai').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      "ajax": "/absensi/dtdaftarabsensi_p/"+{{$id}},
                      columns: [
                            { data: 'no'},
                            { data: 'tanggal' },
                            { data: 'jam' },
                            { data: 'keteranganabsen' },

                        ],
                        columnDefs: [
                            { targets: [0] , className: 'text-right' },
                            { targets: [1,2] ,className: 'text-center'},
                            {
                              targets: [3] ,className: 'text-center',
                              "render" : function ( data, type, row, meta ) {
                                if(data=='Masuk') { dataN = "<i class='fa fa-sign-in'></i> "+data; }
                                else if(data=='Pulang') { dataN = data+" <i class='fa fa-sign-out'></i>"; }
                                else if(data=='Mulai Istirahat') { dataN = data+" <i class='fa fa-sign-out'></i>"; }
                                else if(data=='Selesai Istirahat') { dataN = "<i class='fa fa-sign-in'></i> "+data; }
                                else { dataN = "<i class='fa fa-warning'></i> Tidak ada Data"; }

                                return dataN;
                              }
                            },
                        ]
                      } );

    $('#refresh').click(function(){
      datatabelf.ajax.reload();
    });
</script>
@stop
