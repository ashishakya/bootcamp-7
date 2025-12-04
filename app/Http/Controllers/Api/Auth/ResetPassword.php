<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\ResetPasswordRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPassword extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        // Attempt to reset the user's password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            static function ($user, $password) {
                $user->password          = $password;
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
        );

        // Handle the result of the reset attempt
        if ($status === Password::PASSWORD_RESET) {
            return $this->sendSuccessResponse(['message' => 'Password reset successfully.']);
        }

        return $this->sendErrorResponse('Failed to reset password. The token may be invalid or expired.', 400);
    }
}
