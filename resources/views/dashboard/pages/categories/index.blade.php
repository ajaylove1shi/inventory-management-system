@extends('dashboard.layouts.master')
@section('title', '| Categories')
@section('page-css-link') @endsection
@section('page-css') @endsection
@section('main-content')
<!-- Page Content -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">All Categories</h1>
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
	<div class="col-4">
		<div class="card shadow mb-4">
			@if(!request()->routeIs('categories.index'))
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Edit Category </h6>
				</div>
                {{ Form::model($category, array('route' => array('categories.update', $category->id), 'method' => 'PUT')) }}
				<div class="card-body">
					@csrf
					<div class="form-group">
						{{ Form::label('name', 'Name') }}<i class="text-danger">*</i>
						{{ Form::text('name', null , array('class' => 'form-control','placeholder'=>'Enter name here...')) }}
						@if ($errors->has('name'))
						<span class="text-danger"> {{$errors->first('name')}} </span>
						@endif
					</div>
					<div class="form-group">
						{{ Form::label('parent', 'Parent') }}
						{{ Form::select('parent', $parents, old('parent',$category->parent_id),['class' =>'form-control','placeholder'=>'-- Select parent --']) }}
						@if ($errors->has('parent'))
						<span class="text-danger"> {{$errors->first('parent')}} </span>
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
			<form method="post" action="{{  route('categories.store')}}">
				<div class="card-body">
					@csrf
					<div class="form-group">
						{{ Form::label('name', 'Name') }}<i class="text-danger">*</i>
						{{ Form::text('name', null , array('class' => 'form-control','placeholder'=>'Enter name here...')) }}
						@if ($errors->has('name'))
						<span class="text-danger"> {{$errors->first('name')}} </span>
						@endif
					</div>
					<div class="form-group">
						{{ Form::label('parent', 'Parent') }}
						{{ Form::select('parent', $parents, old('parent'),['class' =>'form-control','placeholder'=>'-- Select parent --']) }}
						@if ($errors->has('parent'))
						<span class="text-danger"> {{$errors->first('parent')}} </span>
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
				<h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive" >
					<table class="table table-bordered table-hover mb-0">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Parent</th>
								<th scope="col" width="20%" class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($categories as $index => $category)
							<tr>
								<td> <strong>{{$index + $categories->firstItem()}}</strong></td>
								<td> {{$category->name}}</td>
								<td> {{ (!empty($category->parent()->first())) ? $category->parent()->first()->name : '' }} </td>
								<td scope="col" class="text-right">
									<a href="{{route('categories.edit',$category->id)}}" class="btn btn-sm btn-success">Edit</a>
									<a href="javascript:void(0);" route="{{route('categories.destroy',$category->id)}}" class="btn btn-sm btn-danger delete">Delete</a>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="10" class="td_not_found">
									<h3 class="text-center">
									<p class="text-danger"> Category Not Found.</p>
									</h3>
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
					{{ $categories->links() }}
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

    if (!confirm("Do you want to delete category?")){
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