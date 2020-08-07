<?php

/**
 * @OA\Info(
 *      title="EuroWay2Go API documentation",
 *      version="1.0.0",
 *      @OA\Contact(
 *          email="timich1995@gmail.com"
 *      )
 * )
 * @OA\Tag(
 *      name="Clients",
 *      description="Clients auth endpoints"
 * )
 * @OA\Server(
 *      description="EuroWay2Go API server",
 *      url="http://e2way.ru/api"
 * )
 * @OA\SecurityScheme(
 *      type="apiKey",
 *      in="header",
 *      name="Bearer",
 *      securityScheme="Bearer"
 * )
 */

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Traits\UploadImageTrait;
use Carbon\Carbon;
use App\User;
use JWTAuth;
use App\ClientData;

class ClientAuthService
{
    use UploadImageTrait;

    /**
     * @OA\Post(
     *      path="/api/auth/clients/register",
     *      operationId="clientsRegister",
     *      tags={"Clients"},
     *      summary="Store a newly created user in the db",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="test@test.com"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  example="password"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Регистрация успешно завершена.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="ok",
     *                  type="boolean",
     *                  example=true
     *              ),
     *              @OA\Property(
     *                  property="verification_code",
     *                  type="integer",
     *                  example=515789
     *              )
     *          )
     *      )
     * )
     * 
     * Store a newly created user in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function register(StoreUserRequest $request)
    {
        $user = new User($request->except('password'));
        $user->verification_code = mt_rand(100000, 999999);
        $user->role = User::ROLE_CLIENT;
        $user->password = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $user->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $user->save();

        // Save additional data
        $user->client_data()->save(new ClientData([
            'id_card' => $request->id_card,
            'passport_number' => $request->passport_number,
            'passport_expires_at' => $request->passport_expires_at
        ]));

        // TODO: Connect sms endpoint and the verification code via sms.
        return [ 
            'ok' => true,
            'verification_code' => $user->verification_code,
        ];
    }

    /** 
     * @OA\Get(
     *      path="/api/auth/clients/verify/code",
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

    /**
     * Authenticate the user and return jwt token.
     * 
     * @param   \App\Http\Requests\LoginUserRequest $request
     * @return  array
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)
            ->where('role', User::ROLE_CLIENT)
            ->first();

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
            'expires_in' => auth('client')->factory()->getTTL() * 60
        ];
    }
}