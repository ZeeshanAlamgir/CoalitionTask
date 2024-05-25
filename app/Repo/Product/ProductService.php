<?php

namespace App\Repo\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductService implements ProductInterface
{
    public function index ()
    {
        $data['title'] = "Products";
        $data['description'] = "Show product listing according to their  creation";
        $data['keywords'] = "Product Listing";
        return $data;
    }

    public function store( $request )
    {
        $request = $request['data'];
        $data =
        [
            'product_name'          => $request['product_name'],
            'quantity_in_stock'     => $request['quantity_in_stock'],
            'price_per_item'        => $request['price_per_item'],
            'total_value_number'    => $request['total_value_number'],
            'created_at'            => Carbon::now()->format('d-m-Y H:i:s')
        ];

        $json_storage_file = 'product.json';
        $old_data = [];
        if (Storage::exists($json_storage_file)) {
            $old_data = json_decode(Storage::get($json_storage_file), true);
        }

        $old_data[] = $data;
        Storage::put($json_storage_file, json_encode($old_data));
        return $old_data;
    }

    public function getProductsByAjax(  )
    {
        $json_storage_file = storage_path('app/product.json');
        $json_data = file_get_contents($json_storage_file);
        $products = json_decode($json_data, true);
        return $products;
    }
}
