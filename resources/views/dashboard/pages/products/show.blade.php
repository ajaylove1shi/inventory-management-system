@extends('dashboard.layouts.master')
@section('title', '| Product Details')
@section('page-css-link') @endsection
@section('page-css') 
<style type="text/css">
    .checked {
        color: orange;
    }
</style>
@endsection
@section('main-content')
<!-- Page Content -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Product Details</h1>
    <a href="{{route('products.index')}}" class="btn btn-md btn-danger float-right">Close</a>
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
                <h6 class="m-0 font-weight-bold text-primary">Product Details 
            </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Price</th>
                            <th scope="col">Categories</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {{$product->name}}</td>
                            <td> {{$product->sku}} </td>
                            <td> {{$product->price}} </td>
                            <td> {{ $product->categories()->pluck('name')->implode(',') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"> {{$product->description}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{route('products.edit',$product->id)}}" class="btn btn-md btn-success">Edit</a>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Variation & Other Info</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->query('tabs') == 'attributes' || request()->query('tabs') == '') ? 'active' : '' }}" id="attributes-tab" data-toggle="tab" href="#attributes" role="tab" aria-controls="attributes" aria-selected="true">Attributes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->query('tabs') == 'attribute-values') ? 'active' : '' }}" id="attribute-values-tab" data-toggle="tab" href="#attribute-values" role="tab" aria-controls="attribute-values" aria-selected="false">Attribute Values</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ (request()->query('tabs') == 'variations') ? 'active' : '' }}" id="variations-tab" data-toggle="tab" href="#variations" role="tab" aria-controls="variations" aria-selected="false">Variations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ (request()->query('tabs') == 'comments') ? 'active' : '' }}" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ (request()->query('tabs') == 'feedbacks') ? 'active' : '' }}" id="feedbacks-tab" data-toggle="tab" href="#feedbacks" role="tab" aria-controls="feedbacks" aria-selected="false">Feedbacks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ (request()->query('tabs') == 'ratings') ? 'active' : '' }}" id="ratings-tab" data-toggle="tab" href="#ratings" role="tab" aria-controls="ratings" aria-selected="false">Ratings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ (request()->query('tabs') == 'images') ? 'active' : '' }}" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Images</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  {{ (request()->query('tabs') == 'attributes' || request()->query('tabs') == '') ? 'show active' : '' }}" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
                        <div class="row py-4">
                            <div class="col-4">
                                <div class="card shadow mb-4">
                                    @if (request()->query('action') == 'edit' && request()->query('module') == 'attribute')
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Edit Attribute </h6>
                                    </div>
                                    {{ Form::model($attribute, array('route' => array('attributes.update', $attribute->id), 'method' => 'PUT')) }}
                                        <div class="card-body">
                                            @csrf
                                            <div class="form-group">
                                                {{ Form::label('name', 'Name') }}<i class="text-danger">*</i>
                                                {{ Form::text('name', null , array('class' => 'form-control','placeholder'=>'Enter name here...')) }}
                                                @if ($errors->has('name'))
                                                <span class="text-danger"> {{$errors->first('name')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    {{ Form::close()}}
                                    @else
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Add New </h6>
                                    </div>
                                    <form method="post" action="{{  route('attributes.store')}}">
                                        <div class="card-body">
                                            @csrf
                                            <div class="form-group">
                                                {{ Form::label('name', 'Name') }}<i class="text-danger">*</i>
                                                {{ Form::text('name', null , array('class' => 'form-control','placeholder'=>'Enter name here...')) }}
                                                @if ($errors->has('name'))
                                                <span class="text-danger"> {{$errors->first('name')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">All Attributes</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" >
                                            <table class="table table-bordered table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col" class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($attributes as $index => $attribute)
                                                    <tr>
                                                        <td> <strong>{{++$index}}</strong></td>
                                                        <td> {{$attribute->name}}</td>
                                                        <td scope="col" class="text-right">
                                                            <a href="{{route('products.show',[
                                                            'product' => $product->id,
                                                            'action' => 'edit',
                                                            'module' => 'attribute',
                                                            'attribute' => $attribute->id,
                                                            'tabs' => 'attributes',
                                                            ])}}" class="btn btn-sm btn-success">Edit</a>
                                                            <a href="javascript:void(0);" route="{{route('attributes.destroy',$attribute->id)}}" class="btn btn-sm btn-danger delete">Delete</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="10" class="td_not_found">
                                                            <h3 class="text-center">
                                                            <p class="text-danger"> Attributes Not Found.</p>
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ (request()->query('tabs') == 'attribute-values') ? 'show active' : '' }}" id="attribute-values" role="tabpanel" aria-labelledby="attribute-values-tab">
                        <div class="row py-4">
                            <div class="col-4">
                                <div class="card shadow mb-4">
                                    @if (request()->query('action') == 'edit' && request()->query('module') == 'attribute-value')
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Edit Attribute Value </h6>
                                    </div>
                                    {{ Form::model($attribute_value, array('route' => array('attribute-values.update', $attribute_value->id), 'method' => 'PUT')) }}
                                        <div class="card-body">
                                            @csrf
                                            <div class="form-group">
                                                {{ Form::label('name', 'Name') }}<i class="text-danger">*</i>
                                                {{ Form::text('name', null , array('class' => 'form-control','placeholder'=>'Enter name here...')) }}
                                                @if ($errors->has('name'))
                                                <span class="text-danger"> {{$errors->first('name')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('attribute', 'Attribute') }}<i class="text-danger">*</i>
                                                {{ Form::select('attribute', $attributes->pluck('name','id'), old('attribute',$attribute_value->attribute_id),['class' =>'form-control','placeholder'=>'-- Select Attribute --']) }}
                                                @if ($errors->has('attribute'))
                                                <span class="text-danger"> {{$errors->first('attribute')}} </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    {{ Form::close()}}
                                    @else
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Add New </h6>
                                    </div>
                                    <form method="post" action="{{  route('attribute-values.store')}}">
                                        <div class="card-body">
                                            @csrf
                                            <div class="form-group">
                                                {{ Form::label('name', 'Name') }}<i class="text-danger">*</i>
                                                {{ Form::text('name', null , array('class' => 'form-control','placeholder'=>'Enter name here...')) }}
                                                @if ($errors->has('name'))
                                                <span class="text-danger"> {{$errors->first('name')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('attribute', 'Attribute') }}<i class="text-danger">*</i>
                                                {{ Form::select('attribute', $attributes->pluck('name','id'), old('attribute'),['class' =>'form-control','placeholder'=>'-- Select Attribute --']) }}
                                                @if ($errors->has('attribute'))
                                                <span class="text-danger"> {{$errors->first('attribute')}} </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">All Attribute Values</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" >
                                            <table class="table table-bordered table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Attribute</th>
                                                        <th scope="col" class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($attribute_values as $index => $value)
                                                    <tr>
                                                        <td> <strong>{{++$index}}</strong></td>
                                                        <td> {{$value->name}}</td>
                                                        <td> {!! \DB::table('attributes')->where('id',$value->attribute_id)->value('name') !!}</td>
                                                        <td scope="col" class="text-right">
                                                            <a href="{{route('products.show',[
                                                            'product' => $product->id,
                                                            'action' => 'edit',
                                                            'module' => 'attribute-value',
                                                            'tabs' => 'attribute-values',
                                                            'attribute-value' => $value->id
                                                            ])}}" class="btn btn-sm btn-success">Edit</a>
                                                            <a href="javascript:void(0);" route="{{route('attribute-values.destroy',$value->id)}}" class="btn btn-sm btn-danger delete">Delete</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="10" class="td_not_found">
                                                            <h3 class="text-center">
                                                            <p class="text-danger"> Attribute Values Not Found.</p>
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ (request()->query('tabs') == 'variations') ? 'show active' : '' }}" id="variations" role="tabpanel" aria-labelledby="variations-tab">
                        <div class="row py-4">
                            
                            <div class="col-4">
                                <div class="card shadow mb-4">
                                    @if (request()->query('action') == 'edit' && request()->query('module') == 'variations')
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Edit Variation </h6>
                                    </div>
                                    {{ Form::model($variation, array('route' => array('variations.update', $variation->id), 'method' => 'PUT')) }}
                                        <div class="card-body">
                                            @csrf
                                             <div class="form-group">
                                                {{ Form::label('sku', 'SKU') }}<i class="text-danger">*</i>
                                                {{ Form::text('sku', null , array('class' => 'form-control','placeholder'=>'Enter sku here...')) }}
                                                @if ($errors->has('sku'))
                                                <span class="text-danger"> {{$errors->first('sku')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>

                                            <div class="form-group">
                                                {{ Form::label('price', 'price') }}<i class="text-danger">*</i>
                                                {{ Form::text('price', null , array('class' => 'form-control','placeholder'=>'Enter price here...')) }}
                                                @if ($errors->has('price'))
                                                <span class="text-danger"> {{$errors->first('price')}} </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                {{ Form::label('attribute', 'Attribute') }}<i class="text-danger">*</i>
                                                {{ Form::select('attribute', $attributes->pluck('name','id'), old('attribute',$variation->attribute_id),['class' =>'form-control','placeholder'=>'-- Select Attribute --']) }}
                                                @if ($errors->has('attribute'))
                                                <span class="text-danger"> {{$errors->first('attribute')}} </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                {{ Form::label('attribute_value', 'Attribute Value') }}<i class="text-danger">*</i>
                                                {{ Form::select('attribute_value', $attribute_values->pluck('name','id'), old('attribute_value',$variation->attribute_value_id),['class' =>'form-control','placeholder'=>'-- Select attribute_value --']) }}
                                                @if ($errors->has('attribute_value'))
                                                <span class="text-danger"> {{$errors->first('attribute_value')}} </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    {{ Form::close()}}
                                    @else
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Add New </h6>
                                    </div>
                                    <form method="post" action="{{  route('variations.store')}}">
                                        <div class="card-body">
                                            @csrf
                                             <div class="form-group">
                                                {{ Form::label('sku', 'SKU') }}<i class="text-danger">*</i>
                                                {{ Form::text('sku', null , array('class' => 'form-control','placeholder'=>'Enter sku here...')) }}
                                                @if ($errors->has('sku'))
                                                <span class="text-danger"> {{$errors->first('sku')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>

                                            <div class="form-group">
                                                {{ Form::label('price', 'Price') }}<i class="text-danger">*</i>
                                                {{ Form::text('price', null , array('class' => 'form-control','placeholder'=>'Enter price here...')) }}
                                                @if ($errors->has('price'))
                                                <span class="text-danger"> {{$errors->first('price')}} </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                {{ Form::label('attribute', 'Attribute') }}<i class="text-danger">*</i>
                                                {{ Form::select('attribute', $attributes->pluck('name','id'), old('attribute'),['class' =>'form-control','placeholder'=>'-- Select Attribute --']) }}
                                                @if ($errors->has('attribute'))
                                                <span class="text-danger"> {{$errors->first('attribute')}} </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                {{ Form::label('attribute_value', 'Attribute Value') }}<i class="text-danger">*</i>
                                                {{ Form::select('attribute_value',[], old('attribute_value'),['class' =>'form-control','placeholder'=>'-- Select Attribute Value --']) }}
                                                @if ($errors->has('attribute_value'))
                                                <span class="text-danger"> {{$errors->first('attribute_value')}} </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>

                             <div class="col-8">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">All Variations</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" >
                                            <table class="table table-bordered table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">SKU</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Attribute</th>
                                                        <th scope="col">Attribute Value</th>
                                                        <th scope="col" class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($variations as $index => $value)
                                                    <tr>
                                                        <td> <strong>{{++$index}}</strong></td>
                                                        <td> {{$value->sku}}</td>
                                                        <td> {{$value->price}}</td>
                                                        <td> {{$value->attribute_name}}</td>
                                                        <td> {{$value->attribute_value_name}}</td>
                                                        <td scope="col" class="text-right">
                                                            <a href="{{route('products.show',[
                                                            'product' => $product->id,
                                                            'action' => 'edit',
                                                            'module' => 'variations',
                                                            'tabs' => 'variations',
                                                            'variations' => $value->id
                                                            ])}}" class="btn btn-sm btn-success">Edit</a>
                                                            <a href="javascript:void(0);" route="{{route('variations.destroy',$value->id)}}" class="btn btn-sm btn-danger delete">Delete</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="10" class="td_not_found">
                                                            <h3 class="text-center">
                                                            <p class="text-danger"> Attribute Values Not Found.</p>
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="tab-pane fade {{ (request()->query('tabs') == 'comments') ? 'show active' : '' }}" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                        <div class="row py-4">
                            <div class="col-4">
                                <div class="card shadow mb-4">
                                    @if (request()->query('action') == 'edit' && request()->query('module') == 'comments')
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Edit Comment </h6>
                                    </div>
                                    {{ Form::model($comment, array('route' => array('comments.update', $comment->id), 'method' => 'PUT')) }}
                                        <div class="card-body">
                                            @csrf
                                              <div class="form-group">
                                                {{ Form::label('comment', 'Comment') }}<i class="text-danger">*</i>
                                                {{ Form::textarea('comment', null , array('class' => 'form-control','placeholder'=>'Enter comment here...')) }}
                                                @if ($errors->has('comment'))
                                                <span class="text-danger"> {{$errors->first('comment')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    {{ Form::close()}}
                                    @else
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Add New </h6>
                                    </div>
                                    <form method="post" action="{{  route('comments.store')}}">
                                        <div class="card-body">
                                            @csrf
                                             <div class="form-group">
                                                {{ Form::label('comment', 'Comment') }}<i class="text-danger">*</i>
                                                {{ Form::textarea('comment', null , array('class' => 'form-control','placeholder'=>'Enter comment here...')) }}
                                                @if ($errors->has('comment'))
                                                <span class="text-danger"> {{$errors->first('comment')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>

                             <div class="col-8">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">All Comments</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" >
                                            <table class="table table-bordered table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Comment</th>
                                                        <th scope="col" class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($product->comments as $index => $value)
                                                    <tr>
                                                        <td> <strong>{{++$index}}</strong></td>
                                                        <td> {{$value->comment}} <br>
                                                            <em><strong>{{ date('d, F Y', strtotime($value->created_at))}}</strong></em>
                                                        </td>
                                                        <td scope="col" class="text-right">
                                                            <a href="{{route('products.show',[
                                                            'product' => $product->id,
                                                            'action' => 'edit',
                                                            'module' => 'comments',
                                                            'tabs' => 'comments',
                                                            'comments' => $value->id
                                                            ])}}" class="btn btn-sm btn-success">Edit</a>
                                                            <a href="javascript:void(0);" route="{{route('comments.destroy',$value->id)}}" class="btn btn-sm btn-danger delete">Delete</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="10" class="td_not_found">
                                                            <h3 class="text-center">
                                                            <p class="text-danger"> Comment Not Found.</p>
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ (request()->query('tabs') == 'feedbacks') ? 'show active' : '' }}" id="feedbacks" role="tabpanel" aria-labelledby="feedbacks-tab">
                        <div class="row py-4">
                            <div class="col-4">
                                <div class="card shadow mb-4">
                                    @if (request()->query('action') == 'edit' && request()->query('module') == 'feedbacks')
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Edit Feedback </h6>
                                    </div>
                                    {{ Form::model($feedback, array('route' => array('feedbacks.update', $feedback->id), 'method' => 'PUT')) }}
                                        <div class="card-body">
                                            @csrf
                                              <div class="form-group">
                                                {{ Form::label('feedback', 'Feedback') }}<i class="text-danger">*</i>
                                                {{ Form::textarea('feedback', null , array('class' => 'form-control','placeholder'=>'Enter feedback here...')) }}
                                                @if ($errors->has('feedback'))
                                                <span class="text-danger"> {{$errors->first('feedback')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    {{ Form::close()}}
                                    @else
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Add New </h6>
                                    </div>
                                    <form method="post" action="{{  route('feedbacks.store')}}">
                                        <div class="card-body">
                                            @csrf
                                             <div class="form-group">
                                                {{ Form::label('feedback', 'Feedback') }}<i class="text-danger">*</i>
                                                {{ Form::textarea('feedback', null , array('class' => 'form-control','placeholder'=>'Enter feedback here...')) }}
                                                @if ($errors->has('feedback'))
                                                <span class="text-danger"> {{$errors->first('feedback')}} </span>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>

                             <div class="col-8">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">All Feedbacks</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" >
                                            <table class="table table-bordered table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Feedback</th>
                                                        <th scope="col" class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($product->feedbacks as $index => $value)
                                                    <tr>
                                                        <td> <strong>{{++$index}}</strong></td>
                                                        <td> {{$value->feedback}} <br>
                                                            <em><strong>{{ date('d, F Y', strtotime($value->created_at))}}</strong></em>
                                                        </td>
                                                        <td scope="col" class="text-right">
                                                            <a href="{{route('products.show',[
                                                            'product' => $product->id,
                                                            'action' => 'edit',
                                                            'module' => 'feedbacks',
                                                            'tabs' => 'feedbacks',
                                                            'feedbacks' => $value->id
                                                            ])}}" class="btn btn-sm btn-success">Edit</a>
                                                            <a href="javascript:void(0);" route="{{route('feedbacks.destroy',$value->id)}}" class="btn btn-sm btn-danger delete">Delete</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="10" class="td_not_found">
                                                            <h3 class="text-center">
                                                            <p class="text-danger"> Feedback Not Found.</p>
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="tab-pane fade {{ (request()->query('tabs') == 'ratings') ? 'show active' : '' }}" id="ratings" role="tabpanel" aria-labelledby="ratings-tab">
                        <div class="row py-4">
                            <div class="col-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Update Rating </h6>
                                    </div>
                                        <div class="card-body">
                                             <div class="sproductreviewform-rating">
                                                <span class="fa fa-star {{ ($product->ratings == '1') ? 'checked-r' : ''}}" id="star1" onclick="rating(this,1,{{$product->id}})"></span>
                                                <span class="fa fa-star {{ ($product->ratings == '2') ? 'checked-r' : ''}}" id="star2" onclick="rating(this,2,{{$product->id}})"></span>
                                                <span class="fa fa-star {{ ($product->ratings == '3') ? 'checked-r' : ''}}" id="star3" onclick="rating(this,3,{{$product->id}})"></span>
                                                <span class="fa fa-star {{ ($product->ratings == '4') ? 'checked-r' : ''}}" id="star4" onclick="rating(this,4,{{$product->id}})"></span>
                                                <span class="fa fa-star {{ ($product->ratings == '5') ? 'checked-r' : ''}}" id="star5" onclick="rating(this,5,{{$product->id}})"></span>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-8" style="font-size: 50px;">
                                        <h6 class="m-0 font-weight-bold text-primary">Rating </h6>
                                {!! $get_rating_star !!}
                            </div>
                        </div>
                    </div>  
                    <div class="tab-pane fade {{ (request()->query('tabs') == 'images') ? 'show active' : '' }}" id="images" role="tabpanel" aria-labelledby="images-tab">
                        <div class="row py-4">
                                @foreach ($images as $gallery)
                                <div class="col-md-3">
                                    <img alt="" class="img-thumbnail" src="{{ asset('/storage/products/'.$gallery) }}">
                                </div>
                                @endforeach
                        </div>
                    </div>                    
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

    if (!confirm("Do you want to delete this?")){
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
$(document).on('change', 'select[name="attribute"]', function() {
    attribute = $(this).val();
    $.ajax({
        url: "{{route('attribute.values')}}",
        method: "Post",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "attribute": attribute,
        },
        success: function(data) {
            if (data.status) {
                if (data.status == 'success') {
                    //do something...
                    $('select[name="attribute_value"]').html(data.option);
                }
                if (data.status == 'error') {
                    //do something...
                }
            }
        }
    })
});

function rating(ths,sno,product){
    for (var i=1;i<=5;i++){
        var cur=document.getElementById("star"+i)
        cur.className="fa fa-star"
    }
    for (var i=1;i<=sno;i++){
        var cur=document.getElementById("star"+i)
        if(cur.className=="fa fa-star")
        {
            cur.className="fa fa-star checked"
        }
    }
    $.ajax({
        url: "{{route('products.ratings')}}",
        method: "Post",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "rating": sno,
            "product": product,
        },
        success: function(data) {
            if (data.status) {
                if (data.status == 'success') {
                    //do something...
                }
                if (data.status == 'error') {
                    //do something...
                }
               window.location.href = "{{route('products.show',['product'=>$product->id,'tabs'=>'ratings'])}}";
            }
        }
    })
}
</script>
@endsection