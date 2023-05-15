<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | {{ $page_title ?? '' }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Favicons -->
    <link href="{{ asset('/') }}assets/img/favicon.png" rel="icon">
    <link href="{{ asset('/') }}assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" /> 

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>



    <script src="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.css" rel="stylesheet">    
    
    <!-- Template Main CSS File -->
    <link href="{{ asset('/') }}assets/css/style.css" rel="stylesheet">
    @yield('styles')
<style>
    .tox-notification .tox-notification--in .tox-notification--warning {
        display: none !important;
    }
    .tox-notification__body{
        display: none !important;
    }
</style>
</head>

<body>
    <main id="main" class="main">
        @include('layouts.admin.header')
        @include('layouts.admin.sidebar')
        <section class="section dashboard">
            @yield('content')
        </section>

    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  

   
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.js"></script>

    @yield('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    
    <script>
        tinymce.init({
          selector: '#description',
          statusbar: false,
          menubar: false,
          branding: false,
          toolbar: "undo redo | styleselect | fontfamily | fontsize | bold italic | alignleft aligncenter alignright alignjustify | outdent indent",
          font_size_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 30pt 32pt 34pt 36pt",
          content_style:"@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&family=Roboto+Regular:wght@400&family=Merriweather:wght@300&family=Merriweather+Regular:wght@400&family=Open+Sans&family=Open+Sans+SemiBold:wght@600&display=swap');body { font-family: 'Roboto', sans-serif; }",
          font_family_formats:"Roboto Light=Roboto, sans-serif; Roboto Regular=Roboto Regular, sans-serif; Merriweather Light=Merriweather, serif; Merriweather Regular=Merriweather Regular, serif; Open Sans=Open Sans, sans-serif; Open Sans SemiBold=Open Sans SemiBold, sans-serif;",
          
        });
      </script>

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
        $(document).ready(function() {
            var typingTimer;                //timer identifier
            var doneTypingInterval = 800;  //time in ms, 5 seconds for example
            var $input = $('#search');
            if($input.length > 0){
                var strLength = $input.val().length * 2;
                
                $input.focus();
                $input[0].setSelectionRange(strLength, strLength);
                
                //on keyup, start the countdown
                $input.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
                });

                //on keydown, clear the countdown 
                $input.on('keydown', function () {
                clearTimeout(typingTimer);
                });

                //user is "finished typing," do something
                function doneTyping () {
                    $('#searchForm').submit();
                }
                
                $("#search").on("search", function(evt){
                    if($(this).val().length == 0){
                        $('#searchForm').submit();
                    }
                });
            }
        });
    </script>
</body>

</html>
