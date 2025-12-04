<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
//use App\Http\Requests\Backend\Auth\LoginRequest;
use App\Models\User;
//use App\Traits\ApiResponses;
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (!auth()->attempt($request->only("email", "password"))) {
            return response()->json([
                "message"=>__("auth.failed"),
                "status"=>false
                                    ], 404);
        }

        /** @var User $user */
        $user = User::firstWhere("email", $request->get("email"));

//        if (!$user->hasVerifiedEmail()) {
//            return $this->sendErrorResponse(__("auth.email_not_verified"), 403);
//        }

//        if (!$user->enabled) {
//            return $this->sendErrorResponse(__("auth.account_disabled"), 403);
//        }


//        $data = [
            $token = $user->createToken("Api Token for " . $user->email, ["server:update"])->plainTextToken;
//        ];
//        return $user->createToken('token-name', ['server:update'])->plainTextToken;



        return response()->json([
            "token"=>$token
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
        return response()->json("successfully logged out");
    }
}
