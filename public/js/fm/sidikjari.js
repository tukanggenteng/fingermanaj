// data table
var datatabelf = $('#datasidikjari').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/dtsidikjari",
                    columns: [
                          { data: 'id'},
                          { data: 'nama'},
                          { data: 'keterangan'},
                          { data: 'pegawai_id'},
                          { data: 'created_at'},
                          { data: 'updated_at'},
                          { data: null, "searchable": false }, //jika ingin mengisi data pada opsi columnDefs, parameter bagian ini harus diisi oleh null

                      ],
                      columnDefs: [
                          { targets: [0,3] , className: 'text-right' },
                          { targets: [1,2] , className: 'text-left' },
                          { targets: [4,5] , className: 'text-center' },
                          {
                            targets: [6] ,className: 'text-center',
                            'render': function (data, type, row) {
                                var aksi1 = '<button class="cn_'+data.pegawai_id+' btn btn-default" id="cn" data-toggle="modal" data-target="#modal_cn">[Nama]<i class="fa fa-search"></i></button>';
                                var aksi2 = '<button class="cfp_'+data.id+' btn btn-default" id="cfp" data-toggle="modal" data-target="#modal_fp"><i class="fas fa-fingerprint"></i><i class="fa fa-search"></i></button>';
                                var aksi3 = '<button class="edit_'+data.id+' btn btn-warning" id="edit_fp" data-toggle="modal" data-target="#modal_edit_fp"><i class="fa fa-pencil"></i></button>';
                                var aksi4 = '<button class="hapus_'+data.id+' btn btn-danger" id="hapus_fp"><i class="fa fa-trash"></i></button>';
                                var aksi = aksi1+' '+aksi2+' '+aksi3+' '+aksi4;
                                return aksi;
                            }
                         },
                      ]
                    } );
//--------------------------------------------------

//refresh table
$('#refresh').click(function(){
  datatabelf.ajax.reload(null, false);
});
//----------------------

//---------------------------------------------------------------------------------------
//+get data nama
$(document).on('click','#cn',function (){
  var currentRow = $(this).closest('tr');
  var idpegawai = currentRow.find('td:eq(1)').text();
  $.get("/konfig/sv", function(data, status){
    var server = data.url_server;
    $.get("http://"+server+"/api/cekpegawaidata/"+idpegawai, function(data, status){
      // console.log(data.length==0); //coz array, if length is 0 ther is no data
      if(data.length==0) { data = 'Data tidak ditemukan!'; }
      else { data = '<strong class="text-center">['+data[0].nama+'] ['+data[0].nip+'] Instansi ID: '+data[0].instansi_id+'</strong>'; }
      $(".cn_"+idpegawai).html(data);
      //$(".cn_"+idpegawai).attr("disabled", true);
    });
  });
});

//---------------------------------------------------------------------------------------
//fungsi show data------
//+get data sidikjari
$(document).on('click','#cfp',function (){
  var currentRow = $(this).closest('tr');
  var id = currentRow.find('td:eq(0)').text();

  $.get("/sidikjari/"+id, function(data, status){
      $("#nama").val(data.nama);
      $("#ket").val(data.keterangan);
      $("#pegawai_id").val(data.pegawai_id);
      $("#id_fp").val(data.id);
      $("#template_fp").val(data.templatefinger);
    });

});


//---------------------------------------------------------------------------------------
//fungsi tambah----------------------------------------------
$(document).on('click','#addfp',function (){
  var nama = $('#nama_t').val();
  var ket = $('#ket_t').val();
  var pegawai_id = $('#pegawai_id_t').val();
  var template_finger = $('#template_fp_t').val();
  var _token= $("input[name=_token]").val();
  var _method = 'POST';
  var url = '/sidikjari';
  var modal_id = '#modal_add';
  //console.log('eksekusi tambah '+id+';'+kode+';'+namaInstansi);
  prosesAjax(pegawai_id, '', template_finger, _token, _method, url, modal_id);
});
// ./fungsi tambah-------------------------------------------
//---------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------
//fungsi edit from show------
//+get data
$(document).on('click','#edit_frm_show',function (){
  var pegawai_id = $('#pegawai_id').val();
  var id = $('#id_fp').val();
  var templatefinger= $('#template_fp').val();

  $.get("/sidikjari/"+id, function(data, status){
      $("#nama_e").val(nama);
      $("#ket_e").val(keterangan);
      $("#pegawai_id_e").val(pegawai_id);
      $("#id_fp_e").val(id);
      $("#template_fp_e").val(templatefinger);

    });
});
//fungsi edit normal------
//+get data
$(document).on('click','#edit_fp',function (){
  var currentRow = $(this).closest('tr');
  var id = currentRow.find('td:eq(0)').text();

  $.get("/sidikjari/"+id, function(data, status){
      $("#nama_e").val(data.nama);
      $("#ket_e").val(data.keterangan);
      $("#pegawai_id_e").val(data.pegawai_id);
      $("#id_fp_e").val(data.id);
      $("#template_fp_e").val(data.templatefinger);

    });
});
//+update data
$(document).on('click','#updatefp',function (){
  var nama = $('#nama_e').val();
  var ket = $('#ket_e').val();
  var pegawai_id = $('#pegawai_id_e').val();
  var fp_id = $('#id_fp_e').val();
  var template_finger = $('#template_fp_e').val();
  var _token= $("input[name=_token]").val();
  var _method = 'PATCH';
  var url = '/sidikjari/'+fp_id;
  var modal_id = '#modal_edit_fp';
  //console.log('eksekusi update '+id+';'+kode+';'+namaInstansi);
  prosesAjax(nama, ket, pegawai_id, fp_id, template_finger, _token, _method, url, modal_id);
});
// ./fungsi edit------
//---------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
//fungsi hapus------
$(document).on('click','#hapus_fp',function (){

  var currentRow = $(this).closest('tr');
  var fp_id = currentRow.find('td:eq(0)').text();
  var pegawai_id = currentRow.find('td:eq(1)').text();
  var _token= $("input[name=_token]").val();
  var _method = 'DELETE';
  var url = '/sidikjari/'+fp_id;
  var modal_id = '';

  var r = confirm("Apakah anda yakin?");
  if(r==true)
  {
    //console.log('eksekusi hapus '+id+';'+kode+';'+namaInstansi);
    prosesAjax(pegawai_id, fp_id, '', _token, _method, url, modal_id);
  }


});
// ./fungsi hapus------
//---------------------------------------------------------------------------------------

//------------------------------
//Process Ajax
function prosesAjax(nama, ket, pegawai_id, fp_id, template_finger, _token, _method, url, modal_id)
{
  $.ajax({
      type:'post',
      url: url,
      data : {
              nama: nama,
              ket: ket,
              id: fp_id,
              pegawai_id: pegawai_id,
              templatefinger : template_finger,
              _token: _token,
              _method: _method,
              modal_id: modal_id,
              },
      success:function(response){
          //console.log(response);
          if((response.status==1)){
              swal(response.pesan, "", "success");
              $(modal_id).modal('hide');
              //console.log(response.nama);
              datatabelf.ajax.reload(null, false);
          }
          else
            {
              console.log(response);
              var error = JSON.stringify(response.masalah);
              swal("Eror", error, "error");
              $(modal_id).modal('hide');
              datatabelf.ajax.reload(null, false);
            }
        },
    });
}
