<div>
    <div class="modal fade bd-example-modal-lg" id="modal-cart" tabindex="-1" aria-labelledby="modal-cart"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-cart-title">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post">
                    @csrf
                    <div class="card-body">
                        @error('user.id')
                            <div class="alert alert-danger alert-dismissible" id="flash_data1" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="table-responsive">
                            <table class="table table-bordered text-center text-center table-hover" width="100%"
                                cellspacing="0">
                                <select class="form-control mb-3" wire:model="selectedType">
                                    <option value="">- Pilih Jenis Product -</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->type }}">{{ $type->type }}</option>
                                    @endforeach
                                </select>
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Satuan Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $p)
                                        <tr wire:key="{{ $p->id }}" class="hover-pointer"
                                            wire:click="store({{ $p->id }})">
                                            <td>{{ $p->product_name . ' - ' . $p->product_brand }}</td>
                                            <td>{{ $p->unit_weight }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered text-center text-center" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Produk</th>
                    <th>Harga Produk</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product_carts as $key => $product_cart)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            {{ $product_cart->product->product_name . ' - ' . $product_cart->product->product_brand . ' - ' . $product_cart->product->unit_weight }}
                        </td>
                        <td>
                            <input class="form-control mb-3" type="number"
                                wire:model="product_cart.{{ $product_cart->id }}.quantity"
                                wire:blur="update({{ $product_cart->id }})" placeholder="Masukkan Jumlah Barang"
                                value="{{ $product_cart->quantity }}">
                        </td>
                        <td>
                            <input class="form-control mb-3" type="number"
                                wire:model="product_cart.{{ $product_cart->id }}.price"
                                wire:blur="update({{ $product_cart->id }})" placeholder="Masukkan Harga"
                                value="{{ $product_cart->price }}">
                        </td>
                        <td>
                            {{ 'Rp ' . number_format(($product_cart->quantity ?: 0) * ($product_cart->price ?: 0)) }}
                        </td>
                        <td>
                            <button type="button" wire:click="delete({{ $product_cart->id }})" class="btn btn-danger"
                                data-toggle="tooltip" data-placement="top" title="Hapus Product">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
