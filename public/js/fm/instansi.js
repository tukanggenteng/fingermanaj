// data table
var datatabelf = $('#datainstansi').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    language: {
                      lengthMenu: "Tampilkan _MENU_ Baris",
                      zeroRecords: "Maaf - Data Tidak Ditemukan",
                      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                      infoEmpty: "Tidak Ada Data Tersedia",
                      infoFiltered: "(disaring dari total _MAX_ data)",
                      paginate: {
                          first:"Awal",
                          last:"Akhir",
                          next:"Selanjutnya",
                          previous:"Sebelumnya"
                          },
                      search:"Pencarian:",
                      },
                    "ajax": "/dtinstansi",
                    columns: [
                          { data: 'id'},
                          { data: 'kode' },
                          { data: 'namaInstansi' },
                          { data: null }, //jika ingin mengisi data pada opsi columnDefs, parameter bagian ini harus diisi oleh null

                      ],
                      columnDefs: [
                          { targets: [0,1] , className: 'text-right' },
                          { targets: [2] , className: 'text-left' },
                          {
                            targets: [3] ,className: 'text-center',
                            'render': function (data, type, row) {
                                var aksi1 = '<button class="edit_'+data.id+' btn btn-warning" id="edit_ins" data-toggle="modal" data-target="#modal_edit_ins"><i class="fa fa-pencil"></i></button>';
                                var aksi2 = '<button class="hapus_'+data.id+' btn btn-danger" id="hapus_ins"><i class="fa fa-trash"></i></button>';
                                var aksi = aksi1+aksi2;
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
//fungsi tambah----------------------------------------------
$(document).on('click','#addinstansi',function (){
  var id = $('#ID').val();
  var kode = $('#kode').val();
  var namaInstansi = $('#nama_instansi').val();
  var _token= $("input[name=_token]").val();
  var _method = 'POST';
  var url = '/instansi_r';
  var modal_id = '#modal_add';
  //console.log('eksekusi tambah '+id+';'+kode+';'+namaInstansi);
  prosesAjax(id, kode, namaInstansi, _token, _method, url, modal_id);
});
// ./fungsi tambah-------------------------------------------
//---------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
//fungsi edit------
//+get data
$(document).on('click','#edit_ins',function (){
  var currentRow = $(this).closest('tr');
  var id = currentRow.find('td:eq(0)').text();
  var kode = currentRow.find('td:eq(1)').text();
  var namaInstansi = currentRow.find('td:eq(2)').text();
  var _token= $("input[name=_token]").val();
  $("#ID_e").val(id);
  $("#kode_e").val(kode);
  $("#nama_instansi_e").val(namaInstansi);

});
//+update data
$(document).on('click','#updateinstansi',function (){
  var id = $('#ID_e').val();
  var kode = $('#kode_e').val();
  var namaInstansi = $('#nama_instansi_e').val();
  var _token= $("input[name=_token]").val();
  var _method = 'PATCH';
  var url = '/instansi_r/'+id;
  var modal_id = '#modal_edit_ins';
  //console.log('eksekusi update '+id+';'+kode+';'+namaInstansi);
  prosesAjax(id, kode, namaInstansi, _token, _method, url, modal_id);
});
// ./fungsi edit------
//---------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
//fungsi hapus------
$(document).on('click','#hapus_ins',function (){
  var currentRow = $(this).closest('tr');
  var id = currentRow.find('td:eq(0)').text();
  var kode = currentRow.find('td:eq(1)').text();
  var namaInstansi = currentRow.find('td:eq(2)').text();
  var _token= $("input[name=_token]").val();
  var _method = 'DELETE';
  var url = '/instansi_r/'+id;
  var modal_id = '';

  var r = confirm("Apakah anda yakin?");
  if(r==true)
  {
    //console.log('eksekusi hapus '+id+';'+kode+';'+namaInstansi);
    prosesAjax(id, kode, namaInstansi, _token, _method, url, modal_id);
  }

});
// ./fungsi hapus------
//---------------------------------------------------------------------------------------

//------------------------------
//Process Ajax
function prosesAjax(id, kode, namaInstansi, _token, _method, url, modal_id)
{
  $.ajax({
      type:'post',
      url: url,
      data : {
              ID: id,
              kode: kode,
              namaInstansi : namaInstansi,
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
              swal("Error", error, "error");
              $(modal_id).modal('hide');
              datatabelf.ajax.reload(null, false);
            }
        },
    });
}
