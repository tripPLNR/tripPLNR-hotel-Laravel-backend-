@extends('layouts.admin.admin')
@section('content')


<div class="card info-card revenue-card">
    <div class="card-header d-flex justify-content-between">
        <span>Add Terms & Conditions</span>
        <a href="{{route('user.index')}}">
            <button type="button" class="btn btn-sm btn-warning""><i class="bi bi-plus"></i>Back</button>
        </a>
    </div>
    <div class="card-body">
        <div class="pt-4">
            <form id="FormId" action="{{route('term-condition.store')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="method" name="_method" value="">
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-12">
                            <label for="name">Title</label>
                            <input type="text" class="form-control mt-1" name="title" id="title" value="{{old('title')}}" placeholder="Enter title">
                        </div>
                        <div class="col-12">
                            <label for="name">Terms & Conditions</label>
                            <textarea  class="form-control mt-1" name="conditions" id="description" placeholder="Enter term-conditions ">{{old('description')}}</textarea>
                        </div>
                    
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('user.index')}}"> <button type="button" class="btn btn-danger btn-margin">Cancle</button></a>
                    <button type="submit" class="btn btn-primary btn-margin">Save</button>
                </div>
            </form>
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