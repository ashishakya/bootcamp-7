<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\ForgotPasswordRequest;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email'),
            static function ($user, $token) {
                $user->notify(new CustomResetPasswordNotification($token));
            }
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->sendSuccessResponse([]);
        }

        return $this->sendErrorResponse('Error while sending password reset link.');
    }
}
