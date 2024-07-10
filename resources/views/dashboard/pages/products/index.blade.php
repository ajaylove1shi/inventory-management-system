@extends('dashboard.layouts.master')
@section('title', '| Products')
@section('page-css-link') @endsection
@section('page-css') @endsection
@section('main-content')
<!-- Page Content -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">All Products</h1>
    <a href="{{route('products.create')}}" class="btn btn-md btn-success float-right">Add New</a>
</div>
@if (Session::has('status') && (Session::get('status') == 'success'))
<div class="alert alert-success alert-dismissible " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> {{ session()->get('text') }}
</div>
@endif
@if (Session::has('status') && (Session::get('status') == 'danger'))
<div class="alert alert-danger alert-dismissible " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Error!</strong> {{ session()->get('text') }}
</div>
@endif
<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" >
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">SKU</th>
                                <th scope="col">Price</th>
                                <th scope="col">Categories</th>
                                <th scope="col" width="20%" class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                            <tr>
                                <td> <strong>{{$index + $products->firstItem()}}</strong></td>
                                <td>  <a href="{{route('products.show',$product->id)}}">{{$product->name}} </a>
                                </td>
                                <td> {{$product->sku}} </td>
                                <td> {{$product->price}} </td>
                                <td> {{ $product->categories()->pluck('name')->implode(',') }}</td>
                                <td scope="col" class="text-right">
                                    <a href="{{route('products.show',$product->id)}}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{route('products.edit',$product->id)}}" class="btn btn-sm btn-success">Edit</a>
                                    <a href="javascript:void(0);" route="{{route('products.destroy',$product->id)}}" class="btn btn-sm btn-danger delete">Delete</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="td_not_found">
                                    <h3 class="text-center">
                                    <p class="text-danger"> Product Not Found.</p>
                                    </h3>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-js-link') @endsection
@section('page-js') 
<script type="text/javascript">
$(document).on('click', '.delete', function() {
    route = $(this).attr('route');

    if (!confirm("Do you want to delete product?")){
      return false;
    }

    $.ajax({
        url: route,
        method: "DELETE",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            if (data.status) {
                if (data.status == 'success') {
                    //do something...
                }
                if (data.status == 'error') {
                    //do something...
                }
                location.reload();
            }
        }
    })
});
</script>
@endsection