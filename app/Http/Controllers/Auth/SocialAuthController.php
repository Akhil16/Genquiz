<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\User;

class SocialAuthController extends Controller
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function loginWithFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook()
    {
        $fbuser = Socialite::driver('facebook')->stateless()->user();
        
        if(User::checkSocialUser($fbuser->getEmail(), $fbuser->getId()) === 0){
            // save users detail
            $user = new User;
            $user->user_unique = $user->getUserUnique();
            $user->email = $fbuser->getEmail() ? $fbuser->getEmail() : null;
            $user->password = null;
            $user->mobile = null;
            $user->social_auth_id = $fbuser->getId() ? $fbuser->getId() : null;
            $user->social_auth = '1';
            $user->save();

            // $student = new UserStudents();
            // $student->user_unique = $user->user_unique;
            // $student->name = $fbuser->getName() ? $fbuser->getName() : null;
            // $student->dob = null;
            // $student->year_interested_in = null;
            // $student->current_city = null;
            // $student->course = null;
            // $student->social_auth = '1';
            // $student->profilepic = "http://graph.facebook.com/" . $fbuser->getId() . "/picture?type=large&width=150&height=150";
            // $student->save();

        }

        auth()->login(User::where('email' , '=' , $fbuser->getEmail())
                    ->orWhere('social_auth_id' , '=' , $fbuser->getId())->first());
        
        if(Auth::check()){

            return redirect('/');
        }
        else{

            return redirect('/login')->with('errormsg' , 'Sorry Some Error Occured');
        }
    }

    //Login with Google

    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        $guser = Socialite::driver('google')->stateless()->user();
        
        if(User::checkSocialUser($guser->getEmail(), $guser->getId()) === 0){
            // save users detail
            $user = new User;
            $user->user_unique = $user->getUserUnique();
            $user->email = $guser->getEmail() ? $guser->getEmail() : null;
            $user->password = null;
            $user->mobile = null;
            $user->social_auth_id = $guser->getId() ? $guser->getId() : null;
            $user->social_auth = '2';
            $user->save();

            // $student = new UserStudents();
            // $student->user_unique = $user->user_unique;
            // $student->name = $guser->getName() ? $guser->getName() : null;
            // $student->dob = null;
            // $student->year_interested_in = null;
            // $student->current_city = null;
            // $student->course = null;
            // $student->social_auth = '2';
            // $student->profilepic = $guser->avatar_original;
            // $student->save();

        }

        auth()->login(User::where('email' , '=' , $guser->getEmail())
                    ->orWhere('social_auth_id' , '=' , $guser->getId())->first());
        
        if(Auth::check()){

            return redirect('/');
        }
        else{

            return redirect('/login')->with('errormsg' , 'Sorry Some Error Occured');
        }
    }
}
