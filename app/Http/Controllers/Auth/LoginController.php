<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiTokenController;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $apiTokenController;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->apiTokenController = new ApiTokenController();
    }


    public function auth(Request $request)
    {
        $input = $request->only('email', 'password');


        if (!Auth::attempt($input)) {
            return response(['message' => 'Usuário ou senha incorretos'], 401);
        }
        $this->authenticateUser($request);
        $user = Auth::user();
        $response = response($user);
        return $response->header('Authorization', "Bearer {$user->api_token}");

    }

    public function authenticateUser($request)
    {
        return $this->apiTokenController->update($request);
    }
}
