@extends('layouts.session')

@section('content')
<div class="content-wrapper">
    <div class="content-inner">
        <div class="content d-flex justify-content-center align-items-center">

            <form class="login-form" method="POST" action="{{ route('pwd.reset',$token) }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <div class="card mb-0 login_box">
                    <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="{{asset('/')}}assets/img/logo.png" width="100"style="border-radius:10%"/>
                                <h5 class="mb-0 sp-des">Login</h5>
                            </div>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                
                            </div>

                            <div class="form-group mt-45">
                                    <button type="submit" class="btn btn-primary btn-block session-btn">
                                        {{ __('Reset Password') }}
                                    </button>
                            </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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
@include('sweetalert::alert')
@endsection
