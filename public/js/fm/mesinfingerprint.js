$(document).ready(function() {
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
                                  var aksi1 = '<a href="/pegawai/pinpegawai_m_v/'+data.PIN2+'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Tambah/Edit PIN">[PIN]</i><i class="fa fa-search"></i></a>';
                                  var aksi2 = '<a href="/pegawai/jumlahfingerpegawai_m/'+data.PIN2+'/'+data.Name+'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Cek/Tambah Finger"><i class="fa fa-thumbs-up"></i><i class="fa fa-search"></i></a>';
                                  var aksi3 = '<a href="/absensi/daftarabsensi_mp/'+data.PIN2+'/'+data.Name+'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Cek Absensi"><i class="fa fa-calendar"></i><i class="fa fa-search"></i></a>';
                                  var aksi4 = '<button class="hapus_'+data.PIN2+' hapusfinger btn btn-danger" id="hapusf" data-toggle="tooltip" data-placement="top" title="Menghapus Data Pegawai!"><i class="fa fa-trash"></i></button>';
                                  var aksi = aksi1+' '+aksi2+' '+aksi3+' '+aksi4;
                                  return aksi;
                              }
                           },
                        ]
                      } );

    $('#refresh').click(function(){
      datatabelf.ajax.reload(null, false);
    });

    // Tambah Data Pegawai-----------------------------------------------------------
    $(document).on('click','#addpegawai',function (){
      var pin=$('#ID').val();
      var nama=$('#nama').val();
      // nama = nama.replace("'","\\'");
      var _token=$("input[name=_token]").val();
      $.ajax({
          type:'post',
          url:'/pegawai/tambahpegawai',
          data : {
                  ID:pin,
                  nama:nama,
                  _token:_token
                  },
          success:function(response){
              if((response.status!=0)){
                  $('.error').addClass('hidden');
                  swal("Sukses Menambah Data "+response.nama, "", "success");
                  $('#modal_add').modal('hide');
                  //console.log(response.nama);
                  datatabelf.ajax.reload();
              }
              else
                {
                  $('.error').addClass('hidden');
                  swal(response.pesan, "", "error");
                  $('#modal_add').modal('hide');
                  //console.log(response);
                  datatabelf.ajax.reload();
                  }
            },
        });
      });
      // ./Tambah Data Pegawai-----------------------------------------------------------

    //hapus data pegawai-----------------------------------------------------------
    $(document).on('click','.hapusfinger',function (){
      var currentRow = $(this).closest('tr');
      var id = currentRow.find('td:eq(1)').text();
      var nama = currentRow.find('td:eq(2)').text();
      var _token= $("input[name=_token]").val();

      //alert("data "+nama);
      $.ajax({
          type:'post',
          url:'/pegawai/hapuspegawai',
          data : {
                  ID:id,
                  nama:nama,
                  _token:_token
                  },
          success:function(response){
            if((response.status==1)){
                $('.error').addClass('hidden');
                swal("Sukses Menghapus Data "+response.nama, "", "warning");
                $('#modal_add').modal('hide');
                //console.log(response.nama);
                datatabelf.ajax.reload(null, false);
            }
            else
              {
                $('.error').addClass('hidden');
                swal("Terjadi Kesalahan", "", "error");
                $('#modal_add').modal('hide');
                //console.log(response);
                datatabelf.ajax.reload(null, false);
                }
          },
      });
    });
    // ./hapus data pegawai-----------------------------------------------------------

    //Wipe data pegawai-----------------------------------------------------------
    // clear data (1)
    $(document).on('click','#swipedatapegawai',function (){
      var _token= $("input[name=_token]").val();

      //alert("data "+nama);
      $.ajax({
          type:'post',
          url:'/wipedata',
          data : {
                  opsi: 1,
                  _token:_token
                  },
          success:function(response){
            if((response.status==1)){
                $('.error').addClass('hidden');
                swal("Sukses Menghapus Semua Data Pegawai pada mesin!", "", "warning");
                $('#modal_swipe').modal('hide');
                //console.log(response.nama);
                datatabelf.ajax.reload();
            }
            else
              {
                $('.error').addClass('hidden');
                swal("Terjadi Kesalahan", "", "error");
                $('#modal_swipe').modal('hide');
                //console.log(response);
                datatabelf.ajax.reload();
                }
          },
      });
    });
    // ./Wipe data pegawai-----------------------------------------------------------



} ); //END LINE FUNCTION

$(document).hover(function(){ $('[data-toggle="tooltip"]').tooltip(); });
