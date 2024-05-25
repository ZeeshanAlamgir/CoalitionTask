@extends('frontend.layout.app')
@section('title', $data['title'])
@section('description', $data['description'])
@section('keywords', $data['keywords'])
@section('page-css')
<style>
    label,.grand_total_col {
        font-weight: bold;
    }
    .grand_total_col {
        font-size: 30px !important;
    }
    #productsTable {
        margin-bottom: 6rem !important;
    }
</style>
@endsection
@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if(Session::has('danger'))
        <div class="alert alert-danger">
            {{ Session::get('danger') }}
        </div>
    @endif
    <h2 class="text-center mt-3 mb-3">Create Product</h2>
    <form id="product_form">
        <div class="row">
            <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
            <div class="col-md-4">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name">
            </div>
            <div class="col-md-4">
                <label for="quantity_in_stock">Quantity in Stock</label>
                <input type="number" min="0" name="quantity_in_stock" id="quantity_in_stock" class="form-control" placeholder="Quantity in Stock">
            </div>
            <div class="col-md-4">
                <label for="price_per_item">Price Per Item</label>
                <input type="number" min="0" name="price_per_item" id="price_per_item" class="form-control" placeholder="Price Per Item">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="total_value_number">Total Value Number</label>
                <input type="text" class="form-control" placeholder="Total Value Number" name="total_value_number" id="total_value_number" readonly>
            </div>
            <div class="col-md-2 mt-4">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </form>

    <h2 class="text-center mt-4">Product Listing</h2>

    <table class="mt-5 table table-striped" id="productsTable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity in Stock</th>
                <th scope="col">Price per Item</th>
                <th scope="col">Datetime submitted</th>
                <th scope="col">Total Value Number</th>
            </tr>
        </thead>
        <tbody id="tbody">
            
        </tbody>
    </table>

@endsection

@section('page-js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js" integrity="sha512-bztGAvCE/3+a1Oh0gUro7BHukf6v7zpzrAb3ReWAVrt+bVNNphcl2tDTKCBr5zk7iEDmQ2Bv401fX3jeVXGIcA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    // Initialize variable
    
    // Page full loaded fetch the products
    $(document).ready(function () {
        fetchProducts();
    });

    // Fetch Products
    function fetchProducts() {
        $.ajax({
            type: "GET",
            url: "{{route('products')}}",
            success: function (response) {
                if( response.status ) {
                    let html = '';
                    let grand_total = 0;
                    $('#tbody').empty();
                    response.data.forEach((product,index) => {
                        grand_total += parseInt(product.total_value_number);
                        html+=`
                        <tr>
                            <td>${index+1}</td>
                            <td>${product.product_name}</td>
                            <td>${product.quantity_in_stock}</td>
                            <td>${product.price_per_item}</td>
                            <td>${product.created_at}</td>
                            <td class="product_total_value_number">${product.total_value_number}</td>
                            <td></td>
                        </tr>`;
                        
                    });
                    html+=`
                    <tr>
                        <td colspan="5"></td>
                        <td class="grand_total_col">${grand_total}</td>
                        <td colspan="1"></td>
                    </tr>`;
                    $('#tbody').append(html);
                }               
            }
        });
    }


    //For Quantity In Stock
    $(document).on('input','#quantity_in_stock',function(){

        let quantity_in_stock = $(this).val();
        let price_per_item = $('#price_per_item').val();
        quantity_in_stock = quantity_in_stock <= 0 ? 0 : parseInt(quantity_in_stock);
        resetValue('#quantity_in_stock',quantity_in_stock);
        calculateTotalNumberValue(quantity_in_stock,price_per_item);

    });

    //For Price Per Item
    $(document).on('input','#price_per_item',function(){

        price_per_item = $(this).val();
        let quantity_in_stock = $('#quantity_in_stock').val();
        price_per_item = price_per_item <= 0 ? 0 : parseInt(price_per_item);
        resetValue('#price_per_item',price_per_item);
        calculateTotalNumberValue(quantity_in_stock,price_per_item);

    });

    // For Reset value
    function resetValue(resetInputField,value) {
        $(resetInputField).val(value <= 0 ? parseInt(0) : parseInt(value));
    }

    // Calculate Total Number Value 
    function calculateTotalNumberValue(quantity_in_stock,price_per_item) {

        let totalNumberValue = 0;
        quantity_in_stock = quantity_in_stock == NaN ? 0 : parseInt(quantity_in_stock);
        totalNumberValue = quantity_in_stock * price_per_item;
        $totalNumberValue = totalNumberValue == NaN ? 0 : totalNumberValue;
        $('#total_value_number').val(totalNumberValue);

    }

    // Submit Form Using Ajax
    $('#product_form').submit(function(e){
        e.preventDefault();   

        let required_field_array = [];
        let product_name = $('#product_name').val();
        let quantity_in_stock = $('#quantity_in_stock').val();
        let price_per_item = $('#price_per_item').val();
        let total_value_number = $('#total_value_number').val();

        let data = 
        {
            'product_name'      : product_name,
            'quantity_in_stock' : quantity_in_stock,
            'price_per_item'    : price_per_item,
            'total_value_number': total_value_number,
        }
        
        for (const key in data) {
            if (data[key] == [] || data[key] == NaN) {
                required_field_array.push(key);
            }
        }

        if (required_field_array.length > 0) {
            validate(required_field_array);
        }
        else {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('product.store')}}",
                data: {
                    data
                },
                dataType: "json",
                success: function (response) {
                    if(response.status) {
                        fetchProducts();
                        toastr.success("Product Added Successfully");
                        $('#product_form')[0].reset();
                    }else {
                        toastr.error("Something went wrong");
                    }
                }
            });
        }
    });

    // Validate Form and show error messages
    function validate(required_field_array) {

        let custom_validation_message_array = [];
        let reverse_custom_validation_message_array = []; 

        for (let i = 0; i < required_field_array.length; i++) {
            if (required_field_array[i].includes('product_name')) {
                custom_validation_message_array.push("Product Name");
            }
            if (required_field_array[i].includes('quantity_in_stock')) {
                custom_validation_message_array.push("Quantity in Stock");
            }
            if (required_field_array[i].includes('price_per_item')) {
                custom_validation_message_array.push("Price Per Item");
            }
            if (required_field_array[i].includes('total_value_number')) {
                custom_validation_message_array.push("Total value Number");
            }
        }

        //Reverse the array in order to asecending form
        reverse_custom_validation_message_array = custom_validation_message_array.reverse();

        for (let j = 0; j < reverse_custom_validation_message_array.length; j++) {
            toastr.error(reverse_custom_validation_message_array[j] + " is required");
        }
    }

</script>
@endsection
