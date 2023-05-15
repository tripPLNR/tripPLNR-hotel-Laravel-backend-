@extends('layouts.admin.admin')
@section('title')
    <title>Edit User</title>
@stop

@section('inlinecss')
    <link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
    <h1 class="page-title">Edit Customers</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Customer</a></li>
        <li class="breadcrumb-item active" aria-current="page">edit</li>
    </ol>
@stop

@section('content')
    <div class="app-content">
        <div class="side-app">
            <div class="col-lg-12">
                <div class="card">
                   
                    <div class="card-header d-flex justify-content-between">
                        <span>Customer Edit</span>
                        <a href="{{route('user.index')}}">
                            <button type="button" class="btn btn-sm btn-warning" "=""><i class="bi bi-plus"></i>Back</button>
                        </a>
                    </div>
                    
                    <div class="card-body">
                        <div class="pt-4">
                        <form id="submitForm" method="post" action="{{ route('user.update', $user->id) }}">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PATCH">
                            <div class="form-group form-margin">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="First Name.." value="{{ $user->first_name }}">
                            </div>
                            <div class="form-group form-margin">
                                <label class="form-label">Last Name *</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Last Name.." value="{{ $user->last_name }}">
                            </div>

                            <div class="form-group form-margin">
                                <label class="form-label">Email *</label>
                                <label class="form-control">{{ $user->email }}</label>
                                {{-- <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email.." value="{{ $user->email }}"> --}}
                            </div>

                            <div class="form-group form-margin">
                                <label class="form-label">Status</label>
                                <select name="is_block" id="status" class="form-control custom-select">
                                    <option @if ($user->is_block == 1) selected @endif value="1">Blocked</option>
                                    <option @if ($user->is_block == 0) selected @endif value="0">Active</option>
                                </select>
                            </div>

                            <div class="card-footer"></div>
                            <button type="submit" id="submitButton" class="btn btn-primary float-right"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..."
                                data-rest-text="Update">Update</button>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- COL END -->

        <!--  End Content -->

    </div>
    </div>

@stop
@section('inlinejs')
    <script src="{{ asset('admin/assets/multiselectbox/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#roles').multiSelect();
            $('#submitForm').submit(function() {
                var $this = $('#submitButton');
                buttonLoading('loading', $this);
                $('.is-invalid').removeClass('is-invalid state-invalid');
                $('.invalid-feedback').remove();
                $.ajax({
                    url: $('#submitForm').attr('action'),
                    type: "POST",
                    processData: false, // Important!
                    contentType: false,
                    cache: false,
                    data: new FormData($('#submitForm')[0]),
                    success: function(data) {
                        if (data.status) {

                            successMsg('Update User', data.msg);

                        } else {
                            $.each(data.errors, function(fieldName, field) {
                                $.each(field, function(index, msg) {
                                    $('#' + fieldName).addClass(
                                        'is-invalid state-invalid');
                                    errorDiv = $('#' + fieldName).parent('div');
                                    errorDiv.append(
                                        '<div class="invalid-feedback">' +
                                        msg + '</div>');
                                });
                            });
                            errorMsg('Update User', 'Input error');
                        }
                        buttonLoading('reset', $this);

                    },
                    error: function() {
                        errorMsg('Update User',
                            'There has been an error, please alert us immediately');
                        buttonLoading('reset', $this);
                    }

                });

                return false;
            });

        });

        $("#profile_image").change(function() {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profile_image_select').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        function getPassword() {
            pass = Math.random().toString(36).slice(-8);
            $('#password').val(pass);
        }
    </script>
@stop
