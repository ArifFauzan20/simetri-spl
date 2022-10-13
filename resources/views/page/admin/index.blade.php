@extends('layouts.dashboard')
@section('content')
    <h1>{{ Auth()->user()->karyawan->nama_karyawan }}</h1>
@endsection
