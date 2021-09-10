<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private function getResponse(User $user) {
        $tokenResult = $user->createToken("Personal Access Token");

        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response([
            'accessToken' => $tokenResult->accessToken,
            'tokenType' => "Bearer",
            'expiresAt' => Carbon::parse($token->expires_at)->toDateTimeString()
        ], 200);
    }

    // Simple Register and Login Task
    public function register(Request $request) {
        $validation = Validator::make($request->all(), [
            "fullName" => "required|string|max:255",
            "email" => "required|string|email|unique:users|max:255",
            "password" => "required|string|min:6|max:255|confirmed",
        ]);

        if ($validation->fails()) {
            return response(["errors" => $validation->errors()], 422);
        }

        $user = new User();

        $user->full_name = $request->fullName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->getResponse($user);
    }

    public function login(Request $request) {
        $validation = Validator::make($request->all(), [
            "email" => "required|string|email|max:255",
            "password" => "required|string|min:6|max:255",
        ]);

        if ($validation->fails()) {
            return response(["errors" => $validation->errors()], 422);
        }

        if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            $user = $request->user();
            return $this->getResponse($user);
        } else {
            return response("Invalid Credentials!", 401);
        }
    }

    // Logout and getting user Data
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response("Successfully logged out!", 200);
    }

    public function user(Request $request) {
        return $request->user();
    }

    // Resetting password
    public function forgotPassword(Request $request) {
        $validation = Validator::make($request->all(), [
            "email" => "required|string|email|max:255",
        ]);

        if ($validation->fails()) {
            return response(["errors" => $validation->errors()], 422);
        }

        $status = Password::sendResetLink(
            $request->only("email")
        );

        if ($status == Password::RESET_LINK_SENT) {
            return ["status" => __($status)];
        }

        throw ValidationException::withMessages([
            "email" => [trans($status)],
        ]);
    }

    public function resetPassword(Request $request) {
        $validation = Validator::make($request->all(), [
            "token" => "required",
            "email" => "required|string|email|max:255",
            "password" => "required|string|min:6|max:255|confirmed",
        ]);

        if ($validation->fails()) {
            return response(["errors" => $validation->errors()], 422);
        }

        $status = Password::reset(
            $request->all(),
            function ($user) use ($request) {
                $user->forceFill([
                    "password" => bcrypt($request->password),
                ])->save();
//                $user($request->token)->tokens()->delete();
                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response(["message" => "Password reset successfully"]);
        }

        return response([
            "message" => __($status)
        ], 500);
    }

    // Auth Failure Message
    public function authFailed() {
        return response("Unauthenticated!", 400);
    }
}
