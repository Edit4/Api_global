<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


            return User::with('Post')->get();



    }


    /**
     * Display the specified resource.
     * @param string $search
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(string $search )
    {
        $recordsTable=User::with('Post')->where('name', 'like', '%' . $search . '%')->
        orWhere('email', 'like', '%' . $search . '%')->get();


        if($recordsTable->toArray()==null){
            return response()->json(['data' => 'not found']);
        }
        else{


            return new UserResource(User::with('Post')->where('name', 'like', '%' . $search . '%')->
            orWhere('email', 'like', '%' . $search . '%')->get());
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, int $id)
    {
        $user=User::with('Post')->find($id);
        request('email') != null ? $user->email=request('email'): $user->email ;
        request('name') != null ? $user->name=request('name'): $user->name ;
        request('password') != null ? $user->password=Hash::make(request('password')): $user->password;
        $user->update();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,$id)
    {
        new UserResource(User::with('Post')->find($id)->delete());
        new PostResource(Post::with('users')->where('Users_id','=',"$id")->delete());

    }
}
