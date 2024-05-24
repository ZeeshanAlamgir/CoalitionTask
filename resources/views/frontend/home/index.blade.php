@extends('frontend.layout.app')
@section('title', $data['title'])
@section('description', $data['description'])
@section('keywords', $data['keywords'])

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
    <h1 class="text-center">Task List</h1>

    <table class="mt-3 table table-striped mb-5"  id="sortable-table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Project</th>
                <th scope="col">Priority</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="tbody">
            
        </tbody>
    </table>

@endsection

@section('page-js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>


</script>
@endsection
