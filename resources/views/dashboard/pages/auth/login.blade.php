@extends('dashboard.layouts.auth')
@section('title', '| Login')
@section('page-css-link') @endsection
@section('page-css')
<style type="text/css">
    .error{
        font-size: medium !important;
    }
</style>
@endsection
@section('main-content')
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login to Dashboard </h1>
                            </div>
                            <form  class="user" id="login-form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    {{ Form::text('email', old('email') , array('class' =>'form-control form-control-user', 'placeholder'=>'Enter email here...')) }}
                                    @if ($errors->has('email'))
                                        <span class="text-danger"> {{$errors->first('email')}} </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::password('password', array('class' =>'form-control form-control-user','placeholder'=>'Enter password here...')) }}
                                    @if ($errors->has('password'))
                                        <span class="text-danger"> {{$errors->first('password')}} </span>
                                    @endif
                                </div>
                            
                                <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{route('register')}}">Create an Account!</a>
                            </div>
                        </div>
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
    $( "#login-form" ).validate( {
        rules: {
            email: {
                required: true,
                email_regex: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8
            },
        },
        messages: {
            email:{
                required: "Please enter the email address."
            },
            password: {
                required: "Please provide a user password.",
                minlength: "Your password must be at least 8 characters long."
            },
        },
        errorElement: "span",
        errorPlacement: function ( error, element ) {
            error.addClass( "text-danger" );
            element.addClass( "has-feedback" );
            if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            }
            else {
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