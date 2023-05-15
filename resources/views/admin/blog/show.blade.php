@extends('layouts.admin.admin')
@section('content')


<div class="card info-card revenue-card">
    <div class="card-header d-flex justify-content-between">
        <span>Blog Deatil</span>
        <a href="{{route('blog.index')}}">
            <button type="button" class="btn btn-sm btn-warning""><i class="bi bi-plus"></i>Back</button>
        </a>
    </div>
    <div class="card-body">
        <div class="pt-4">
           
                
                <div class="modal-body">
                    
                    <div class="row form-group">
                        <div class="col-lg-6 col-md-6 form-margin">
                            <label for="name"><h2 style="font-weight:bold;">{{$blog->title}}</h2></label>
                        </div>
                        <div class="col-lg-6 col-md-6 form-margin read-time">
                            <label for="name">Reading Time: {{$blog->reading_time}}</label>
                        </div>
                        <div class="col-12 form-margin ">
                            <div class="banner-img">
                                <img src="{{'../../uploads/blog_img/'.$blog->img_path}}" id="imgPreview">
                            </div>
                           
                        </div>
                        <div class="col-12 form-margin">
                            <label for="name">{!!$blog->description??''!!}</label>
                        </div>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('blog.index')}}"> <button type="button" class="btn btn-danger btn-margin" data-bs-dismiss="modal">Back</button></a>
                </div>
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
