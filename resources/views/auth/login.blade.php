@extends('layouts.auth')
@section('auth_content')
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="assets/images/logo-simetri.png" height="48" class='mb-4'>
                        <h2 class="text-dark">Login</h2>
                        <h4 class="text-dark">SPL</h4>
                    </div>
                    <form action="/authlogin" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left">
                            <label for="username">NIK</label>
                            <div class="position-relative">
                                <input type="text" class="form-control @error('nik_karyawan') is-invalid @enderror"
                                    id="nik_karyawan" name="nik_karyawan">
                                <div class="form-control-icon">
                                    <i data-feather="user"></i>
                                </div>
                            </div>
                            @error('nik_karyawan')
                                <span class="text-danger py-2">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix">
                                <label for="password">Password</label>
                            </div>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-primary w-100">Submit</button>
                        </div>
                        @if ($message = Session::get('error'))
                            <div class="pt-2 text-center text-danger">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    </div>
@endsection
