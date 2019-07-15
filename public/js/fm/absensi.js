var datatabelf = $('#datasemuaabsensi').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/absensi/dtdaftarabsensi",
                    columns: [
                          { data: 'no'},
                          { data: 'id' },
                          { data: 'nama' },
                          { data: 'tanggal' },
                          { data: 'jam' },
                          { data: 'keteranganabsen' },

                      ],
                      columnDefs: [
                          { targets: [0,1] , className: 'text-right' },
                          { targets: [2] , className: 'text-left' },
                          { targets: [3,4] ,className: 'text-center'},
                          {
                            targets: [5] ,className: 'text-center',
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
    datatabelf.ajax.reload(null, false);
  });
  //Wipe data pegawai-----------------------------------------------------------
  // clear data (1)
  $(document).on('click','#swipedataabsensi',function (){
    var _token= $("input[name=_token]").val();

    //alert("data "+nama);
    $.ajax({
        type:'post',
        url:'/wipedata',
        data : {
                opsi: 3,
                _token:_token
                },
        success:function(response){
          if((response.status==1)){
              $('.error').addClass('hidden');
              swal("Sukses Menghapus Semua Data Absensi pada mesin!", "", "warning");
              $('#modal_swipe_a').modal('hide');
              //console.log(response.nama);
              datatabelf.ajax.reload(null, false);
          }
          else
            {
              $('.error').addClass('hidden');
              swal("Terjadi Kesalahan", "", "error");
              $('#modal_swipe_a').modal('hide');
              //console.log(response);
              datatabelf.ajax.reload(null, false);
              }
        },
    });
  });
  // ./Wipe data pegawai-----------------------------------------------------------
