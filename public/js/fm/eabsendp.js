

  //var--------------
  var datatabelf = $('#datapegawaifinger').DataTable();
  //------------------------------------------------------------------------------

  //function------------------------------------------------------------------------------
  //+set tabel data pegawai
  function tabelDataPegawai()
  {
     var table = "<table id='datapegawaifinger' class='table table-bordered thead-dark table-striped table-hover'><thead class='bg bg-navy'>";
     var row = "<tr>";
     var column = "<th class='col-md-1'>ID</th><th class='col-md-1'>NIP</th><th class='col-md-6'>Nama</th><th class='col-md-1'>Aksi</th>";
     var row_end = "</tr>";
     var table_end = "</thead><tbody></tbody></table>";
     $("#datadarieabsen").html(table+row+column+row_end+table_end);
  }
  //-------------------------------

  // + callDataTable
  function callDT(url, instansi)
  {
      if(instansi=='') { instansi = 1; }
      else
      {
        datatabelf = $('#datapegawaifinger').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax": url+instansi,
                            columns: [
                                  { data: 'id'},
                                  { data: 'nip' },
                                  { data: 'nama' },
                                  { data: null },

                              ],
                              columnDefs: [
                                  { targets: [0] , className: 'text-right' },
                                  { targets: [2] , className: 'text-left' },
                                  { targets: [1] , className: 'text-center' },
                                  {
                                    targets: [3] ,className: 'text-center',
                                    'render': function (data, type, row) {
                                        var aksi = '<button class="tambah_'+data.PIN2+' btn btn-info" id="tambahp"><i class="fas fa-user"></i><i class="fa fa-download"></i></button>';
                                        return aksi;
                                    }
                                  }
                              ]
                            } );
      }
  }
  //-------------------------------
  //+get data from file or url
  function getDataFrom(url, d_ins)
  {
    $.getJSON(url+d_ins,function(data){

            var jumlahData = data.length;

            var valuemax = jumlahData;
            var valuemin = 0;
            var valuenow = 0;
            var stylewidth = 0;
            var init_p =1;
            //progress bar--------------
            progresstambah(valuenow, valuemax, stylewidth);
            //--------------------------
            for(var i=0;i<jumlahData;i++)
            {
                valuenow = init_p;
                stylewidth = ((init_p/jumlahData)*100).toFixed(2); // toFixed for fixed point notation
                simpankeF(data[i].id, data[i].nip, data[i].nama, valuenow, valuemax, stylewidth );

                init_p++;
            }
      });
  }
  //-------------------------------
  //+simpan data ke mesin fingerprint
  function simpankeF(pin, nip, nama, valuenow, valuemax, stylewidth)
  {
      var _token=$("input[name=_token]").val();
      $.ajax({
          type:'post',
          url: '/pegawai/tambahpegawai',
          data : {
                  ID:pin,
                  nama:nama,
                  _token:_token
                  },
          success:function(response){
              if((response.status!=0)){
                progresstambah(valuenow, valuemax, stylewidth);
                datatambah(nip, nama);
              }
              else
                {
                  $('#progresstambah').html("error proses");
                  console.log(response);
                }
            },
        });
  }
  //-------------------------------

  //+simpan data ke mesin fingerprint
  function progresstambah(valuenow, valuemax, stylewidth)
  {
    var barhead ='<div id="progress_b" class="container">';
    var bardata ='<div class="row"><div class="col pull-left">Jumlah Data : '+valuenow+' / '+valuemax+'</div>';
    var barpersen ='<div class="col pull-right">'+stylewidth+'%</div></div>';
    var bar1 ='<div class="progress active row">';
    var bar2 ='<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'+valuenow+'" aria-valuemin="0" aria-valuemax="'+valuemax+'" style="width: '+stylewidth+'%"></div>';
    var bar3 ='</div>';
    var barfoot ='</div>';
    $("#progresstambah").html(barhead+bardata+barpersen+bar1+bar2+bar3+barfoot);
  }
  //-------------------------------

  //+simpan data ke mesin fingerprint
  function datatambah(nip, nama)
  {
      var waktuattemp = timeAttemp();
      var datahead = '<li><i class="fa fa-plus bg-green"></i>';
      var dataisi1 = '<div class="timeline-item">';
      var dataisi2 = '<span class="time">'+waktuattemp+'</span>';
      var dataisi3 = '<div class="timeline-body bg-success">menambahkan <i class="fa fa-user"></i> NIP : '+nip+', Nama : '+nama+'</div>';
      var dataisi4 = '</div>';
      var datafoot = '</li>';
      $("#datatambah").prepend(datahead+dataisi1+dataisi2+dataisi3+dataisi4+datafoot).fadeIn(100);

  }
  //-------------------------------
  //+get time attempt
  function timeAttemp()
  {
      var waktu = new Date($.now());
      waktuattemp = waktu.getHours()+":"+waktu.getMinutes()+":"+waktu.getSeconds()+" "+waktu.getMilliseconds();
      return waktuattemp;
  }
  //-------------------------------

  //------------------------------------------------------------------------------

  // Tambah Data Pegawai yang sudah memiliki finger-----------------------------------------------------------
  $(document).on('click','#addpegawai_dpf',function (){
      var instansi=$('#instansi').val();
      var url = '/cekpegawai_f_eabsen/';

      tabelDataPegawai();
      datatabelf.destroy();
      callDT(url,instansi);

      $('#modal_add_dpf').modal('hide');
      $("#datadarieabsen").removeAttr("style");

      var datainstansi = '<input type="hidden" name="datainstansi" id="datainstansi" value='+instansi+'>';
      var url_dp = '<input type="hidden" name="url_dp" id="url_dp" value="http://eabsen.kalselprov.go.id/api/cekpegawai/">';
      var tombolaksi = '<button class="btn btn-warning form-control" name="tambahdata" id="tambahdata">Tambahkan data ke mesin fingerprint</button>'
      $("#aksitambahdata").html(datainstansi+url_dp+tombolaksi);

    });
    // ./Tambah Data Pegawai yang sudah memiliki finger-----------------------------------------------------------

    // Tambah Data Pegawai yang BELUM memiliki finger-----------------------------------------------------------
    $(document).on('click','#addpegawai_dptf',function (){
        var instansi=$('#instansi_b').val();
        var url = '/cekpegawai_fb_eabsen/';

        tabelDataPegawai();
        datatabelf.destroy();
        callDT(url,instansi);

        $('#modal_add_dptf').modal('hide');
        $("#datadarieabsen").removeAttr("style");

        var datainstansi = '<input type="hidden" name="datainstansi" id="datainstansi" value='+instansi+'>';
        var url_dp = '<input type="hidden" name="url_dp" id="url_dp" value="/data_fb_eabsen/">';
        var tombolaksi = '<button class="btn btn-warning form-control" name="tambahdata" id="tambahdata">Tambahkan data ke mesin fingerprint</button>'
        $("#aksitambahdata").html(datainstansi+url_dp+tombolaksi);

      });
      // ./Tambah Data Pegawai yang BELUM memiliki finger-----------------------------------------------------------

    // Tambah Data Pegawai ke finger-----------------------------------------------------------
    $(document).on('click','#tambahdata',function (){
      $("#datadarieabsen").fadeOut("slow", function() {
        $('#datapegawaifinger').empty(); //function after animation finishded
        $('#tambahdata').remove();
      });

      var d_instansi=$('#datainstansi').val();
      var url_dp=$('#url_dp').val();
      getDataFrom(url_dp, d_instansi);

    });
    // ./Tambah Data Pegawai-----------------------------------------------------------

    $(document).on('click','#tambahp',function (){
      var currentRow = $(this).closest('tr');
      var id = currentRow.find('td:eq(0)').text();
      var nip = currentRow.find('td:eq(1)').text();
      var nama = currentRow.find('td:eq(2)').text();
      var _token= $("input[name=_token]").val();
      //console.log(nama);
      $('#progresstambah').empty();
      $('#datatambah').empty();

      simpankeF(id, nip, nama, 1, 1, 100);

    });

    //fungsi tombol modal untuk menghapus data html
    $(document).on('click','#tambah_dpf',function (){ $('#progresstambah').empty(); $('#datatambah').empty(); }); //jangan menghapus id rootnya
    $(document).on('click','#tambah_dptf',function (){ $('#progresstambah').empty(); $('#datatambah').empty(); });
    //---------------------------------------------

    //untuk select data
    $('#instansi_id1').select2(
            {
            placeholder: "Pilih Instansi...",
            width: '100%',
            minimumInputLength: 1,
            ajax: {
                url: '/instansi/cari',
                //url: 'http://eabsen.kalselprov.go.id/instansi/cari', xss forbidden, harus api
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
                }
            }
        );

        $('#instansi_id2').select2(
                {
                placeholder: "Pilih Instansi...",
                width: '100%',
                minimumInputLength: 1,
                ajax: {
                    url: '/instansi/cari',
                    //url: 'http://eabsen.kalselprov.go.id/instansi/cari', xss forbidden, harus api
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                    }
                }
            );

        //END./untuk select data

        $("select.instansi_id1").change(function(){
            var selectedInstansi1 = $(this).children("option:checked").val();
            $("#instansi").val(selectedInstansi1);
        });
        $("select.instansi_id2").change(function(){
            var selectedInstansi2 = $(this).children("option:checked").val();
            $("#instansi_b").val(selectedInstansi2);
        });
