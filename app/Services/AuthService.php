<?php

namespace App\Services;

use App\Repositories\Interface\AuthRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function __construct(protected AuthRepositoryInterface $authRepository)
    {
    }

    public function all()
    {
        try {
            return $this->authRepository->all();
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function findByEmail($email)
    {
        try {
            return $this->authRepository->findByEmail($email);
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function me(int $id)
    {
        try {
            return $this->authRepository->findById($id);
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function register($request)
    {
        try {
            $data = ['name' => $request->name,'email' => $request->email, 'password' => $request->password];
            $user = $this->authRepository->register($data);
            $code = $user->generateEmailVerificationCode();

            Mail::send('Mail.verify', ['code' => $code, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email)->subject('Your verification code');
            });

            return $user;
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function verify($request)
    {
        try {
            $user = $this->findByEmail($request->email);

            if (!$user){
                return [
                    'error' => true,
                    'message' => 'Email not found'
                ];
            }

            if($user->hasVerifiedEmail()){
                return [
                    'error' => true,
                    'message' => 'Email already verified'
                ];
            }

            if (!$user->isValidVerificationCode($request->code)){
                return [
                    'error' => true,
                    'message' => 'Invalid code'
                ];
            }

            $token = $this->authRepository->verify($user);

            return ['token' => $token];
        }catch (\Exception $exception){
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }


}
