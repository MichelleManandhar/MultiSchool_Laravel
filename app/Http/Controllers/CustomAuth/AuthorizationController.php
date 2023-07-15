<?php

namespace App\Http\Controllers\CustomAuth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthorizationController extends Controller
{
    public function registerUser(Request $request)
    {
        $userToStore = new User();
        $userToStore->name = $request->name;
        $userToStore->email = $request->email;
        $userToStore->password = Hash::make($request->name);
        return redirect('/sign');
    }

    public function login(Request $request)
    {
        try {

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)){
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);}
            $user = $request->user();
            $tokenResult = $user->createToken($user->id);
            $token = $tokenResult->token;
            return response()->json(['status' => 'success', 'token' => $token, 'id' =>Auth::id(), 'user' => $user])->header('Authorization', $tokenResult->accessToken);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function resetToken(Request $request)
    {
        try {
            Passport::personalAccessTokensExpireIn(now()->addMinutes(30));

            $user = Auth::user();
            $token=$user->token();
            $token->revoke();
            $tokenResult = $token = $user->createToken('Personal Access Token')->accessToken;
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $tokenResult);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
