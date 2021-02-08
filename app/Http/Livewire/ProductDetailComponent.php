<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Cart;

class ProductDetailComponent extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success', 'Product added to cart');
        return redirect()->route('product.shop');
    }

    public function render()
    {
        // $product = Product::where('slug', $this->slug)->first();
        // $product = DB::table('products')->where('stock_status', 'instock')->dd();

        $product = Product::where('slug', $this->slug)->first();
        // $product = Product::where('regular_price', '>', 30000)->get();
        // dd($product);
        $popular_products = Product::inRandomOrder()->limit(4)->get();
        $related_products = Product::where('category_id', $product->category_id)->inRandomOrder()->limit(10)->get();
        return view('livewire.product-detail-component', [
            'product' => $product,
            'popular_products' => $popular_products,
            'related_products' => $related_products
        ])->layout('templates.base');
    }
}
