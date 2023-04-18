@extends('layouts.master')

@section('app')
    <div class="container-fluid ">
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
                                <input type="email" class="form__input @error('email') is-invalid @enderror"
                                    name="email" id="email" aria-describedby="emailHelp"
                                    placeholder="Masukkan Email..." autocomplete="off" value="{{ old('email') }}">

                                @error('email')
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

                            <div class="baris" style="
                        padding-left: 20px;
                    ">
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
