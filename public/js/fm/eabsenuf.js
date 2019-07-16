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
                                var aksi1 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-teal" id="cek_fpm" data-toggle="tooltip" data-placement="top" title="Cek Data Finger '+data.Name+' yang ada di mesin"><i class="fas fa-fingerprint"></i><i class="fa fa-search"></i>[mesin]</button>';
                                var aksi2 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-aqua" id="cek_fpea" data-toggle="tooltip" data-placement="top" title="Cek Data Finger '+data.Name+' yang ada di eabsen.kalselprov.go.id"><i class="fas fa-fingerprint"></i><i class="fa fa-search"></i>[eabsen]</button>';
                                var aksi3 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-primary" id="uploadf" data-toggle="tooltip" data-placement="top" title="Upload Data Finger '+data.Name+'"><i class="fas fa-fingerprint"></i><i class="fa fa-upload"></i></button>';
                                var aksi4 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-blue" id="uploadf_man" data-toggle="modal" data-target="#modal_uploadfp" data-toggle="tooltip" data-placement="top" title="Upload Data Finger Manual '+data.Name+'"><i class="fas fa-fingerprint"></i><i class="fa fa-upload"></i>Manual</button>';
                                var aksi5 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-blue" id="backup_fp" data-toggle="tooltip" data-placement="top" title="BackUp Data Finger '+data.Name+'"><i class="fas fa-fingerprint"></i><i class="fa fa-hdd"></i></button>';
                                var aksi = aksi1+' '+aksi2+' '+aksi3+' '+aksi4+' '+aksi5;
                                return aksi;
                            }
                         },
                      ]
                    } );
//--------------------------------------------------

//clearprogres
$('#clearprogres').click(function(){
  $('#progresstambah').empty();
  $('#datatambah').empty();
});
//----------------------
//refresh table
$('#refresh').click(function(){
  datatabelf.ajax.reload(null, false);
});
//----------------------

// Upload data FingerPrint perorang----------------------------------------------
//-------------------------
// cek id pegawai untuk merequest jumlah data finger yang ada di server
// jumlahdata finger diketahui
// lakukan perulangan menambhkan data finger sejumlah data finger yang ada
//-------------------------

$(document).on('click','#uploadf',function (){
  var currentRow = $(this).closest('tr');
  var iddarimesin = currentRow.find('td:eq(1)').text();
  var iddarieabsen = currentRow.find('td:eq(1)').text();
  var nama = currentRow.find('td:eq(2)').text();
  var url = '/eabsen/upload_dfinger';
  var _token= $("input[name=_token]").val();
  //-------- var progres
  var valuemax = 1;
  var valuemin = 0;
  var valuenow = 1;
  var stylewidth = 100;
  //console.log(nama);
  $('#progresstambah').empty();
  $('#datatambah').empty();

  progresstambah(valuenow, valuemax, stylewidth); //progress
  tambahDataFPkeServer(url, iddarimesin, iddarieabsen, nama, _token, valuenow, valuemax, stylewidth);
  //console.log(iddarimesin+iddarieabsen+nama+_token);

});
// END./Upload data FingerPrint perorang------------------------------------------

// Upload data FingerPrint Manual perorang----------------------------------------------
//-------------------------
//-------------------------
//proses mengambil data untuk diisi ke value modal
$(document).on('click','#uploadf_man',function (){
  var currentRow = $(this).closest('tr');
  var iddarimesin = currentRow.find('td:eq(1)').text();
  var nama = currentRow.find('td:eq(2)').text();
  $("#iddarimesin_man").val(iddarimesin);
  $("#nama_man").val(nama);
});
//proses setelah modal
$(document).on('click','#uploadman',function (){
  var iddarimesin = $("#iddarimesin_man").val();
  var iddarieabsen = $("#iddarieabsen_man").val();
  var nama = $("#nama_man").val();
  var url = '/eabsen/upload_dfinger';
  var _token= $("input[name=_token]").val();
  //-------- var progres
  var valuemax = 1;
  var valuemin = 0;
  var valuenow = 1;
  var stylewidth = 100;
  //console.log(nama);
  $('#progresstambah').empty();
  $('#datatambah').empty();
  $('#modal_uploadfp').modal('hide');

  progresstambah(valuenow, valuemax, stylewidth); //progress
  tambahDataFPkeServer(url, iddarimesin, iddarieabsen, nama, _token, valuenow, valuemax, stylewidth);
  //console.log(iddarimesin+iddarieabsen+nama);

});
// END./Upload data FingerPrint perorang------------------------------------------

