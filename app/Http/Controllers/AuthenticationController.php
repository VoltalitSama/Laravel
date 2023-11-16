<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{
    public function showForm(){
        return view('authentications/authentication');
    }

    public function login(Request $request) {
        $user_mail = $request->get('email');

        if(empty($user_mail)){
            return view('authentications/authentication');
        }

        $user = $this->search_user($user_mail);

        if(!$user){
            abort(404, "User not found");
        }

        $user->sendAuthenticationMail();

        return view('authentications/check_mail', compact('user'));
    }

    public function callback(Request $request) {

        $email = $request->get('email');
        $email = str_replace("3D", "", $email);
        $token = $request->get('token');
        $token = str_replace("3D", "", $token);
        $redirect_to = $request->get('redirect_to');
        $redirect_to = str_replace("3D", "", $redirect_to);

        $user = $this->search_user($email);

        if(!$user){
            abort(404, "User not found");
        }

        $service = new AuthenticationService($user);

        if($service->checkToken($token)){
            Auth::login($user);
            redirect($redirect_to);
        }
        else {
            abort(403, "Token is invalid");
        }
    }

    public function logout(Request $request) {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('auth.login');
    }

    public function search_user(String $email) : ?User{
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            /** @var \App\Models\User $user */
            $user = User::query()
                ->where('email', $email)
                ->first();

            if(empty($user)){
                return null;
            }
            return $user;
        } else {
            return null;
        }
    }
}
