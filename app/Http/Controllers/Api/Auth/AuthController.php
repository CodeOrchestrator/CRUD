<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\Verify;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function all()
    {
        $user = $this->authService->all();

        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    public function register(Register $request)
    {
        $user = $this->authService->register($request);
        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }

        return response()->json([
            'success' => true,
            'message' => "muvofaqiyatli ro'yxatdan o'tdingiz.Tasdiqlash kodi emailingiza yuborildi",
            'email' => $user->email,
            'code_expires_at' => $user->email_verification_code_expires_at
        ]);
    }

    public function verify(Verify $request)
    {
        $user = $this->authService->verify($request);

        $token = $user['token'];
        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json(['status' => true, 'message' => 'emailingiz tasdiqlandi', 'access_token' => $token, 'token_type' => 'Bearer',],200);
    }

}
