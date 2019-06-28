// Cek Koneksi-----------------------------------------------------------
$(document).on('click','#cekkon',function (){
  var _token=$("input[name=_token]").val();
  $('#progress').show();
  $('#hasil').hide();
  $.ajax({
      type:'post',
      url:'/cekkon',
      data : {   _token:_token },
      success:function(response){
          //console.log(response);
          $('#progress').hide();
          if((response=='alive')){
              $('#hasil').html('<div class="alert alert-success text-center"><h4>Mesin dapat dihubungi!</h4></div>');
              $('#hasil').fadeIn('slow');
          }
          else
            {
              $('#hasil').html('<div class="alert alert-warning text-center"><h4>Mesin tidak dapat dihubungi!</h4></div>');
              $('#hasil').fadeIn('slow');
            }

        },
    })
    return false;

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
