<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    protected $model;
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return response()->json([
            'data'=> PostResource::collection($this->model->simplePaginate(5)),
            'message'=>'success',
            'status'=>200
        ]);
    }

    public function getPost($id)
    {
        $data = $this->model->findOrFail($id);
        if($data)
        {
            return response()->json([
                'data'=> new PostResource($data),
                'message'=>'success',
                'status'=>200
            ]);
        }else{
            return response()->json([
                'data'=>null,
                'message'=>'data not found',
                'status'=>404
            ],404);   
        }
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();

        try{
            $data['user_id'] = auth()->user()->id;
           $post = $this->model->create($data);
            return response()->json([
                'data'=> new CommentResource($post),
                'message'=>'success',
                'status'=>200
            ]);
        }catch(Exception $e)
        {
            return response()->json([
                'data'=>$e->getMessage(),
                'message'=>'error',
                'status'=>500
            ],500);   
        }
    }

    public function delete($id)
    {
        $data =  $this->model->findOrFail($id);
        if($data->user_id == auth()->user()->id)
        {
            $data->delete();
            return response()->json([
                'data'=>null,
                'message'=>'post deleted',
                'status'=>200
            ]);   
       
        }else{
            return response()->json([
                'data'=>null,
                'message'=>'error',
                'status'=>500
            ],500);   
            
        }
    }
   
    
}
