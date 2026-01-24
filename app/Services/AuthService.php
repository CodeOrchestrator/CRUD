<?php

namespace App\Services;

use App\Repositories\Interface\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
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
            $data = ['name' => $request->name, 'email' => $request->email, 'password' => $request->password];
            $user = $this->authRepository->register($data);

            $user->assignRole('User');

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

            if (!$user) {
                return [
                    'error' => true,
                    'message' => 'Email not found'
                ];
            }

            if ($user->hasVerifiedEmail()) {
                return [
                    'error' => true,
                    'message' => 'Email already verified'
                ];
            }

            if (!$user->isValidVerificationCode($request->code)) {
                return [
                    'error' => true,
                    'message' => 'Invalid code'
                ];
            }

            $token = $this->authRepository->verify($user);

            return ['token' => $token];
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function resendCode($request)
    {
        try {
            $user = $this->findByEmail($request->email);
            if (!$user) {
                return [
                    'error' => true,
                    'message' => 'user not found'
                ];
            }

            if ($user->hasVerifiedEmail()) {
                return [
                    'error' => true,
                    'message' => 'Email already verified'
                ];
            }
            $code = $this->authRepository->resendPassword($user);

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

    public function login($request)
    {
        try {
            $user = $this->findByEmail($request->email);

            if (!$user) {
                return [
                    'error' => true,
                    'message' => 'user not found'
                ];
            }

            if (!$user->checkPassword($request->password)) {
                return [
                    'error' => true,
                    'message' => 'Wrong password'
                ];
            }

            $token = $this->authRepository->login($user);
            return ['token' => $token];
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function logout($request)
    {
        try {
            return $request->user()->currentAccessToken()->delete();

        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function changePassword($request)
    {
        try {
            $user = $this->me(auth()->user()->id);


            if (!Hash::check($request->current_password, $user->password)) {
                return [
                    'error' => true,
                    'message' => 'Wrong current password'
                ];
            }

            $data = [
                'password' => $request->new_password
            ];

            return $this->authRepository->changePassword($user, $data);
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function forgetPassword($request)
    {
        try {
            $user = $this->findByEmail($request->email);

            if (!$user) {
                return [
                    'error' => true,
                    'message' => 'user not found'
                ];
            }
            $resetCode = random_int(100000, 999999);
            $data = [
                'password_reset_code' => $resetCode,
                'password_reset_code_expires_at' => now()->addMinutes(2)
            ];

            $response = $this->authRepository->changePassword($user, $data);


            Mail::send('Mail.verify', ['code' => $resetCode, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email)->subject('Your reset code');
            });

            return $user;

        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function resetPassword($request)
    {
        try {
            $user = $this->findByEmail($request->email);
            if (!$user) {
                return [
                    'error' => true,
                    'message' => 'user not found'
                ];
            }

            if ($user->password_reset_code !== $request->code || $user->password_reset_code_expires_at < now()) {
                return [
                    'error' => true,
                    'message' => 'Invalid code'
                ];
            }

            $data = [
                'password' => $request->new_password,
                'password_reset_code' => null,
                'password_reset_code_expires_at' => null
            ];

            return $this->authRepository->resetPassword($user, $data);
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage()
            ];
        }
    }

}
