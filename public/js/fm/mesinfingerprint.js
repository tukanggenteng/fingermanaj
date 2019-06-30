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
                                  var aksi = '<a href="/pegawai/jumlahfingerpegawai_m/'+data.PIN2+'/'+data.Name+'" class="btn btn-primary">Cek/Tambah Finger <i class="fa fa-search"></i></a><a href="/absensi/daftarabsensi_mp/'+data.PIN2+'/'+data.Name+'" class="btn btn-primary">Cek Absensi <i class="fa fa-search"></i></a><button class="hapus_'+data.PIN2+' hapusfinger btn btn-danger" id="hapusf"><i class="fa fa-trash"></i></button>';
                                  return aksi;
                              }
                           },
                        ]
                      } );

    $('#refresh').click(function(){
      datatabelf.ajax.reload();
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
                  id:id,
                  nama:nama,
                  _token:_token
                  },
          success:function(response){
            if((response.status==1)){
                $('.error').addClass('hidden');
                swal("Sukses Menghapus Data "+response.nama, "", "warning");
                $('#modal_add').modal('hide');
                //console.log(response.nama);
                datatabelf.ajax.reload();
            }
            else
              {
                $('.error').addClass('hidden');
                swal("Terjadi Kesalahan", "", "error");
                $('#modal_add').modal('hide');
                //console.log(response);
                datatabelf.ajax.reload();
                }
          },
      });
    });
    // ./hapus data pegawai-----------------------------------------------------------

    //Wipe data pegawai-----------------------------------------------------------
    $(document).on('click','#swipedatapegawai',function (){
      var _token= $("input[name=_token]").val();

      //alert("data "+nama);
      $.ajax({
          type:'post',
          url:'/wipedata',
          data : {
                  _token:_token
                  },
          success:function(response){
            if((response.status==1)){
                $('.error').addClass('hidden');
                swal("Sukses Menghapus Semua Data pada mesin!", "", "warning");
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
