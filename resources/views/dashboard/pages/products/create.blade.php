@extends('dashboard.layouts.master')
@section('title', '| Add Product')
@section('page-css-link') @endsection
@section('page-css')
<style type="text/css">
      .files input {
        outline: 2px dashed #92b0b3;
        outline-offset: -10px;
        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear;
        padding: 51px 0px 67px 15%;
        text-align: center !important;
        margin: 0;
        width: 100% !important;
    }
    .files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
    }
    .files{ position:relative}
    .files:after {  pointer-events: none;
        position: absolute;
        top: 60px;
        left: 0;
        width: 50px;
        right: 0;
        height: 56px;
        content: "";
        /*background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);*/
        display: block;
        margin: 0 auto;
        background-size: 100%;
        background-repeat: no-repeat;
    }
    .color input{ background-color:#f1f1f1;}
    .files:before {
        position: absolute;
        bottom: 9px;
        left: 0;
        pointer-events: none;
        width: 100%;
        right: 0;
        height: 52px;
        content: " or drag it here. ";
        display: block;
        margin: 0 auto;
        color: #2ea591;
        font-weight: 600;
        text-transform: capitalize;
        text-align: center;
    }
</style>
@endsection
@section('main-content')
<!-- Page Content -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add Product</h1>
    <a href="{{route('products.index')}}" class="btn btn-md btn-danger float-right">Cancel</a>
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
                <h6 class="m-0 font-weight-bold text-primary">Add New </h6>
            </div>
            <form method="post" action="{{  route('products.store')}}"  enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}<i class="text-danger">*</i>
                                {{ Form::text('name', null , array('class' => 'form-control','placeholder'=>'Enter name here...')) }}
                                @if ($errors->has('name'))
                                <span class="text-danger"> {{$errors->first('name')}} </span>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('price', 'Price') }}<i class="text-danger">*</i>
                                {{ Form::text('price', null , array('class' => 'form-control','placeholder'=>'Enter price here...')) }}
                                @if ($errors->has('price'))
                                <span class="text-danger"> {{$errors->first('price')}} </span>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('sku', 'SKU') }}<i class="text-danger">*</i>
                                {{ Form::text('sku', null , array('class' => 'form-control','placeholder'=>'Enter sku here...')) }}
                                @if ($errors->has('sku'))
                                <span class="text-danger"> {{$errors->first('sku')}} </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                {{ Form::label('category', 'Category') }}<i class="text-danger">*</i>
                                <ul class="category-parent">
                                    @if($categories)
                                    @php
                                    $old_categories = (!empty(old('category'))) ? old('category') : [];
                                    @endphp
                                    @foreach($categories as $category)
                                    <li class="categories-list">
                                        <label for="category" class="control-label parent-category">
                                            <input class="" type="checkbox" name="category[]" id="category" value="{{ $category->id }}"  {{in_array( $category->id, $old_categories) ? 'checked=checked' : '' }} >
                                            <span> {{ $category->name }} </span>
                                        </label>
                                        @if($category->children)
                                        <ul class="category-children">
                                            @foreach($category->children as $subCategory)
                                            <li>
                                                <label for="subCategory" class="control-label children-label">
                                                    <input class="" type="checkbox" name="category[]" id="subCategory" value="{{ $subCategory->id }}"   {{in_array( $category->id, $old_categories) ? 'checked=checked' : '' }}>
                                                    <span> {{ $subCategory->name }} </span>
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                                @if ($errors->has('category'))
                                <span class="text-danger"> {{$errors->first('category')}} </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="files">
                                    {{ Form::label('images', 'Images') }}<i class="text-danger">*</i>
                                    <input type="file" name="images[]" id="images" multiple="true" />
                                    <span id="images"></span>
                                </div>
                                @if ($errors->has('images'))
                                <span class="text-danger"> {{$errors->first('images')}} </span>
                                @endif    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', 'Description') }}<i class="text-danger">*</i>
                        {{ Form::textarea('description', null , array('class' => 'form-control','placeholder'=>'Enter description here...')) }}
                        @if ($errors->has('description'))
                        <span class="text-danger"> {{$errors->first('description')}} </span>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success  btn-md"><i class="fa fa-save"></i>  Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('page-js-link') @endsection
@section('page-js') @endsection