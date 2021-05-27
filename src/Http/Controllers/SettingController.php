<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\Menu;
use Sina\Shuttle\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $setting = setting()->all();
//        dd($setting);
        $menu = Menu::all();
        $page = Page::all();
        return view('shuttle::setting',compact('setting','menu','page'));
    }

    public function store(Request $request)
    {

        $inputs = $request->except('_token');

        foreach ($request->allFiles() as $key => $file){
            if($key == 'service_credentials'){
                $inputs[$key] = storage_path('app/'.$file->storeAs('public/uploads','credentials.json'));
            }else{
                $inputs[$key] = $file->store('public/uploads');
            }
        }

        setting($inputs)->save();

//        dd(setting());

        return redirect()->route('shuttle.setting.index');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password'      => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                },
            ],
            'new_password'  => 'required',
            're_password'   => 'required|same:new_password',
        ]);

//        dd($request->all());

        $user = auth()->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back();

    }
}
