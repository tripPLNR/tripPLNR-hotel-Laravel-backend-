@extends('layouts.admin.admin')
@section('content')


<div class="card info-card revenue-card">
    <div class="card-header d-flex justify-content-between">
        <span>Edit Blog</span>
        <a href="{{route('blog.index')}}">
            <button type="button" class="btn btn-sm btn-warning""><i class="bi bi-plus"></i>Back</button>
        </a>
    </div>
    <div class="card-body">
        <div class="pt-4">
            <form id="editFrom" action="{{route('blog.update',$blog->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PATCH">
                <div class="modal-body">
                    <input type="hidden" value="{{$blog->img_path != '' ? 'true' : 'false'}}" name="fileStatus">
                    <div class="row form-group">
                        <div class="col-12 form-margin">
                            <label for="name">Title</label>
                            <input type="text" class="form-control mt-1" name="title" id="title" value="{{$blog->title}}" placeholder="Enter blog title">
                        </div>
                        <div class="col-12 form-margin">
                            <label for="name">Description</label>
                            <textarea  class="form-control mt-1" name="description" id="description" placeholder="Enter blog description">{{$blog->description??''}}</textarea>
                        </div>
                        <div class="col-12 form-margin">
                            <label for="name">Reading Time</label>
                            <input type="text" class="form-control mt-1 timepicker" name="reading_time" id="reading_time" value="{{$blog->reading_time}}"  autocomplete="off" >
                            
                        </div>
                        <div class="col-12 form-margin  preview">
                            <label for="name">Photo</label>
                            <input type="file" class="form-control mt-1" name="photo" id="photo" accept="image/png, image/gif, image/jpeg">
                            
                            <br>
                            
                            <img src="{{'../../uploads/blog_img/'.$blog->img_path}}" id="imgPreview" height="150" width="150" style="display:{{$blog->img_path != '' ? 'block' : 'none'}}">
                            <div class="closeDiv">X</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('blog.index')}}"> <button type="button" class="btn btn-danger btn-margin" data-bs-dismiss="modal">Close</button></a>
                    <button type="submit" class="btn btn-primary btn-margin">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(() => {
        $("#photo").change(function () {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview, .closeDiv").css("display", "block")
                    $("#imgPreview").attr("src", event.target.result);
                    $('input[name="fileStatus"]').val("true");
                };
                reader.readAsDataURL(file);
            }
        });

        $(document).on('click', '#imgPreview', function () {
            $('#photo').click();
        });

        $(document).on('click', '.closeDiv', function () {
            $("#imgPreview, .closeDiv").css("display", "none")
            $("#imgPreview").attr("src", '');
            $('#photo').val("");
            $('input[name="fileStatus"]').val("false");
        });

        $('form').submit(function () {

            // Get the Login Name value and trim it
            var name = $.trim($('input[name="fileStatus"]').val());

            // Check if empty of not
            if (name  === 'false') {
                toastr.error('The photo field is required.');
                return false;
            }
        });

 
       
        $( "#reading_time" ).wickedpicker({
            twentyFour: true,
            title:'Reading Time',
            now:"{{$blog->reading_time}}",
            showSeconds:true,

        });

     
    });

</script>

@endsection