// Upload data FingerPrint keseluruhan-----------------------------------------------
// cek dari data mesin, hitung jumlah data, ambil data dari setiap id
// lakukan perulangan penambahan finger sesuai jumlah row
$(document).on('click','#uploadf_all',function (){

  var url = '/eabsen/upload_dfinger';

  $.getJSON("/konfig/jlhpeg", function(data, status){

        var _token= $("input[name=_token]").val();
        var jlhdatapeg = Object.keys(data).length;
        //-------- var progres
        var valuemax = jlhdatapeg;
        var valuemin = 0;
        var valuenow = 1;
        var stylewidth = 0;
        var init_p =1;

        $('#progresstambah').empty();
        $('#datatambah').empty();
        $('#modal_uploadall').modal('hide');

        progresstambah(valuenow, valuemax, stylewidth);

        for(var i=1; i<=jlhdatapeg;i++)
        {
          var iddarimesin = data[i].PIN2;
          var iddarieabsen = iddarimesin;
          var Nama = data[i].Name;
          valuenow = init_p;
          stylewidth = ((init_p/jlhdatapeg)*100).toFixed(2);

          progresstambah(valuenow, valuemax, stylewidth);
          tambahDataFPkeServer(url, iddarimesin, iddarieabsen, Nama, _token, valuenow, valuemax, stylewidth);
          //console.log(_token);

          init_p++;
        }
  });

});

// END./Download data FingerPrint keseluruhan------------------------------------------

//Cek Data PIN/FP dari mesin
$(document).on('click','#cek_fpm',function (){

    var currentRow = $(this).closest('tr');
    var iddarimesin = currentRow.find('td:eq(1)').text();
    var nama = currentRow.find('td:eq(2)').text();
    $.getJSON("/dtpinfp/"+iddarimesin, function(data, status){
        //console.log(data);
        //swal( data.nama, '['+data.jenis+'] di mesin', "info");
        if (data.status=='0') { swal( nama, '[BELUM ada data PIN/Sidik Jari] di mesin', "error"); }
        else if (data.status=='1') { swal( nama, '[Sudah ada data PIN] di mesin', "success"); }
        else if (data.status=='2') { swal( nama, '[Sudah ada data Sidik Jari] di mesin', "success"); }
        else  { swal( '', 'TERJADI KESALAHAN!!!', "error"); console.log(data); }
    });
});
//Cek Data PIN/FP dari server eabsen
$(document).on('click','#cek_fpea',function (){

    var currentRow = $(this).closest('tr');
    var iddarimesin = currentRow.find('td:eq(1)').text();
    var nama = currentRow.find('td:eq(2)').text();
    $.getJSON("http://eabsen.kalselprov.go.id/api/ambilfinger/"+iddarimesin, function(data, status){
        //console.log(data=='');
        if(data=='') { swal( nama, '[BELUM ada data PIN/Sidik Jari] di server eabsen.kalselprov.go.id', "error"); }
        else { swal( nama, '[SUDAH ada data PIN/Sidik Jari] di server eabsen.kalselprov.go.id', "success"); }
    });
});

// BackUp data FingerPrint-----------------------------------------------
//
$(document).on('click','#backup_fp',function (){
  var currentRow = $(this).closest('tr');
  var iddarimesin = currentRow.find('td:eq(1)').text();
  var iddarieabsen = currentRow.find('td:eq(1)').text();
  var nama = currentRow.find('td:eq(2)').text();
  var url = '/sidikjari';
  var _token= $("input[name=_token]").val();
  //-------- var progres
  var valuemax = 1;
  var valuemin = 0;
  var valuenow = 1;
  var stylewidth = 100;
  //console.log(nama);
  $('#progresstambah').empty();
  $('#datatambah').empty();

  progresstambah(valuenow, valuemax, stylewidth); //progress
  tambahDataFPkeServer(url, iddarimesin, iddarieabsen, nama, _token, valuenow, valuemax, stylewidth);
  //console.log(iddarimesin+iddarieabsen+nama);

});
// END./BackUp data FingerPrint ------------------------------------------



