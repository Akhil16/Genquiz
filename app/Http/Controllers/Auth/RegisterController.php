<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }



    public function register(Request $request){

        $validation = array(
            'name' => 'required|max:70',
            'username' => 'required|max:50|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8|confirmed',
           
        );

        $vl = Validator::make($request->all(),$validation);

        if($vl->fails())
        {
            return redirect()->back()->withErrors($vl)->withInput();
        }
        else
        {
            // save new user
            $user = new User;
            $user->user_unique = $user->getUserUnique();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email ? $request->email : null;
            $user->password = bcrypt($request->password);
            $user->save();

            return back()->with('message' , "You're registered successfully");
        }


    }

    public function getRegisterForm(){

        return view('auth.register');
    }
}
