@extends('layouts.admin.admin')
@section('content')


<div class="card info-card revenue-card">
    <div class="card-header d-flex justify-content-between">
        <span>Change Password</span>

    </div>
    <div class="card-body">
        <div class="pt-4">
      
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" action="{{ route('save-password') }}">
                        @csrf
                        <input type="hidden" id="method" name="_method" value="">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Old Password</label>
                            <input type="password" name="old_password" value="{{old('old_password')}}" class="form-control" id="exampleFormControlInput1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">New Password</label>
                            <input type="password" name="password" value="{{old('password')}}" class="form-control" id="exampleFormControlInput1">
                        </div>
    
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control" id="exampleFormControlInput1">
                        </div>
                        <div class="modal-footer">
                            <a href="{{route('user.index')}}"> <button type="button" class="btn btn-danger btn-margin">Close</button></a>
                            <button type="submit" class="btn btn-primary btn-margin">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
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