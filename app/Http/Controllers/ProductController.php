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

    public function index ( Request $request )
    {
        $data = $this->product->index();
        return view('frontend.home.index',compact( 'data' ));
    }

    public function store ( Request $request )
    {
        $data = $this->product->store( $request->all() );
        if( count( $data ) > 0 )
            return apiSuccessResponse();
        else
            return apiErrorResponse();
    }

    public function getProducts ( Request $request )
    {
        if( $request->ajax() )
            $data['products'] = $this->product->getProductsByAjax();
        if( count( $data['products'] ) > 0 )
            return apiSuccessResponse( $data['products'] );
        else
            return apiErrorResponse();
    }
}
