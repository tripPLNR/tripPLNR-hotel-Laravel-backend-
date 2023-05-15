<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Laravel') }} | {{ $page_title ?? '' }}</title>
    {{-- <link rel="stylesheet" href="style.css"> --}}
    <link href="{{ asset('/') }}assets/css/style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet"> --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&family=Roboto+Regular:wght@400&family=Merriweather:wght@300&family=Merriweather+Regular:wght@400&family=Open+Sans&family=Open+Sans+SemiBold:wght@600&display=swap" rel="stylesheet">
<style>
.blog-content p img {
    width: 100% !important;
    
}
.blog-content div div p img{
    width: 100% !important;
   
}
.blog-content div h1 img{
    width: 100% !important;
   
}
.blog-content div h2 img{
    width: 100% !important;
   
}
.blog-content div h3 img{
    width: 100% !important;
   
}
.blog-content div h4 img{
    width: 100% !important;
   
}
.blog-content div h5 img{
    width: 100% !important;
   
}

.blog-content p img {
    width: 100% !important;
    height: 100%;
}
</style>

</head>


<body>
    <div class="blog-section">
        <div class="container">
            <div class="row" style=" border-bottom: 1px solid #eceef4; padding-bottom:10px;">
                <div class="left-content">
                    <h3>Blog Detail</h3>
                </div>
                {{-- <a href="{{route('blog.index')}}"><button class="back-btn">Back</button></a> --}}
            </div>
        </div>
        
    </div>
    <section class="banner-section">
        <div class="container">
            <div class="row">
                <div class="content">
                    <h2>{{$blog->title}}</h2>
                    <p>Reading Time: {{$blog->reading_time}}</p>
                </div>
                <div class="banner-img">
                    <img src="{{'/../../uploads/blog_img/'.$blog->img_path}}">
                </div>
                <div class="blog-content">
                    {!!$blog->description??''!!}
                </div>

            </div>
            {{-- <div class="bottom-btn">
                <a href="{{route('blog.index')}}"><button class="back-btn bottom">Back</button></a>
            </div> --}}
             
        </div>
    </section>

</body>

</html>