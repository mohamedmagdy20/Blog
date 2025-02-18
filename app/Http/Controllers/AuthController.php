<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    protected $model;
    
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        try{
            $data['password'] = Hash::make($data['password']);
            $user = $this->model->create($data);

            if($user)
            {
                return response()->json([
                    'data'=>null,
                    'message'=>'User Registerd Successfully',
                    'status'=>200
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'data'=>null,
                'message'=>$e->getMessage(),
                'status'=>500
            ],500);
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if($token = JWTAuth::attempt($data))
        {
            $user = auth()->user();
            $user['token'] = $token;
            return response()->json([
                'data'=> new UserResource($user),
                'message'=>'login success',
                'status'=>200
            ]);
        }else{
            return response()->json([
                'data'=> null,
                'message'=>'invaild Email or Password',
                'status'=>401
            ],401);
        }
    }


    public function logout(Request $request)
    {
       Auth::logout();
        return response()->json([
            'data'=> null,
            'message'=>'success logout',
            'status'=>200
        ]);
    }
}
