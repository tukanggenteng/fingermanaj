$(document).ready(function() {

  var datatabelf = $('#datapegawaifinger').DataTable();
  // Tambah Data Pegawai-----------------------------------------------------------
  $(document).on('click','#addpegawai_dpf',function (){
    var instansi=$('#instansi').val();
    $("#datadarieabsen").html("<table id='datapegawaifinger' class='table table-bordered thead-dark table-striped table-hover'><thead 'class=bg-navy'><tr><th class='col-md-1'>No</th><th class='col-md-1'>ID</th><th class='col-md-6'>Nama</th></tr></thead><tbody></tbody></table>");
    datatabelf.destroy();
    datatabelf = $('#datapegawaifinger').DataTable( {
                        "processing": true,
                        "serverSide": true,
                        "ajax": "/cekpegawai_f_eabsen/"+instansi,
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
    $('#modal_add_dpf').modal('hide');
    $("#datadarieabsen").removeAttr("style");

    var datainstansi = '<input type="hidden" name="datainstansi" id="datainstansi" value='+instansi+'>';
    var tombolaksi = '<button class="btn btn-warning form-control" name="tambahdata" id="tambahdata">Tambahkan data ke mesin fingerprint</button>'
    $("#aksitambahdata").html(datainstansi+tombolaksi);


    });
    // ./Tambah Data Pegawai-----------------------------------------------------------

    // Tambah Data Pegawai ke finger-----------------------------------------------------------
    $(document).on('click','#tambahdata',function (){
      $("#datadarieabsen").fadeOut("slow", function() {
        $('#datapegawaifinger').remove(); //function after animation finishded
        $('#tambahdata').remove();
      });

      var d_instansi=$('#datainstansi').val();
      $.getJSON('http://eabsen.kalselprov.go.id/api/cekpegawai/'+d_instansi,function(data){
            //jalankan fungsi di dalam sini
      });
      //var panjang = datapegawai.responseJSON.length;
      //console.log(datapegawai);
      //alert('data instansi : '+d_instansi);
    });
    // ./Tambah Data Pegawai-----------------------------------------------------------


} ); //END LINE FUNCTION
