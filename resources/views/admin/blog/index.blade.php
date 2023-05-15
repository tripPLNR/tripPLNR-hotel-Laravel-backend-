@extends('layouts.admin.admin')
@section('content')


<div class="card info-card revenue-card">
    <div class="card-header d-flex justify-content-between">
        <span>Blog List</span>
        <a href="{{route('blog.create')}}">
            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Add New</button>
        </a>
    </div>
    <div class="card-body">
        <div class="pt-4">
            <form id="searchForm" action="" method="get">
                <div class="row justify-content-end">
                    <div class="col-sm-12 col-lg-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Search</span>
                            <input type="search" class="form-control" name="search" id="search" placeholder="Search blog" value="{{ app('request')->input('search') }}" aria-label="Search education" aria-describedby="basic-addon2" >
                            <button type="submit" id="search-btn-my" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <div class="form-control-feedback">
                                <i class="icon-search4 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                
        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Descriptions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($blogs && $blogs->count() ))
                    @foreach($blogs as $key=>$blog)
                    <tr>
                        <td>{{$blogs->firstItem() + $key}}</td>
                        <td title="{{$blog->title ?? 'Title'}}">{{$blog->bolg_titles ?? '--'}}</td>
                        <td>{{$blog->Descriptions ?? '--'}}</td>
                        <td>
                            {{-- <a href="{{ route('blog.show',base64_encode($blog->id)) }}" class="btn btn-success btn-sm"><i class="fa-solid fa-eye"></i></a> --}}
                            <a href="{{ route('blog.edit',base64_encode($blog->id)) }}"  class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            <a href="#" class="btn btn-danger btn-sm btn-trash" data-target="{{ route('blog.destroy', [$blog->id]) }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10">There are no data.</td>
                    </tr>

                    @endif
                </tbody>
            </table>
            {{ $blogs->links()}}

        </div>
    </div>
</div>






<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">blog</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-footer">
                <form id= "formTrash" action="" method="POST">
                    @csrf
                    <input name="_method" type="hidden" value="delete">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('sweetalert::alert')
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.btn-trash').click(function(e) {
            var url_post = $(this).data('target');
            console.log('url_post',url_post);
            $('#formTrash').attr('action', url_post);
            $('#method').val('post');
            // $('#modelheading').html('Add Blog');
            // document.getElementById("FormId").reset();
        });

    //     $('.education_add').click(function() {
    //         var url_post = "{{route('blog.store')}}";
    //         $('#FormId').attr('action', url_post);
    //         $('#method').val('post');
    //         $('#modelheading').html('Add Blog');
    //         document.getElementById("FormId").reset();
    //     });

    //     $('.educationEdit').click(function() {
    //         $('#modelheading').html('Edit Blog');
    //         var url_get = $(this).attr('geturl');
    //         var url_post = $(this).attr('posturl');
    //         $('#method').val('PUT');
    //         $('#FormId').attr('action', url_post);
    //         $.ajax({
    //             type: "get",
    //             url: url_get,
    //             data: "",
    //             success: function(data) {
    //                 var JSONObject = JSON.parse(data);
    //                 console.log('JSONObject',JSONObject);
    //                 $('#title').val(JSONObject["title"]);
    //             }
    //         });
    //     });

    });
</script>
@endsection