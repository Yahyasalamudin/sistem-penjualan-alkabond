@extends('layouts.master')

@section('app')
    <div class="container-fluid">
        <div class="baris main-content bg-success text-center">
            <div class="col-md-5 text-center company__info">

                <span class="company__logo mb-3"><img src="{{ asset('img/logo.png') }}" width="90px" alt=""></span>

                <h4 class="company_title">Sejahtera Bersama</h4>
            </div>
            <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
                <div class="container-fluid">
                    <div class="baris">
                        <h2>Log In</h2>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="baris">
                        <form class="form-group formu" action="{{ Route('actionLogin') }}" method="post">
                            @csrf
                            <div class="baris">
                                <input type="text" class="form__input @error('email_username') is-invalid @enderror"
                                    name="email_username" id="email_username" placeholder="Masukkan Email atau Username..."
                                    autocomplete="off" value="{{ old('email_username') }}">

                                @error('email_username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="baris">
                                <input type="password" class="form__input  @error('password') is-invalid @enderror"
                                    name="password" id="password" placeholder="Masukkan Password..." autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="baris d-flex align-items-center mt-3 ml-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Ingat Saya</label>
                                </div>
                            </div>

                            <div class="baris" style="padding-left: 20px;">
                                <input type="submit" value="Submit" class="tombol">
                            </div>
                        </form>
                    </div>
                    <div class="baris">
                        <p>Don't have an account? <a href="#">Register Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
