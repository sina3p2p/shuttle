<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct() {
        $this->middleware('guest:admin')->except('logout');
    }

    public function index()
    {
        return view('shuttle::auth.login');
    }

    public function store(Request $request)
    {

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], false)) {
            return redirect()->intended(route('shuttle.index'));
        } else {
            return redirect()->back()->withErrors([
                'incorrect_user' => 'Email or password is not correct.'
            ])->withInput($request->except('password'));
        }
    }

    public function destroy() {
        Auth::logout();
        return redirect()->route('shuttle.login.index');
    }

}