//Fungsi menambahkan data finger ke server eabsen------------------
function tambahDataFPkeServer(url, iddarimesin, iddarieabsen, nama, _token, valuenow, valuemax, stylewidth)
{
  //----------------------
  $.ajax({
      type:'post',
      url: url,
      data : {
              iddarimesin:iddarimesin,
              iddarieabsen:iddarieabsen,
              nama:nama,
              _token:_token
              },
      success:function(response){
          //console.log(response);
          if((response.status==2)){
            //  $('.error').addClass('hidden');
            // swal(response.status_pesan, "", "success");
            progresstambah(valuenow, valuemax, stylewidth);
            var opsi_i = 'bu_datapin';
            datatambah(nama, 0, opsi_i, response.jenis);

            datatabelf.ajax.reload(null, false);
          }
          else if((response.status!=0)){
            //  $('.error').addClass('hidden');
            // swal(response.status_pesan, "", "success");
            progresstambah(valuenow, valuemax, stylewidth);
            var opsi_i = 'initial_upload';
            datatambah(nama, 0, opsi_i, response.jenis);

            if(response.status_pesan!='Full') { var opsi = 'upload'; }
            else { var opsi = 'full'; }

            datatambah(nama, 0, opsi, response.jenis);
            datatabelf.ajax.reload(null, false);
          }
          else
            {
              //$('.error').addClass('hidden');
              //swal(response.pesan, "", "error");
              //$(modal_id).modal('hide');
              progresstambah(valuenow, valuemax, stylewidth);
              var opsi = 'kosong';

              datatambah(response.nama, 0, opsi, response.jenis);
              datatabelf.ajax.reload(null, false);
              //console.log(response);
            }
      },
  });
  //---------------------
}
//------------------------------------------------------------------------------


//------------------------------------------------------------------------------
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
function datatambah(nama, index, opsi, jenis)
{
    if(opsi=='initial_upload')
    {
      var bg = 'info';
      var item = 'plus';
      var bg_item = 'aqua';
      var pesan = 'mengupload data '+jenis+' <i class="fa fa-user"></i> '+nama;
    }
    else if(opsi=='upload')
    {
      var bg = 'success';
      var item = 'plus';
      var bg_item = 'green';
      var pesan = 'data '+jenis+' <i class="fa fa-user"></i> '+nama+' ke-'+index+' diupload';
    }
    else if(opsi=='full')
    {
      var bg = 'warning';
      var item = 'warning';
      var bg_item = 'orange';
      var pesan = 'sudah ada data Sidik Jari/PIN <i class="fa fa-user"></i> '+nama+' ke-'+index+' di basis data eabsen.kalselprov.go.id';
    }

    else if(opsi=='bu_datapin')
    {
      var bg = 'warning';
      var item = 'warning';
      var bg_item = 'orange';
      var pesan = 'Data PIN <i class="fa fa-user"></i> '+nama+' tidak akan diBackup!';
    }
    else if(opsi=='kosong')
    {
      var bg = 'danger';
      var item = 'warning';
      var bg_item = 'red';
      var pesan = 'tidak ada data Sidik Jari/PIN <i class="fa fa-user"></i> '+nama+' di mesin';
    }


    var waktuattemp = timeAttemp();
    var datahead = '<li><i class="fa fa-'+item+' bg-'+bg_item+'"></i>';
    var dataisi1 = '<div class="timeline-item">';
    var dataisi2 = '<span class="time">'+waktuattemp+'</span>';
    var dataisi3 = '<div class="timeline-body bg-'+bg+'">'+pesan+'</div>';
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

$(document).hover(function(){ $('[data-toggle="tooltip"]').tooltip(); });
