@extends('layouts.session')
@section('content')
<div class="content-wrapper">
    <div class="content-inner">
        <div class="content d-flex justify-content-center align-items-center">
            <form id="admin-login-form" class="login-form" action="{{ route('login') }}" method="post" autocomplete="off">
                @csrf
                <div class="card mb-0 login_box">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="{{asset('/')}}assets/img/logo.png" width="100"style="border-radius:10%"/>
                            <h5 class="mb-0 sp-des">Login</h5>
                        </div>
                        {{-- @include('success-error') --}}
                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                        </div>
                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        {{-- <p class="text-right"><a href="{{ route('forgot.password') }}">Forgot Password?</a></p> --}}
                        <div class="form-group mt-45">
                            <button type="submit" class="btn btn-primary btn-block session-btn">Sign in</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('page_script')
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#email").val("");
            $("#password").val("");
        }, 500)
        $("#admin-login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                },
            },
            message: {
                email: 'Email field is required',
                password: 'Password field is required',
            },
            errorElement: 'span',
            errorClass: 'error text-danger',
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if ($errors->any())
    @foreach ($errors->all() as $error)        
        <script>
            toastr.error('{{ $error }}');
        </script>
    @endforeach
@endif

@if (Session::has('success'))
<script>
    toastr.success("{{ Session::get('success') }}");
</script>
@endif
@if (Session::has('error'))
<script>
    toastr.error("{{ Session::get('error') }}");
</script>
@endif
<script>
    $(document).ready(() => {
        $("#photo").change(function () {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview").css("display", "block")
                    $("#imgPreview").attr("src", event.target.result);
                    
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@include('sweetalert::alert')
@endsection
@section('page_style')
<style>
</style>
@endsection