<?php

namespace App\Http\Controllers;

use App\Repo\Product\ProductInterface;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public $product = null;
    public function __construct( ProductInterface $productInterface )
    {
        $this->product = $productInterface;
    }

    public function index ( )
    {
        $data = $this->product->index();
        return view('frontend.home.index',compact('data'));
    }

    public function store ( Request $request )
    {
        $this->product->store( $request->all() );
        return response()->json(['success' => true]);
    }
}
