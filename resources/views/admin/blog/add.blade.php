@extends('layouts.admin.admin')
@section('content')
<div class="card info-card revenue-card">
    <div class="card-header d-flex justify-content-between">
        <span>Add Blog</span>
        <a href="{{route('blog.index')}}">
            <button type="button" class="btn btn-sm btn-warning""><i class="bi bi-plus"></i>Back</button>
        </a>
    </div>
    <div class="card-body">
        <div class="pt-4">
            <form id="FormId" action="{{route('blog.store')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="method" name="_method" value="">
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-12 form-margin">
                            <label for="name">Title</label>
                            <input type="text" class="form-control mt-1" name="title" id="title" value="{{old('title')}}" placeholder="Enter blog title">
                        </div>
                        <div class="col-12 form-margin">
                            <label for="name">Description</label>
                            <textarea  class="form-control mt-1" name="description" id="description" placeholder="Enter blog description">{{old('description')}}</textarea>
                        </div>
                        <div class="col-12 form-margin">
                            <label for="name">Reading Time</label>
                            <input type="text" class="form-control mt-1 timepicker" name="reading_time" id="reading_time" value="{{old('reading_time') ?? '00:00:00'}}" placeholder="hh:mm:ss" autocomplete="off">
                        </div>
                        <div class="col-12 form-margin">
                            <label for="name">Photo</label>
                            <input type="file" class="form-control mt-1" name="photo" id="photo" accept="image/png, image/gif, image/jpeg">
                        </div>
                        <br> <br>
                        <div class="col-12  form-margin preview" id="imgPreviewDiv" style="display:none">
                        <img src="" id="imgPreview" height="150" width="150" >
                        <div class="closeDiv">X</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('blog.index')}}"> <button type="button" class="btn btn-danger btn-margin">Close</button></a>
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
            console.log('file-',file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                  
                    $("#imgPreviewDiv").css("display", "block")
                    $("#imgPreview").attr("src", event.target.result);
                   
                };
                reader.readAsDataURL(file);
            }
        });
  
        $(document).on('click', '#imgPreview', function () {
            $('#photo').click();
        });
        
        $(document).on('click', '.closeDiv', function () {
            $("#imgPreviewDiv").css("display", "none")
            $("#imgPreview").attr("src", '');
            $('#photo').val("");
            
        });


    $( "#reading_time" ).wickedpicker({
        twentyFour: true,
        title:'Reading Time',
        now:"00:00:00",
        showSeconds: true,

    });
  });

  

</script>

@endsection

