<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\AuthLoginPostRequest;
use App\Http\Requests\AuthRegisterPostRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function register(AuthRegisterPostRequest $request): JsonResponse
    {
        try {
            $userEntity = $this->userRepository->store([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $this->userRepository->createToken($userEntity)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function login(AuthLoginPostRequest $request): JsonResponse
    {
        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $userEntity = $this->userRepository->findByEmail($request->email);

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $this->userRepository->createToken($userEntity)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Tokens Revoked'], 200);
    }
}
