<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserUpdateRequest;
use Carbon\Carbon;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            
            $page_title = 'Users';
            $q = User::where('user_type','user');

            if($request->has('search') && $request->search != ''){
                $q->whereRaw("concat(first_name, ' ', last_name) ilike '%".$request->search."%' ");

            }
            $users = $q->orderBy('id','desc')->paginate(env('PER_PAGE'));

            return view('admin.user.index',compact('users','page_title'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = 'User Detail';
        $data = User::find($id);
        return view('admin.user.detail',compact('data','page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'User edit';
        $user = User::find($id);
        return view('admin.user.users-edit',compact('user','page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        
        try{
            $userObj = User::find($id);
            if(!$userObj){
                return back()->with('error','User not found');
            }
            $userObj->first_name    = $request->first_name ?? '';
            $userObj->last_name     = $request->last_name ?? '';
            $userObj->is_block      = $request->is_block ?? '';
            if($userObj->save()){
                return redirect(route('user.index'))    ->with('success','User updated successfully');
            }
        }catch(\Exception $e){
            return back()->withErrors('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
}
