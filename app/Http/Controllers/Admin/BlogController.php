<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

use Illuminate\Support\Str;
use DB;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *´
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        try{
            $page_title = 'Blogs';
            $q = Blog::orderBy('id', 'DESC');
            if($request->has('search') && $request->search != ''){
                $q->where('title','ilike',$request->search.'%');
            }
            $blogs = $q->paginate(env('PER_PAGE'));
            return view('admin.blog.index',compact('blogs','page_title') );
        }catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Blog Create';
        return view('admin.blog.add',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {

        try{
            $fileName = '';
            if($request->hasFile('photo')){  
        
                $fileName = time().'.'.$request->photo->extension();
                $request->photo->move(public_path('uploads/blog_img'), $fileName);
            }
            $blogObj = new Blog();
            $blogObj->title = $request->title ?? '';
            $blogObj->slug = $this->generateSlug($request->title);
            $blogObj->description = $request->description ?? '';
            $blogObj->created_by = Auth::user()->id ?? 1;
            $blogObj->reading_time = str_replace(' ', '', $request->reading_time ?? '');
            $blogObj->img_path = $fileName;
            if($blogObj->save()){
                return redirect(route('blog.index'))->with('success','New blog saved successfully');
            }
        }
        catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
       
    }


    public function generateSlug($name)
    { 
        if (Blog::whereSlug($slug = Str::slug($name))->exists()) {
            
            return "{$slug}-".strtotime(date('Y-m-d H:i:s'));
        }
        return $slug;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = 'Blog Edit';
        try{
            $blog = Blog::find(base64_decode($id));
            if(!$blog){
                return back()->with('error','Blog not found');
            }
            return view('admin.blog.show',compact('blog','page_title'));
        }
        catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Blog Edit';
        try{
            $blog = Blog::find(base64_decode($id));
            if(!$blog){
                return back()->with('error','Blog not found');
            }
            return view('admin.blog.edit',compact('blog','page_title'));
        }
        catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
        
    }

    public function shareBlog($slug){
        $page_title = 'Blog Detail';
        try{
            $blog = Blog::where('slug',$slug)->first();
            if(!$blog){
                return redirect()->route('user.index')->with('error','Blog not found');
            }
            
            return view('admin.blog.share-blog',compact('blog','page_title'));
        }
        catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    public function blogDescription($id){
        $page_title = 'Blog Detail';
        try{
            $blog = Blog::where('id',$id)->first();
            // if(!$blog){
            //     return redirect()->route('user.index')->with('error','Blog not found');
            // }
            
            return view('admin.blog.blog-description',compact('blog','page_title'));
        }
        catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request, $id)
    {
        try{
            $blogObj = Blog::find($id);
            if(!$blogObj){
                return back()->with('error','Blog not found');
            }
            
            $fileName = '';
            if($request->hasFile('photo')){  
                if($blogObj->img_path !=''){
                    unlink(public_path('uploads/blog_img/').$blogObj->img_path);
                }
                $fileName = time().'.'.$request->photo->extension();
                $request->photo->move(public_path('uploads/blog_img'), $fileName);
                $blogObj->img_path = $fileName;
            }
            // $blogObj = new Blog();
            $blogObj->title = $request->title ?? '';
            $blogObj->description = $request->description ?? '';
            $blogObj->reading_time = str_replace(' ', '', $request->reading_time ?? '');
            $blogObj->created_by = Auth::user()->id ?? 1;
            
            if($blogObj->save()){
                return redirect(route('blog.index'))    ->with('success','Blog updated successfully');
            }
        }
        catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $blogObj = Blog::find($id);
            if(!$blogObj){
                return back()->with('error','Blog not found');
            }
            if($blogObj->delete()){
                return redirect(route('blog.index'))->with('success','Blog deleted successfully'); 
            }else{
                return redirect(route('blog.index'))->with('error','Blog deleted unsuccessful'); 
            }
        }
        catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }
}
