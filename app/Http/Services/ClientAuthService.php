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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
     * @param   \Illuminate\Http\Request $request
     * @return  array
     */
    public function register(Request $request)
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
}