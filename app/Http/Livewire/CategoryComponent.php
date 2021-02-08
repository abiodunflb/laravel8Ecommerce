<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Cart;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryComponent extends Component
{

    public $sorting;
    public $pagesize;
    public $category_slug;

    public function mount($category_slug)
    {
        $this->sorting = "default";
        $this->pagesize = 12;
        $this->category_slug = $category_slug;
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

        $category = Category::where('slug', $this->category_slug)->first();
        $category_id = $category->id;
        $category_name = $category->name;
        if ($this->sorting == 'date') {
            $products = Product::where('category_id', $category_id)->orderBy('created_at', 'DESC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price') {
            $products = Product::where('category_id', $category_id)->orderBy('regular_price', 'ASC')->paginate($this->pagesize);
        } else if ($this->sorting == 'desc_price') {
            $products = Product::where('category_id', $category_id)->orderBy('regular_price', 'DESC')->paginate($this->pagesize);
        } else {
            $products = Product::where('category_id', $category_id)->latest()->paginate($this->pagesize);
        }

        $categories = Category::all();

        return view('livewire.category-component', compact('products', 'categories', 'category_name'))->layout('templates.base');
    }
}
