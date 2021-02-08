<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    {
        $products = Product::latest()->paginate(12);
    }
}
