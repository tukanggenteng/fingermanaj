{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Dashboard</h1>
@stop

@section('content')
<form id="formpegawaiadd" method="post" role="form" enctype="multipart/form-data" action="{{route('mesin.datapegawai')}}">

  @csrf
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="form-group">
          <label>ID</label>
          <input id="ID" name="ID" class="form-control pull-right" type="text">
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="form-group" >
          <label>Nama</label>
          <input id="nama" name="nama" type="text" class="form-control pull-right">
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="form-group" >
          <button type="button" id="addpegawai" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</form>
@stop

@section('css')

<!--css custom section   -->
<!-- code below -->
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<!--javascript custom section   -->
<!-- code below -->
@stop
