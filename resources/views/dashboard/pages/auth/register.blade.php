@extends('dashboard.layouts.auth')
@section('title', '| Register')
@section('page-css-link') @endsection
@section('page-css') 
<style type="text/css">
    .error{
        font-size: medium !important;
    }
</style>
@endsection
@section('main-content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                    </div>
                    <form method="POST" id="register-form" action="{{ route('register') }}" class="user">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                {{ Form::text('first_name', old('first_name') , array('class' =>'form-control form-control-user', 'placeholder'=>'Enter first name here...')) }}
                                @if ($errors->has('first_name'))
                                <span class="text-danger"> {{$errors->first('first_name')}} </span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                {{ Form::text('last_name', old('last_name') , array('class' =>'form-control form-control-user', 'placeholder'=>'Enter last name here...')) }}
                                @if ($errors->has('last_name'))
                                <span class="text-danger"> {{$errors->first('last_name')}} </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::text('email', old('email') , array('class' =>'form-control form-control-user', 'placeholder'=>'Enter email here...')) }}
                            @if ($errors->has('email'))
                            <span class="text-danger"> {{$errors->first('email')}} </span>
                            @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                {{ Form::password('password', array('class' =>'form-control form-control-user','id' =>'password','placeholder'=>'Enter password here...')) }}
                                @if ($errors->has('password'))
                                <span class="text-danger"> {{$errors->first('password')}} </span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                {{ Form::password('password_confirmation', array('class' =>'form-control form-control-user','placeholder'=>'Enter password confirmation here...')) }}
                                @if ($errors->has('password_confirmation'))
                                <span class="text-danger"> {{$errors->first('password_confirmation')}} </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group">
                         <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="role3" checked="true" name="role" value="3" class="custom-control-input">
                              <label class="custom-control-label" for="role3"> Customer</label>
                            </div>   
                         <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="role1" name="role" class="custom-control-input" value="1">
                              <label class="custom-control-label" for="role1"> Admin</label>
                            </div>
                          <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="role2" name="role" class="custom-control-input" value="2">
                              <label class="custom-control-label" for="role2"> Sub Admin</label>
                            </div> 
                             @if ($errors->has('role'))
                             <br>
                                <span class="text-danger"> {{$errors->first('role')}} </span>
                             @endif
                        </div>   
                        <button class="btn btn-primary btn-user btn-block" type="submit">Register</button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{route('login')}}">Already have an account? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-js-link')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
@endsection
@section('page-js') 
<script type="text/javascript">
$(document).ready( function () {
    $.validator.addMethod("email_regex", function(value, element) {
        return this.optional(element) || /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/i.test(value);
    }, "Please enter a valid email address.");

    $( "#register-form" ).validate( {
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email_regex: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        messages: {
            first_name: "Please enter user first name.",
            last_name: "Please enter user last name.",
            email:{
                required: "Please enter the email address."
            },
            password: {
                required: "Please provide a user password.",
                minlength: "Your password must be at least 8 characters long."
            },
            password_confirmation: {
                required: "Please provide a user confirm password.",
                minlength: "Your password must be at least 8 characters long.",
                equalTo: "Please enter the same password as password."
            },
        },
        errorElement: "span",
        errorPlacement: function ( error, element ) {
            error.addClass( "text-danger" );
            element.addClass( "has-feedback" );
           
            if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
            if ( !element.next( "span" )[ 0 ] ) {
                $( "<span class='fa fa-remove form-control-feedback'></span>" ).insertAfter( element );
            }
        },
        success: function ( label, element ) {
            if ( !$( element ).next( "span" )[ 0 ] ) {
                $( "<span class='fa fa-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "border-danger" ).removeClass( "has-success" );
        },
        unhighlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "has-success" ).removeClass( "border-danger" );
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>
@endsection