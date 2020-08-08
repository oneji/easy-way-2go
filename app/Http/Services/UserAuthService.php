<?php

namespace App\Http\Services;
use App\Http\Requests\LoginUserRequest;
use App\User;

class UserAuthService
{
    /**
     * Authenticate the user and return jwt token.
     * 
     * @param   \App\Http\Requests\LoginUserRequest $request
     * @return  array
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return [
                'ok' => false,
                'message' => 'Пользователя с таким email адресом не найдено.'
            ];
        }

        // Check if the user is verified
        if(!$user->verified) {
            return [
                'ok' => false,
                'message' => 'Перед тем как войти, подтвердите ваш номер телефона.'
            ];
        }

        // Authenticate the user
        if (!$token = auth('client')->attempt($credentials)) {
            return [
                'ok' => false,
                'message' => 'Неверный логин или пароль.'
            ];
        }

        return [
            'ok' => true,
            'token' => $token,
            'user' => $user,
            'expires_in' => auth('client')->factory()->getTTL() * 60
        ];
    }

    /** 
     * @OA\Get(
     *      path="/api/auth/clients/verify/{code}",
     *      operationId="verifyUser",
     *      tags={"Users"},
     *      summary="Verify a user by verification code.",
     *      @OA\Response(
     *          response="200", 
     *          description="Номер телефона успешно подтвержден.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="ok",
     *                  type="boolean",
     *                  example=true
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Номер телефона успешно подтвержден."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Ввведен неверный код подтверждения."          
     *      ),
     *      @OA\Parameter(
     *          name="verificationCode",
     *          in="path",
     *          description="Verification code sent to the user via sms",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      )
     * )
     * 
     * Verify user by verification code.
     * 
     * @param   int $verificationCode
     * @return  array
     */
    public function verify($verificationCode)
    {
        $user = User::where('verification_code', $verificationCode)->first();
        
        if(!$user) {
            return [
                'ok' => false,
                'message' => 'Ввведен неверный код подтверждения.'
            ];   
        }

        $user->verified = 1;
        $user->verification_code = null;
        $user->phone_number_verified_at = Carbon::now();
        $user->save();

        return [
            'ok' => true,
            'message' => 'Номер телефона успешно подтвержден.',
            'user' => $user
        ];
    }
}