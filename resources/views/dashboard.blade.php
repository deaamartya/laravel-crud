@extends('master')
@section('Judul','Home')
@section('konten')
<div class="card shadow mb-4" style="padding: 50px;">
<div class="card-body">
  <div class="text-center">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 50rem;" src="img/welcome.svg" alt="">
  </div>
  <h1 class="text-center font-weight-bold">Welcome Back! </h1>
  <h2 class="text-center font-weight-light">{{ @session('name') }} {{@session('last_name') }}</h2>
</div>
</div>
@endsection