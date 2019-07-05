// Cek Koneksi-----------------------------------------------------------
$(document).on('click','#cekkon',function (){
  var _token=$("input[name=_token]").val();
  $('#progress').show();
  $('#hasil').hide();
  $.get("/konfig/ip", function(data, status){
    $.ajax({
        type:'post',
        url:'/cekkon',
        data : {   _token:_token,ipaddr:data },
        success:function(response){
            //console.log(response);
            $('#progress').hide();
            if((response=='alive')){
                $('#hasil').html('<div class="alert alert-success text-center flat"><h4>Mesin dapat dihubungi!</h4></div>');
                $('#hasil').fadeIn('slow');
            }
            else
              {
                $('#hasil').html('<div class="alert alert-warning text-center flat"><h4>Mesin tidak dapat dihubungi!</h4></div>');
                $('#hasil').fadeIn('slow');
              }
          },
      });
    });

    //return false;

  });
  // ./Cek Koneksi-----------------------------------------------------------

  //+progress
  function progresstambah()
  {
    var bar1 = '<div id="progress_b" class="">';
    var bar2 =  '<div class="progress active">';
    var bar3 =   '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></div>';
    $("#progress").html(bar1+bar2+bar3);
  }
  //-------------------------------

  //Wipe data pegawai-----------------------------------------------------------
  $(document).on('click','#wipedata_',function (){
    var _token= $("input[name=_token]").val();
    //console.log(_token);
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
              $('#modal_wipe').modal('hide');
              //console.log(response.nama);
          }
          else
            {
              $('.error').addClass('hidden');
              swal("Terjadi Kesalahan", "", "error");
              $('#modal_wipe').modal('hide');
              //console.log(response);
              }
        },
    });

  });
  // ./Wipe data pegawai-----------------------------------------------------------

  //Set ip from list function
  $(document).on('click', '.set-ip', function(){
     var currentRow = $(this).closest('tr');
     var no = currentRow.find('td:eq(0)').text();
     var ip = currentRow.find('td:eq(1)').text();
     var _token= $("input[name=_token]").val();
     $('#load_'+no).html('<i class="fa fa-refresh fa-spin"></i>');

     //$(".lightbulb").html('<i class="fas fa-lightbulb fa-2x border border-dark" style="color:yellow; text-shadow: 2px 2px 4px #000000;"></i>');
     //console.log('klik');
     $.ajax({
         type:'post',
         url:'/konfigurasi_set',
         data : {
                 alamat_ip:ip,
                 _token:_token
                 },
         success:function(response){
           $('#load_'+no).empty();
            $('#lightbulb_'+no).html('<i class="fas fa-lightbulb fa-2x" style="color:#ffffa5; text-shadow: 2px 2px 4px #b3ca00;"></i>');
            updateInfoIP();
            swal('','','success');
         },
     });
     //---------------------
  });

  //Set ip from list function

  $(document).on('click', '#cek_kondisi_ip', function(){
      var jlhipaddr = $("#daftaralamatip tbody tr").length;
      var init = 1;
      for(var i=0;i<jlhipaddr;i++)
      {
        var ipaddrs = $("#daftaralamatip tbody tr:eq("+i+") td:eq(1)").text();
        $('#load_'+init).html('<i class="fa fa-refresh fa-spin"></i>');
        cekkontabel(ipaddrs, init);
        init++;
      }
  });

  var lightb = '<i class="fas fa-lightbulb fa-2x" style=""></i>';
  var lightg = '<i class="fas fa-lightbulb fa-2x" style="color:#42af41; text-shadow: 2px 2px 19px #00ce00;""></i>'; //glow green
  var lightr = '<i class="fas fa-lightbulb fa-2x" style="color:#ff0707; text-shadow: 2px 2px 19px #ff0909;""></i>'; //glow red

  function cekkontabel(ippadd, no)
  {
    var _token= $("input[name=_token]").val();
    $.ajax({
        type:'post',
        url:'/cekkon',
        data : {   _token:_token,ipaddr:ippadd },
        success:function(response){
          //console.log(response);
          $('#progress_ck').hide();
          if((response=='alive')){
              $('#load_'+no).empty();
              $('#lightbulb_'+no).html(lightg);
              $('#lightbulb_'+no).fadeIn('slow');
            }
            else
              {
                $('#load_'+no).empty();
                $('#lightbulb_'+no).html(lightr);
                $('#lightbulb_'+no).fadeIn('slow');
              }
            },
        });
  }
