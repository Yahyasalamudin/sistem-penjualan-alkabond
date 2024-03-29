@extends('layouts.master')

@push('css')
    <style>
        #content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        footer {
            width: 100%;
            position: absolute;
            bottom: 0;
        }
    </style>
@endpush

@section('app')
    <div id="wrapper">
        <div id="content-wrapper">
            <div id="content">
                <div class="container text-center">
                    <div class="error mx-auto" data-text="500">500</div>
                    <p class="lead text-gray-800 mb-5">Internal Server Error</p>
                    <p class="text-gray-500 mb-0">Kami menemui masalah saat memproses permintaan Anda.</p>
                    <a href="/">&larr; Kembali ke Beranda</a>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Mortar Alkabon {{ now()->format('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
@endsection
