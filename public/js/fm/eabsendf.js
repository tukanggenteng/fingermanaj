// data table
var datatabelf = $('#datapegawaifinger').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/pegawai/dtdatapegawai_m",
                    columns: [
                          { data: 'PIN'},
                          { data: 'PIN2' },
                          { data: 'Name' },
                          { data: 'Privilege' },
                          { data: null }, //jika ingin mengisi data pada opsi columnDefs, parameter bagian ini harus diisi oleh null

                      ],
                      columnDefs: [
                          { targets: [0,1,3] , className: 'text-right' },
                          { targets: [2] , className: 'text-left' },
                          {
                            targets: [4] ,className: 'text-center',
                            'render': function (data, type, row) {
                                var aksi1 = '<button class="hapus_'+data.PIN2+' hapusfinger btn btn-info" id="tambahf"><i class="fa fa-thumbs-o-up"></i><i class="fa fa-download"></i></button>';
                                var aksi2 = '<button class="hapus_'+data.PIN2+' hapusfinger btn btn-danger" id="hapusf"><i class="fa fa-thumbs-o-up"></i><i class="fa fa-trash"></button>';
                                var aksi = aksi1+aksi2;
                                return aksi;
                            }
                         },
                      ]
                    } );
//--------------------------------------------------
