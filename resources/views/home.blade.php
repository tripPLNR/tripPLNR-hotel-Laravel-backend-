@extends('layouts.admin.admin')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <!-- Users Card -->
            <div class="col-sm-6 col-md-4 col-xl-3 col-lg-3">
                <div class="card info-card sales-card">
                    <div class="card-body pt-4">
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $userCount ?? 0}}</h6>
                                <span class="text-muted small pt-2 ps-1">Total Users</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Companies Card -->
            <div class="col-sm-6 col-md-4 col-xl-3 col-lg-3">
                <div class="card info-card revenue-card">
                    <div class="card-body pt-4">
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>244</h6>
                                <span class="text-muted small pt-2 ps-1">Total Companies</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category Card -->
            <div class="col-sm-6 col-md-4 col-xl-3 col-lg-3">
                <div class="card info-card customers-card">
                    <div class="card-body pt-4">
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-diagram-3-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>50</h6>
                                <span class="text-muted small pt-2 ps-1">Total Category</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Skills Card -->
            <div class="col-sm-6 col-md-4 col-xl-3 col-lg-3">
                <div class="card info-card sales-card">
                    <div class="card-body pt-4">
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-sunglasses"></i>
                            </div>
                            <div class="ps-3">
                                <h6>144</h6>
                                <span class="text-muted small pt-2 ps-1">Total Skills</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Technology Card -->
            <div class="col-sm-6 col-md-4 col-xl-3 col-lg-3">
                <div class="card info-card revenue-card">
                    <div class="card-body pt-4">
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-pentagon-half"></i>
                            </div>
                            <div class="ps-3">
                                <h6>124</h6>
                                <span class="text-muted small pt-2 ps-1">Technology</span>
                            </div>
                        </div>
                    </div>
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