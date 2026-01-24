<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\ResendRequest;
use App\Http\Requests\Auth\Verify;
use App\Services\AuthService;
use Illuminate\Auth\Events\Login;
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

    public function me()
    {
        $user = $this->authService->me(auth()->user()->id);
        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'User info',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->my_role,
            ]
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

        if (isset($user['token'])) {
            $token = $user['token'];
        }

        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json(['status' => true, 'message' => 'emailingiz tasdiqlandi', 'access_token' => $token, 'token_type' => 'Bearer',], 200);
    }

    public function resendCode(ResendRequest $request)
    {
        $user = $this->authService->resendCode($request);
        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json([
            'success' => true,
            'message' => "Tasdiqlash kodi emailingiza qayta yuborildi",
            'email' => $user->email,
            'code_expires_at' => $user->email_verification_code_expires_at
        ]);
    }

    public function login(Request $request)
    {
        $user = $this->authService->login($request);

        if (isset($user['token'])) {
            $token = $user['token'];
        }

        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json(['status' => true, 'message' => 'emailingiz tasdiqlandi', 'access_token' => $token, 'token_type' => 'Bearer',], 200);
    }

    public function logout(Request $request)
    {
        $user = $this->authService->logout($request);
        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json([
            'success' => true,
            'message' => "hisobdan muvofaqiyatli chiqildi"
        ]);

    }

    public function changePassword(Request $request)
    {
        $user = $this->authService->changePassword($request);
        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'parolingiz muvofaqiyatli yangilandi'
        ]);
    }

    public function forgetPassword(Request $request)
    {
        $user = $this->authService->forgetPassword($request);
        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'reset password sent',
            'code_expires_at' => $user->password_reset_code_expires_at
        ]);
    }

    public function resetPassword(Request $request)
    {
        $user = $this->authService->resetPassword($request);
        if (isset($user['error'])) {
            return response()->json(['success' => false, 'error' => $user['message']], 200);
        }
        return response()->json([
            'success' => true,
            'message' => "parol muvofaqiyatli yangilandi",
        ]);
    }

}
