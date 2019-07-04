{{-- resources/views/datapinpegawai_m_v.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data PIN/Password Pegawai di Mesin Finger')

@section('content_header')
<!--content header custom section   -->
<!-- code below -->
    <h1>Data Pegawai di Mesin Finger</h1>
@stop

@section('content')
  @if(session()->has('message'))
    <div class="alert alert-success fade in alert-dismissible">
      <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
    <center> {!! session()->get('message') !!} </center>
    </div>
  @elseif(session()->has('warning'))
    <div class="alert alert-danger fade in alert-dismissible">
      <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
      <center> {!! session()->get('warning') !!} </center>
    </div>
  @endif

  <div class="row">
    <div class="content">
      <div class="box box-default">
      <form action="{{route('mesin.setdatapin_p')}}" method="post">
          @csrf
          <input type="hidden" name="status_store" value="Edit">
          <div class="box-header with-border">
            <h2><i class="fa fa-user"></i>   {{$ID}} : {{$datapin['Name']}}</h2> <i class="fa fa-pencil"></i> [edit data PIN/Password]
            <input type="hidden" name="ID" value="{{$ID}}">
          </div>
          <div class="box-body">
            <h3>Nama :</h3>
            <input type="text" name="nama" id="nama" class="col-md-10" value="{{$datapin['Name']}}">
          </div>
          <div class="box-body">
            <h3>PIN/Password :</h3>
            <input type="password" name="password" id="password" class="col-md-10" value="{{$datapin['Password']}}">
          </div>
          <div class="box-footer">
            <button class="btn btn-warning">Update !</button>
          </div>
        </form>
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
@stop
