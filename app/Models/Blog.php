<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Blog extends Model
{
    use HasFactory;
    protected $appends = ['image_path','is_favorite','text_descriptions','is_like','like_count','share_count','blog_description_page'];

    // Function for get user details.
    public function User()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    //function for get image url
    public function getImagePathAttribute(){
        if ($this->img_path != ''){
            return asset('/uploads/blog_img/' . $this->img_path);
        }
        return asset('admin/images/login.jpg');
    }

    // Function for checking is favorite by user?
    public function getIsFavoriteAttribute(){
        $userId = request()->user('api')->id ?? '';
        if(!$userId){
            return 0;
        }
        $isFavorite = Favorite::where('blog_id',$this->id)->where('user_id',$userId)->count();
        return $isFavorite ? 1 : 0;
    }

    // Function for checking is like by user?
    public function getIsLikeAttribute(){
        $userId = request()->user('api')->id ?? '';
        if(!$userId){
            return 0;
        }
        $isLike = Like::where('product_id',$this->id)->where('user_id',$userId)->where('product_type','Blog')->count();
        return $isLike ? 1 : 0;
    }

     // Function for return blog description?
     public function getBlogDescriptionPageAttribute(){
        return route('blog.description',($this->id ?? ''));
    }

    // Function for get total like count
    public function getLikeCountAttribute(){
        $likeCount = Like::where('product_id',$this->id)->where('product_type','Blog')->count();
        return $likeCount ?? 0;
    }
    
    // Function for get total share count
    public function getShareCountAttribute(){
        $shareCountObj = ShareCount::where('product_id',$this->id)->where('product_type','Blog')->first();
        return $shareCountObj->share_count ?? 0;
    }

    // Function for get short description
    public function getDescriptionsAttribute(){
        if($this->description != '' && $this->description != null){
            if(strlen($this->description) > 30){
                return (substr(strip_tags($this->description),0,30).'...');
            }else{
                return strip_tags($this->description);
            }
        }
        return ''; 
    }

    // Function for get short description
    public function getBolgTitlesAttribute(){
        if($this->title != '' && $this->title != null){
            if(strlen($this->title) > 30){
                return (substr(strip_tags($this->title),0,30).'...');
            }else{
                return strip_tags($this->title);
            }
        }
        return ''; 
    }

    // Function for get description without HTML
    public function getTextDescriptionsAttribute(){
        if($this->description != '' && $this->description != null){
            return str_replace("\r\n"," ",strip_tags($this->description));
        }
        return ''; 
    }
}
