<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AccountRequestController extends Controller
{
    /**
     * Handle the incoming account request.
     */
    public function __invoke(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'company'   => 'nullable|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'required|string|max:20',
            'role'      => 'required|string|max:255',
        ]);

        // Send the account request email
        Mail::to('hallo@fixlio.com')->send(new AccountRequestMail($validated));

        // Return a success response
        return $this->sendSuccessResponse([], 'Account request sent successfully');
    }
}
