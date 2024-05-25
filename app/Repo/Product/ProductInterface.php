<?php

namespace App\Repo\Product;

interface ProductInterface
{
    public function index( );
    public function store( $request );
    public function getProductsByAjax( );
}
