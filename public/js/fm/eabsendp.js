

  //var--------------
  var datatabelf = $('#datapegawaifinger').DataTable();
  //------------------------------------------------------------------------------

  //function------------------------------------------------------------------------------
  //+set tabel data pegawai
  function tabelDataPegawai()
  {
     $("#datadarieabsen").html("<table id='datapegawaifinger' class='table table-bordered thead-dark table-striped table-hover'><thead class='bg bg-navy'><tr><th class='col-md-1'>ID</th><th class='col-md-1'>NIP</th><th class='col-md-6'>Nama</th></tr></thead><tbody></tbody></table>");
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

                              ],
                              columnDefs: [
                                  { targets: [0] , className: 'text-right' },
                                  { targets: [2] , className: 'text-left' },
                                  { targets: [1] , className: 'text-center' },
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
                  pin:pin,
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
    var bar1 ='<div class="progress row">';
    var bar2 ='<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'+valuenow+'" aria-valuemin="0" aria-valuemax="'+valuemax+'" style="width: '+stylewidth+'%"></div>';
    var bar3 ='</div>';
    var barfoot ='</div>';
    $("#progresstambah").html(barhead+bardata+barpersen+bar1+bar2+bar3+barfoot);
  }
  //-------------------------------

  //+simpan data ke mesin fingerprint
  function datatambah(nip, nama)
  {
      var datahead = '<div class="container"><div class="row">';
      var dataisi = '<p class="col mb-1 bg-success text-success"> <i class="fa fa-plus"></i> menambahkan = NIP : '+nip+', Nama : '+nama+'</p>';
      var datafoot = '</div></div>';
      $("#datatambah").prepend(datahead+dataisi+datafoot);
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

    //fungsi tombol modal untuk menghapus data html
    $(document).on('click','#tambah_dpf',function (){ $('#progresstambah').empty(); $('#datatambah').empty(); }); //jangan menghapus id rootnya
    $(document).on('click','#tambah_dptf',function (){ $('#progresstambah').empty(); $('#datatambah').empty(); });
    //---------------------------------------------
