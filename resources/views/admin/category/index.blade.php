@extends('layouts.admin.admin')
@section('content')


<div class="card info-card revenue-card">
    <div class="card-header d-flex justify-content-between">
        <span>Category List</span>

        <button type="button" class="btn btn-sm btn-warning  category_add" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Add New</button>
    </div>
    <div class="card-body">
        <div class="pt-4">
            <form action="{{route('category.index')}}">
                <div class="row justify-content-end">
                    <div class="col-sm-12 col-lg-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Search</span>
                            <input type="search" class="form-control" name="search" id="search" placeholder="Search category" aria-label="Search category" aria-describedby="basic-addon2" value=" {{$data['search'] ?? ''}}">
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
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $key=>$category)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$category->name}}</td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary btn-sm categoryEdit" geturl="{{route('category.edit',$category->id)}}" posturl="{{route('category.update',$category->id)}}"><i class="fas fa-pencil-alt"></i></a>
                            <a href="{{ route('category.delete', [$category['id']]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            <a href="{{ route('sub-category.index', ['cid' =>$category['id']]) }}" class="btn btn-primary btn-sm" title="Sub-categories"><i class="icon-database-menu"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modelheading">Add Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FormId" action="{{route('category.store')}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="method" name="_method" value="">
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-12">
                            <label for="name">Name</label>
                            <input type="text" class="form-control mt-1" name="name" id="name" placeholder="Enter category name">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-footer">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.category_add').click(function() {
            var url_post = "{{route('category.store')}}";
            $('#FormId').attr('action', url_post);
            $('#method').val('');
            $('#modelheading').html('Add category');
            document.getElementById("FormId").reset();
        });
        $('.categoryEdit').click(function() {
            $('#modelheading').html('Edit category');
            var url_get = $(this).attr('geturl');
            var url_post = $(this).attr('posturl');
            $('#method').val('PUT');
            $('#FormId').attr('action', url_post);
            $.ajax({
                type: "get",
                url: url_get,
                data: "",
                success: function(data) {
                    var JSONObject = JSON.parse(data);
                    $('#name').val(JSONObject["name"]);
                }
            });
        });

    });
</script>
@endsection