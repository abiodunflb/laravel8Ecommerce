<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Cart;
use Livewire\WithPagination;
use App\Models\Category;

class ShopComponent extends Component
{

    public $sorting;
    public $pagesize;

    public function mount()
    {
        $this->sorting = "default";
        $this->pagesize = 12;
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success', 'Product added to cart');
        return redirect()->route('product.shop');
    }

    use WithPagination;
    public function render()
    {
        if ($this->sorting == 'date') {
            $products = Product::orderBy('created_at', 'DESC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price') {
            $products = Product::orderBy('regular_price', 'ASC')->paginate($this->pagesize);
        } else if ($this->sorting == 'desc_price') {
            $products = Product::orderBy('regular_price', 'DESC')->paginate($this->pagesize);
        } else {
            $products = Product::latest()->paginate($this->pagesize);
        }

        $categories = Category::all();

        return view('livewire.shop-component', compact('products', 'categories'))->layout('templates.base');
    }
}
