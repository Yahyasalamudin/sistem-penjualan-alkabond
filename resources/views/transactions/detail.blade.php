@extends('layouts.app')

@section('content')
<div class="row py-4">
    <div class="col">
        <h1 class="h3 mb-3 text-gray-800"> Detail Pesanan</h1>
        <hr>

    </div>
</div>
<div class="row">
    <div class="col-md-8 col-lg-12">
        <form action="" method="post" id="registration">
            <nav>
                <div class="nav nav-pills nav-fill mb-4" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1">Detail Pesanan</a>
                    <a class="nav-link" id="step2-tab" data-bs-toggle="tab" href="#step2">Pembayaran</a>
                    <a class="nav-link" id="step3-tab" data-bs-toggle="tab" href="#step3">Return Pesanan</a>
                </div>
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
                            <div class="card  mb-4 crddet col">
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

                        <div class="card  mb-4 crddet col">
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
                    <h4>Contact information</h4>
                    <div class="mb-3">
                        <label for="field4">Required field 1</label>
                        <input type="text" name="field4" class="form-control" id="field4" required>
                    </div>
                    <div class="mb-3">
                        <label for="field5">Optional field</label>
                        <input type="text" name="field5" class="form-control" id="field5">
                    </div>
                    <div class="mb-3">
                        <label for="textarea1">Required field 2</label>
                        <textarea name="textarea1" rows="5" class="form-control" id="textarea1" required></textarea>
                    </div>
                </div>
                <div class="tab-pane fade" id="step3">
                    <h4>Review your information</h4>
                    <div class="mb-3">
                        <label for="first_name">Required field 1</label>
                        <input type="text" class="form-control-plaintext" value="Lorem ipsum dolor sit amet">
                    </div>
                    <div class="mb-3">
                        <label for="first_name">Optional field</label>
                        <input type="text" class="form-control-plaintext" value="Lorem ipsum dolor sit amet">
                    </div>
                    <div class="mb-3">
                        <label for="first_name">Required field 2</label>
                        <input type="text" class="form-control-plaintext" value="Lorem ipsum dolor sit amet">
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
