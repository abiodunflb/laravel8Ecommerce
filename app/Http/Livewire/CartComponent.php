<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class CartComponent extends Component
{

    public function increaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty + 1;
        Cart::update($rowId, $qty);
    }

    public function decreaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty - 1;
        Cart::update($rowId, $qty);
    }

    public function deleteCart($rowId)
    {
        Cart::remove($rowId);
        session()->flash('success', 'item removed from cart successfully');
        return redirect()->route('product.cart');
    }

    public function deleteAllCart()
    {
        Cart::destroy();
        session()->flash('success', 'All cart item removed successfully');
        return redirect()->route('product.cart');
    }
    public function render()
    {
        return view('livewire.cart-component')->layout('templates.base');
    }
}
