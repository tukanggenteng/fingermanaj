$(document).ready(function() {

  //var--------------
  var datatabelf = $('#datapegawaifinger').DataTable();
  //------------------------------------------------------------------------------

  //function------------------------------------------------------------------------------
  //+set tabel data pegawai
  function tabelDataPegawai()
  {
     $("#datadarieabsen").html("<table id='datapegawaifinger' class='table table-bordered thead-dark table-striped table-hover'><thead 'class=bg-navy'><tr><th class='col-md-1'>ID</th><th class='col-md-1'>NIP</th><th class='col-md-6'>Nama</th></tr></thead><tbody></tbody></table>");
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
            //jalankan fungsi di dalam sini
            var jumlahData = data.length;
            for(var i=0;i<jumlahData;i++)
            {
                console.log(data[i]);
            }
      });
  }
  //-------------------------------
  //+simpan data ke mesin fingerprint
  function simpankeF(url, d_ins)
  {
    $.getJSON(url+d_ins,function(data){
            //jalankan fungsi di dalam sini
            console.log(data);
      });
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
    // ./Tambah Data Pegawai-----------------------------------------------------------

    // Tambah Data Pegawai ke finger-----------------------------------------------------------
    $(document).on('click','#tambahdata',function (){
      $("#datadarieabsen").fadeOut("slow", function() {
        $('#datapegawaifinger').remove(); //function after animation finishded
        $('#tambahdata').remove();
      });

      var d_instansi=$('#datainstansi').val();
      var url_dp=$('#url_dp').val();
      getDataFrom(url_dp, d_instansi);

    });
    // ./Tambah Data Pegawai-----------------------------------------------------------


} ); //END LINE FUNCTION
