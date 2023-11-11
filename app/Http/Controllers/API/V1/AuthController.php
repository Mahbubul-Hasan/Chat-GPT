<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\Authentication\AuthenticationRequest;

class AuthController extends Controller {

    /**
     * User sign in
     * @OA\Post(
     *      path="/api/v1/login",
     *      summary="Sign in with email & password",
     *      description="SignIn by email, password",
     *      operationId="login",
     *      tags={"Authentication"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Customer credentials",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$", format="email", example="pdamore@example.net"),
     *              @OA\Property(property="password", type="string", format="password", example="123456"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="SignIn successfully!")
     *         )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong credentials response",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *          )
     *      )
     * )
     */

    public function login(AuthenticationRequest $request) {
        $credentials = $request->only(['email', 'password']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], Response::HTTP_BAD_REQUEST);
        }

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid Email or Password!'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $accessToken = $user->createToken('auth')->plainTextToken;

            $response = [
                'message' => "Sign in successfully!",
                'user'    => new UserResource($user),
                "token"   => "Bearer " . $accessToken,
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }

    }
}
