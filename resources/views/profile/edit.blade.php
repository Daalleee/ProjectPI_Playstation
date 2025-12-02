@extends($layout)

@section('title', 'Edit Profil')
@section('header_title', 'Edit Profil')

@section('pelanggan_content')
@include('profile._form')
@endsection

@section('admin_content')
@include('profile._form')
@endsection

@section('kasir_content')
@include('profile._form')
@endsection

@section('pemilik_content')
@include('profile._form')
@endsection

@section('content')
@include('profile._form')
@endsection
