{{-- resources/views/datafingerpegawai_m_v.blade.php --}}

@extends('adminlte::page')

@section('title', 'Data Sidik Jari di Mesin Fingerprint')

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
    <div class="alert alert-danger fade in alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <center> {!! session()->get('warning') !!} </center>
    </div>
  @endif

  <div class="row">
    <div class="content">
      <div class="box box-default">
      <form action="{{route('mesin.datafinger_p')}}" method="post">
          @csrf
          <input type="hidden" name="status_store" value="Edit">
          <div class="box-header with-border">
            <h2><i class="fa fa-user"></i>   {{$ID}} : {{$nama}}</h2> <i class="fa fa-pencil"></i> [edit data sidik jari]
            <input type="hidden" name="ID" value="{{$ID}}">
            <input type="hidden" name="nama" value="{{$nama}}">
          </div>
          <div class="box-body">
            <h3>Finger ID : {{$datafinger['FingerID']}}<input type="hidden" name="FingerID" value="{{$datafinger['FingerID']}}"></h3>
            <h3>Ukuran : {{$datafinger['Size']}}</h3>
            <h3>Template :</h3>
            <textarea name="template_finger" class="col-md-10 form-control" rows="10" cols="80">{{$datafinger['Template']}}</textarea>
          </div>
          <div class="box-footer">
            <button class="btn btn-warning form-control">Update !</button>
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
