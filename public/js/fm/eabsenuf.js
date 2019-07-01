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
                                var aksi1 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-primary" id="cek_fp"><i class="fa fa-thumbs-o-up"></i><i class="fa fa-search"></i>[mesin]</button>';
                                var aksi2 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-aqua" id="uploadf"><i class="fa fa-thumbs-o-up"></i><i class="fa fa-upload"></i></button>';
                                var aksi3 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-blue" id="uploadf_man" data-toggle="modal" data-target="#modal_uploadfp"><i class="fa fa-thumbs-o-up"></i><i class="fa fa-upload"></i>Manual</button>';
                                var aksi4 = '<button class="upload_'+data.PIN2+' uploadfinger btn bg-navy" id="cek_fp"><i class="fa fa-thumbs-o-up"></i><i class="fa fa-search"></i>[eabsen]</button>';
                                var aksi = aksi1+' '+aksi2+' '+aksi3+' '+aksi4;
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
  datatabelf.ajax.reload();
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
  //tambahDataFPkeServer(iddarimesin, iddarieabsen, nama, _token, valuenow, valuemax, stylewidth);

});
// END./Upload data FingerPrint perorang------------------------------------------

// Upload data FingerPrint Manual perorang----------------------------------------------
//-------------------------
//-------------------------


$(document).on('click','#uploadman',function (){
  var currentRow = $(this).closest('tr');
  var id = currentRow.find('td:eq(1)').text();
  var nama = currentRow.find('td:eq(2)').text();
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
  //tambahDataFPkeServer(iddarimesin, iddarieabsen, nama, _token, valuenow, valuemax, stylewidth);

});
// END./Upload data FingerPrint perorang------------------------------------------

// Upload data FingerPrint keseluruhan-----------------------------------------------
// cek dari data table saja, hitung jumlah row, ambil data dari setiap id
// lakukan perulangan penambahan finger sesuai jumlah row
$(document).on('click','#uploadf_all',function (){

  var _token= $("input[name=_token]").val();
  //var datarow = $('#datapegawaifinger tbody tr:eq(5) td:eq(2)').text(); cek data /row

  //-------- var progres
  var valuemax = rowCount;
  var valuemin = 0;
  var valuenow = 1;
  var stylewidth = 0;
  var init_p =1;

  $('#progresstambah').empty();
  $('#datatambah').empty();

  progresstambah(valuenow, valuemax, stylewidth);
  //tambahDataFPkeServer(iddarimesin, iddarieabsen, nama, _token, valuenow, valuemax, stylewidth);


});

// END./Download data FingerPrint keseluruhan------------------------------------------



//Fungsi menambahkan data finger ke server eabsen------------------
function tambahDataFPkeServer(iddarimesin, iddarieabsen, nama, _token, valuenow, valuemax, stylewidth)
{
  //----------------------
  $.ajax({
      type:'post',
      url:'/eabsen/download_dfinger',
      data : {
              iddarimesin:iddarimesin,
              iddarieabsen:iddarieabsen,
              nama:nama,
              _token:_token
              },
      success:function(response){
        //hitung jumlah respon data
        //lakukan perhitungan jumlah respon data
        //lakukan perulangan response untuk memberikan notif
        var response_j = response.length;
        if(response_j==0) { response_j = 1; }
        var i = 0;
        //console.log(response_j);
        for(i = 0; i<response_j;i++)
        {
          if((response[i].status==1)){
              //console.log('data sidik jari '+response[i].nama+' ke-'+i+' ditambahkan');
              progresstambah(valuenow, valuemax, stylewidth);

              var opsi_i = 'initial_upload';
              datatambah(nama, i, opsi_i, response[i].jenis);

              var opsi = 'upload';
              datatambah(nama, i, opsi, response[i].jenis);
          }
          else
           {
              //$('.error').addClass('hidden');
              swal("Terjadi Kesalahan, "+response, "", "error");
              //$('#modal_add').modal('hide');
              console.log(response);
              //datatabelf.ajax.reload();
          }
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
