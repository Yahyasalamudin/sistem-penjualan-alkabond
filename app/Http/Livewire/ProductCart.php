<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\ProductCart as ProductCartModel;
use App\Models\Type;
use Livewire\Component;

class ProductCart extends Component
{
    public $user, $types, $products;
    public $selectedType = null;
    public $product_cart = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->types = Type::get();
        $this->products = Product::get();
        $this->emit('componentLoaded');

        $productCarts = ProductCartModel::where('user_id', $this->user->id)->get();

        foreach ($productCarts as $productCart) {
            $this->product_cart[$productCart->id]['quantity'] = $productCart->quantity;
            $this->product_cart[$productCart->id]['price'] = $productCart->price;
        }
    }

    public function render()
    {
        return view('livewire.product-cart', [
            'types' => $this->types,
            'products' => $this->products,
            'product_carts' => ProductCartModel::where('user_id', $this->user->id)->get()
        ]);
    }

    public function updatedSelectedType()
    {
        if (!empty($this->selectedType)) {
            $this->products = Product::where('product_name', $this->selectedType)->get();
        } else {
            $this->products = Product::get();
        }
    }

    public function store($product_id)
    {
        $this->validate([
            'user.id' => 'unique:product_carts,user_id,NULL,id,product_id,' . $product_id,
        ], [
            'user.id.unique' => 'Anda sudah menambahkan produk ini ke keranjang.',
        ]);

        $product_cart = ProductCartModel::create([
            'user_id' => $this->user->id,
            'product_id' => $product_id,
        ]);

        if ($product_cart) {
            $this->emit('componentLoaded');
        }
    }

    public function update($productCartId)
    {
        $productCart = ProductCartModel::find($productCartId);

        if ($productCart) {
            $data = $this->product_cart[$productCartId] ?? [];

            $price = '';
            if (!empty($data['price'])) {
                $price = str_replace(['Rp. ', '.', ','], '', $data['price']);
            }

            if (isset($data['quantity'])) {
                $productCart->update([
                    'quantity' => $data['quantity'] ?: 0,
                ]);
            }

            if (isset($data['price'])) {
                $productCart->update([
                    'price' => $price ?: 0,
                ]);
            }
        }
    }

    public function delete($productCartId)
    {
        ProductCartModel::find($productCartId)->delete();

        $this->emit('componentLoaded');
    }
}
