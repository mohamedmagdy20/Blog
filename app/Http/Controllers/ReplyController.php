<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Comment;
use App\Models\Replie;
use Exception;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    //
    protected $model;
    public function __construct(Replie $model)
    {
        $this->model = $model;
    }


    public function getAllReply($id)
    {
        $data = Comment::findOrFail($id);
        if($data)
        {
            return response()->json([
                'data'=> ReplyResource::collection($data->replies),
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

    public function store(ReplyRequest $request,$id)
    {
        $data = $request->validated();

        try{
            $data['user_id'] = auth()->user()->id;
            $data['comment_id'] = $id;
           $post = $this->model->create($data);
            return response()->json([
                'data'=> new ReplyResource($post),
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
                'message'=>'reply deleted',
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
