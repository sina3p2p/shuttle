<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends BaseController
{

    // public function __construct() {
    //     $this->middleware('guest:shuttle,shuttle_api')->except('logout');
    // }

    public function index()
    {
        return view('shuttle::auth.login');
    }

    public function store(Request $request)
    {

        Auth::shouldUse('shuttle');
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            if($this->is_api)
            {
                $token = Str::random(60);
                $user->api_token = hash('sha256', $token);
                $user->save();
                $user['token'] = $user->api_token;
                return response()->json(['user' => $user], 200);
            }          

            return redirect()->intended(route('shuttle.index'));
            
        }else if($this->is_api) return response()->json(['error'=>'Unauthorised'], 401);
       
        return redirect()->back()->withErrors([
            'incorrect_user' => 'Email or password is not correct.'
        ])->withInput($request->except('password'));

    }

    public function destroy() {
        Auth::logout();
        return redirect()->route('shuttle.login.index');
    }

}
