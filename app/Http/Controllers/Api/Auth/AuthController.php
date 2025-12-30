<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Backend\Auth
 */
class AuthController extends Controller
{
//    use ApiResponses;

    /**
     * @param AuthRequest $request
     *
     * @return JsonResponse
     */
    public function login(AuthRequest $request): JsonResponse
    {
//        $credentials = $request->validate([
//                                              'email' => 'required|email',
//                                              'password' => 'required',
//                                          ]);

        if (!auth()->attempt($request->only("email", "password"))) {
            return response()->json([
                "message"=>__("auth.failed"),
                "status"=>false,
                                    ], 404);
        }

        // check database
        $enable = false;

//        dd(auth()->user());

        /** @var User $user */
        $user = auth()->user();

        if (empty($user->email_verified_at)) {
            return response()->json(["status"=>"Pending eamil verification"], 403);
        }

        if (!$enable) {
            return response()->json(["status"=>"Pending Payment"], 403);
        }


            $token = $user->createToken("Api Token for " . $user->email, ["bootcamper:attendees"])->plainTextToken;
//            $token = $user->createToken("Api Token for " . $user->email, ["bootcamper:absentees"])->plainTextToken;
//            $token = $user->createToken("Api Token for " . $user->email)->plainTextToken;

            //        return $user->createToken('token-name', ['server:update'])->plainTextToken;



        return response()->json([
            "token"=>$token,
                                ]);
//        $this->sendSuccessResponse($data);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function me(Request $request)
    {
        $authenticatedUser = auth()->user();

//        return $this->sendSuccessResponse($authenticatedUser->only(["id", "name", "email"]));
        return response()->json($authenticatedUser->only(["id", "name", "email"]));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        //        $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();

//        return $this->sendSuccessResponse([], __("auth.logout"));
        return response()->json(["message"=>"Successfully logged out."], 200);
    }

    public function unprotected(Request $request)
    {
        return response()->json([
            "data"=>"These are free data",
                                ]);
    }
}
