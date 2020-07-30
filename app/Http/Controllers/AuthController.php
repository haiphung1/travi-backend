<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->client = new Client();
    }

    public function register(Request $request){

        $this->validate($request, [
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'first_name' => 'required|string|min:4|max:32',
            'last_name' => 'required|string|min:4|max:32',
            'gender' => 'required',
            'birthdate' => 'date|required|before:tomorrow',
            'phone_number' => 'required|string'
        ]);
        try {
            $user = new User;
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->gender = $request->input('gender');
            $user->birthdate = $request->input('birthdate');
            $user->phone_number = $request->input('phone_number');

            $user->save();
            return response()->json(['user' => $user, 'code' => 200], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'ERROR'], 409);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $password = $request->input('password');
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'email' => 'NOT_EXIST'
            ]);
        }
        if (Hash::check($password, $user->password)) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            return response()->json([
                'code' => 200,
                'data' => [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ],

            ]);

        } else {
            return response('Login failed', 500);
        }

    }

    public function loginGoogle(Request $request)
    {
        try {
            $data = $request->token;

            $checkToken = $this->client->get("https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=$data");
            $responseGoogle = json_decode($checkToken->getBody()->getContents(), true);

            return $this->checkEmail($responseGoogle);
        } catch (Exception $e) {
            return response()->json(['message' => 'ERROR'], 409);
        }
    }

    public function checkEmail($checkUser)
    {
        $user = User::where('email', $checkUser['email'])->first();
        if (!$user) {
            $user = User::create([
                'username' => $checkUser['sub'],
                'name' => $checkUser['name'],
                'email' => $checkUser['email'],
                'password' => app('hash')->make(str_random(8)),
                'first_name' => $checkUser['given_name'],
                'last_name' => $checkUser['family_name'],
                'avatar' => $checkUser['picture'],
                'provider' => 'google',
            ]);

        }

        $tokenResult = $user->createToken('Personal Access Client');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addMonth();
        $token->save();

        return response()->json([
            'code' => 200,
            'data' => [
                'user_id' => $user->id,
                'username' => $user->username,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ],
        ]);

    }

}
