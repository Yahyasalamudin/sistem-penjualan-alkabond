@extends('layouts.app')

@section('content')
<div class="row py-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800"> Detail Pesanan</h1>
        {{-- <hr> --}}

    </div>
</div>
<div class="row">
    <div class="col-md-8 col-lg-12">
        <form action="" method="post" id="registration">
            <nav>
                <hr>
                <div class="nav nav-pills nav-fill mb-4 " id="nav-tab" role="tablist">
                    <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1">Detail Pesanan</a>

                    <a class="nav-link  " id="step2-tab" data-bs-toggle="tab" href="#step2">Pembayaran</a>

                    <a class="nav-link" id="step3-tab" data-bs-toggle="tab" href="#step3">Return Pesanan</a>
                </div>
                <hr>
            </nav>
            <div class="tab-content py-4">
                <div class="tab-pane fade show active" id="step1">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="card shadow-tabl mb-4 crddet mx-2 col">
                                <div class="card-header btcolor py-3 ">
                                    <h6 class="m-0 font-weight-bold text-white">Detail Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" cellspacing="0">

                                            <tbody>
                                                <tr>
                                                    <td>Kode Trasaksi</td>
                                                    <td>INV202304100003</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Sales</td>
                                                    <td>Edi Santoso</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Method</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>Unpaid</td>
                                                </tr>
                                                <tr>
                                                    <td>Pengiriman</td>
                                                    <td>Unsent</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow  mb-4 crddet col">
                                <div class="card-header btcolor py-3 ">
                                    <h6 class="m-0 font-weight-bold text-white">Detail Toko</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" cellspacing="0">

                                            <tbody>
                                                <tr>
                                                    <td>Nama Toko</td>
                                                    <td>Toko Alibaba</td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>jl.Bla Semboro</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor telfon</td>
                                                    <td>084568908651</td>
                                                </tr>
                                                <tr>
                                                    <td>Kota</td>
                                                    <td>Semboro</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card shadow mb-4 crddet col">
                            <div class="card-header btcolor py-3 ">
                                <h6 class="m-0 font-weight-bold text-white"> Detail Pesanan</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang </th>
                                                <th>Berat </th>
                                                <th>Harga per PCS</th>
                                                <th>Jumlah</th>
                                                <th>SubTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PBR202304100001</td>
                                                <td>Perekat Bata Ringan - Alkabond/Morbon</td>
                                                <td>sak @ 30kg</td>
                                                <td>Rp 20.000</td>
                                                <td>20</td>
                                                <td>Rp 400.000</td>
                                            </tr>
                                            <tr>
                                                <td>AC2023100002</td>
                                                <td>Acian Putih - Alkabon 100 - MUI</td>
                                                <td>sak @ 40kg</td>
                                                <td>Rp 10.000</td>
                                                <td>10</td>
                                                <td>Rp 100.000</td>
                                            </tr>
                                            <tr>
                                                <td scope="row" colspan="5" class="grnd">Grand Total
                                                </td>
                                                <td class="grnd1">
                                                    Rp 500.000
                                                </td>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="step2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="card shadow-tabl mb-4 crddet mx-2 col-md-6">
                                <div class="card-header btcolor py-3 d-flex flex-row justify-content-between">
                                    <h6 class="mt-0 font-weight-bold text-white"> Pembayaran</h6>
                                    <h6 class=" mt-0 font-weight-bold text-white">INV202304100003</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Tanggal Bayar</th>
                                                    <th>Pembayaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>25 April 2023</td>
                                                    <td>-Rp 50.000</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>23 April 2023</td>
                                                    <td>-Rp 50.000</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>20 April 2023</td>
                                                    <td>-Rp 100.000</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row" colspan="2" class="grnd">Total
                                                    </td>
                                                    <td class="grnd1">
                                                        -Rp 200.000
                                                    </td>

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 mb-4 hcb">
                                <div class="card border-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs text-center font-weight-bold mb-5">
                                                    <p class="jumlh">
                                                        Jumlah Yang Harus Dibayar
                                                    </p>
                                                    <h2 class="total ">
                                                        Rp 300.000
                                                    </h2>

                                                </div>

                                                <h6 class="mb-0 text-center font-weight-bold text-gray-800">Total Pembayaran : Rp 500.000</h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="step3">
                    <div class="row justify-content-center">


                        <div class="card shadow-tabl mb-4 crddet mx-2 col-md-10">
                            <div class="card-header btcolor py-3 ">
                                <h6 class="m-0 font-weight-bold text-white">Return Pesanan</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" width="100%" cellspacing="0">

                                        <tbody>
                                            <tr>
                                                <td>Kode Trasaksi</td>
                                                <td>INV202304100003</td>
                                            </tr>
                                            <tr>
                                                <td>Nama Pesanan</td>
                                                <td>Acian Putih - Alkabon 100 - MUI</td>
                                            </tr>
                                            <tr>
                                                <td>Quantity Return</td>
                                                <td>3</td>
                                            </tr>
                                            <tr>
                                                <td>Quantity Produk</td>
                                                <td>17</td>
                                            </tr>
                                            <tr>
                                                <td>Keterangan</td>
                                                <td>Barang Robek</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row justify-content-between">
            <div class="col-auto"><button type="button" class="btn btn-secondary" data-enchanter="previous">Previous</button></div>
            <div class="col-auto">
              <button type="button" class="btn btn-primary" data-enchanter="next">Next</button>
              <button type="submit" class="btn btn-primary" data-enchanter="finish">Finish</button>
            </div>
          </div> --}}
        </form>
    </div>
</div>


@endsection
