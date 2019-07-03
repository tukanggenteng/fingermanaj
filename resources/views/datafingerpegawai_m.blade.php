{{-- resources/views/datapegawai_m.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Pegawai di Masin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Data Pegawai di Mesin Finger</h1>
@stop

@section('content')
  @if(session()->has('message'))
    <div class="alert alert-success fade in alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <center> {!! session()->get('message') !!} </center>
    </div>
  @elseif(session()->has('warning'))
    <div class="alert alert-warning fade in alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <center> {!! session()->get('warning') !!} </center>
    </div>
  @endif

<div class="row">
  <div class="content">
    <div class="box box-default">
        <div class="box-header with-border">
          <h2>{{$ID}} : <b>{{$nama}}</b></h2>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr class="bg-navy">
                <th class="col-md-1">No</th>
                <th class="col-md-1">ID</th>
                <th class="col-md-7">Template</th>
                <th class="col-md-2">Aksi</th>
              </tr>
            </thead>
            <tbody id="datafinger">
              @for($i=0;$i<10;$i++)
              <tr>
                  <td>{{$no=$i+1}}</td><td class="id_finger">{{$i}}</td><td class="data_sidikjari"><span id="data_sidikjari_{{$i}}"></span></td>
                  <td class="aksi_ds text-center"><a href="#" onclick="" class="btn btn-primary cek_data_finger">Cek <i class="fa fa-search "></i></a><span id="aksi_{{$i}}"></span></td>
              </tr>
              @endfor
            </tbody>
          </table>
          <hr>
          <form method="post" action="{{route('mesin.datafinger_d')}}">
            @csrf
            <input type="hidden" name="status_store" value="Hapus">
            <input type="hidden" name="ID" value="{{$ID}}">
            <input type="hidden" name="nama" value="{{$nama}}">
            <button class='btn btn-danger hapus_data_finger form-control'>Hapus data sidik jari !</button>
          </from>
        </div>
        <div class="box-footer">
        </div>
      </div>
  </div>
</div>

@stop

@section('css')

<!--css custom section   -->
<!-- code below -->
@stop

@section('js')
<!--javascript custom section   -->
<!-- code below -->
<script>
//komentar?
$(document).ready(function(){
  $('.cek_data_finger').click(function(){
      var id = $(this).parent().siblings('.id_finger').text();
      var tester = $(this).parent().siblings('.cek_data_finger').text();

      $.get("/pegawai/fingerpegawai_m/"+{{$ID}}+"/"+id, function(data, status){
        //alert(data.PIN);
        //if(typeof data.PIN!=="undefined") {
        if(data.PIN!="") {
                idfinger = data.FingerID;
                ada = '<span class="btn btn-success form-control">Tersedia !</span>';
                aksi ="<a class='btn btn-warning' href='/pegawai/fingerpegawai_m_v/{{$ID}}/{{$nama}}/"+idfinger+"' >Edit <i class='fa fa-pencil'></a>";}
        else {
                ada = '<span class="btn btn-danger form-control">Tidak Tersedia !</span>';
                aksi ="<a class='btn btn-warning' href='/pegawai/fingerpegawai_m_vt/{{$ID}}/{{$nama}}/"+id+"' >Tambah <i class='fa fa-plus' ></a>";}
        //alert(ada);
        //$('.cek_data_finger').parent().siblings('.data_sidikjari_').text(ada);
        $('#data_sidikjari_'+id).html(ada);
        $('#aksi_'+id).html(aksi);
      });
      //menulis data ke column Template
      console.log(id);
      //console.log(response);
      //$(this).parent().siblings('.data_sidikjari').text("this.hitung");
  });
});
</script>
@stop
