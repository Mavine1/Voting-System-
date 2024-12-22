<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index(){

    $products = Product::get();

    return ProductResource::collection($products);
   }
}
