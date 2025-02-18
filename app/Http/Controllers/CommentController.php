<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    protected $model;
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }


    public function getComment($id)
    {
        $data = Post::findOrFail($id);
        if($data)
        {
            return response()->json([
                'data'=> CommentResource::collection($data->comments),
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

    public function store(CommentRequest $request,$id)
    {
        $data = $request->validated();

        try{
            $data['user_id'] = auth()->user()->id;
            $data['post_id'] = $id;
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
                'message'=>'comment deleted',
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
