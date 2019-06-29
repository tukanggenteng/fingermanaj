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
                                var aksi1 = '<button class="upload_'+data.PIN2+' uploadfinger btn btn-info" id="uploadf"><i class="fa fa-thumbs-o-up"></i><i class="fa fa-upload"></i></button>';
                                var aksi = aksi1;
                                return aksi;
                            }
                         },
                      ]
                    } );
//--------------------------------------------------

// Download data FingerPrint perorang
//-------------------------
// cek id pegawai untuk merequest jumlah data finger yang ada di server
// jumlahdata finger diketahui
// lakukan perulangan menambhkan data finger sejumlah data finger yang ada
//-------------------------
// END./Download data FingerPrint perorang

// Download data FingerPrint keseluruhan
// cek
// END./Download data FingerPrint keseluruhan
