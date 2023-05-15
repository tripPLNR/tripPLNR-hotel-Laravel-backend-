@extends('layouts.admin.admin')
@section('content')

<div class="card info-card revenue-card">
    <div class="card-header d-flex justify-content-between">
        <span>Sub-Category</span>

        <button type="button" class="btn btn-sm btn-warning  category_add" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Add New</button>
    </div>
    <div class="card-body">
        <div class="pt-4">
            <div class="row justify-content-end">
                <div class="col-sm-12 col-lg-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text bi bi-search" id="basic-addon2"></span>
                        <input type="text" class="form-control" wire:model="search" placeholder="Search sub Category" aria-label="Search sub Category" aria-describedby="basic-addon2">
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($subcategories))
                    @foreach($subcategories as $key=>$subcategory)
                    <tr>
                        
                        <td>{{$key+1}}</td>
                        <td>{{$subcategory->category->name}}</td>
                        <td>{{$subcategory->title}}</td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary btn-sm categoryEdit" geturl="{{route('sub-category.edit',$subcategory->id)}}" posturl="{{route('sub-category.update',$subcategory->id)}}">Edit</a>
                            <a href="{{ route('sub-category.delete', [$subcategory['id']]) }}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
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
            <form id="FormId" action="{{route('sub-category.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

                <input type="hidden" id="method" name="_method" value="">
                <div class="modal-body">

                    <div class="row form-group">
                        <div class="col-12">
                        <label for="name">Category</label>
                            <select class="form-select" aria-label="Default select example" id="category_id" name="category_id">
                                <option selected>---select Category---</option>
                                @foreach($categories as $key=>$category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="row form-group pt-2">
                        <div class="col-12">
                            <label for="name">Name</label>
                            <input type="text" class="form-control mt-1" name="title" id="title" placeholder="Enter Sub-category name">

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



<!-- <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
</div> -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.category_add').click(function() {
            var url_post = "{{route('sub-category.store')}}";
            $('#FormId').attr('action', url_post);
            $('#method').val('');
            $('#modelheading').html('Add sub-category');
            document.getElementById("FormId").reset();
        });
        $('.categoryEdit').click(function() {
            $('#modelheading').html('Edit sub-category');
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