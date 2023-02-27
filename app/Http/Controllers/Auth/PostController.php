<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\ImageRenderer;
use Spatie\ImageOptimizer\Optimizer;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Spatie\LaravelImageOptimizer\Middlewares\OptimizeImages;

class PostController extends Controller
{
    /**

     * Display a listing of the resource.
     *
     * @return PostResource|\Illuminate\Database\Eloquent\Builder
     */
    public function index(Request $request)
    {
            return new PostResource(Cache::remember('Posts', 60*60, function (){
             return Post::with('users')->where('is_published','=','1')->paginate(10);

            }));



    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        $auth = auth()->id();
        $file=$request->file('img');
        ImageOptimizer::optimize($file);
        $path=$file->hashName('http://arion2ro.beget.tech/storage/app/public/uploads');

      $img= \Intervention\Image\Facades\Image::make($file->getRealPath())
           ->fit(400)->save($file->getRealPath());
        $file->store('uploads','public');

        $post= new Post();
        $post->title= \request('title');
        $post->content= \request('content');
        $post->Users_id= $auth;
        $post->img= $path ;


       Cache::pull($post->save());
    }

    /**
     * Display the specified resource.
     * @param string $search
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $search)
    {
        $recordsTable=Post::with('users')->where('title', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%')->get();


        if($recordsTable->toArray()==null){
            return response()->json(['data' => 'not found']);
        }
        else{


            return new PostResource(Post::with('users')->where('title', 'like', '%' . $search . '%' )
                ->orWhere('content', 'like', '%' . $search . '%')->get());
        }






    }



    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return Response
     */
    public function update(Request $request, Post $post,$id)
    {
        $data=[
            'title'=> \request('title'),
        'content'=> \request('content'),
       'Users_id'=> \request('Users_id'),
        'img' => $request->file('img')->
        store('http://arion2ro.beget.tech/storage/app/public/uploads','public'),
        'is_published'=> \request('is_published')
        ];

            new PostResource(Post::with('users')->find($id)->update($data));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return Response
     */
    public function destroy(Post $post,$id)
    {
       new PostResource(Post::with('users')->find($id)->delete());
    }
    /**@param int $id
     */
    public function execute($id){
        Post::with('users')->find($id)->forceDelete();
    }
}
