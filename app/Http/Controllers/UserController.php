<?php

namespace App\Http\Controllers;

use App\Traits\UploadTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use UploadTrait;

    public function getAll()
    {

        $user = User::paginate(config('constant.pagintion.page'));
        User::paginate();
        $elements = User::all();
//        dd( User::paginate());
        return view('user.manager_user.index', compact('user', 'elements'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        Session::put('url', url()->previous());
        return view('user.manager_user.edit', compact('user'));
    }

    public function post($id, Request $request)
    {

        $validate=new Validation();
        $validtor=Validator::make($request->all(),$validate->rule_noImg($request),$validate->messeger());
        if($validtor->fails()){
            return redirect()->back()->withInput(Input::all())->withErrors($validtor->errors()->all());
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
//        if ($request->has('profile_image')) {
//            $image = $request->file('profile_image');
//            $name = str_slug($request->input('name')) . '_' . time();
//            $folder = '/uploads/images/';
//            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
//            $this->uploadOne($image, $folder, 'public', $name);
//            $user->profile_image = $filePath;
//        }
        $user->save();
        $url = Session::get('url');

        return redirect($url);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->active_flg = config('constant.UNACTIVE');
        $user->save();
        return redirect('/');
    }

    public function profile()
    {

        $user = Auth::user();
        return view('user.profile.index', compact('user'));
    }

    public function search(Request $request)
    {
        Session::put('name', $request->name);
        Session::put('email', $request->email);
        Session::put('role', $request->role);
        if($request->active==config('constant.VALUE')){
            Session::put('active',config('constant.UNACTIVE'));
        }else{
            Session::put('active',$request->active);
        }
        $users = DB::table('users')->where([['name', 'like', '%' . Session::get('name') . '%'],
            ['email', 'like', '%' . Session::get('email') . '%'],
            ['role_id', 'like', '%' . Session::get('role') . '%'],
            ['active_flg', 'like', '%' . Session::get('active') . '%']])->paginate(config('rules.pagintion.page'));
        $users->appends(['name' => Session::get('name'), 'email' => Session::get('email'), 'role' => Session::get('role'), 'active' => Session::get('active')]);
        return view('user.manager_user.index', ['user' => $users]);

    }


    public function postProfile(Request $request)
    {
        $user = Auth::user();
        $validate=new Validation();
        $validator = Validator::make($request->all(),$validate->rule($request),$validate->messeger());
        if ($validator->fails()) {
            if ($request->name == '' || $request->email == '' || $request->address == '') {
                if (!$request->has('profile_image')) {
                    if (Session::get('name1')) {
                        return redirect()->back()->with('data', Session::get('name1'))->withErrors($validator->errors()->all())->withInput(Input::all());
                    }
                    return redirect()->back()->withInput(Input::all())->withErrors($validator->errors()->all());
                } else {
                    if ($validator->errors()->get('profile_image')) {
                        Session::forget('name1');
                        $image = $request->file('profile_image');
                        $name = 'Fail' . '_' . time();
                        $folder = 'uploads/images/';
                        $this->uploadOne($image, $folder, 'public', $name);
                        $request->session()->flash('data', $name . '.' . $image->getClientOriginalExtension());
                        return redirect()->back()->withInput(Input::all())->withErrors($validator->errors()->all());
                    } else {
                        $image = $request->file('profile_image');
                        $name = str_slug($request->input('name')) . '_' . time();
                        $folder = 'uploads/images/';
                        $this->uploadOne($image, $folder, 'public', $name);
                        Session::put('name1', $name . '.' . $image->getClientOriginalExtension());
                        return redirect()->back()->with('data', Session::get('name1'))->withInput(Input::all())->withErrors($validator->errors()->all());
                    }
                }
            } else {

                if ($request->has('profile_image') && $validator->errors()->get('profile_image')) {
                    Session::forget('name1');
                    $image = $request->file('profile_image');
                    $name = 'Fail' . '_' . time();
                    $folder = 'uploads/images/';
                    $request->session()->flash('data', $name . '.' . $image->getClientOriginalExtension());
                    $this->uploadOne($image, $folder, 'public', $name);
                    return redirect()->back()->withInput(Input::all())->withErrors($validator->errors()->all());
                } else if ($request->has('profile_image') && !$validator->errors()->get('profile_image')) {
                    $image = $request->file('profile_image');
                    $name = str_slug($request->input('name')) . '_' . time();
                    $folder = '/uploads/images/';
                    $this->uploadOne($image, $folder, 'public', $name);
                    Session::put('name1', $name . '.' . $image->guessClientExtension());
                    return redirect()->back()->withInput(Input::all())
                        ->with('data', Session::get('name1'))
                        ->withErrors($validator->errors()->all());
                } else if (!$request->has('profile_image')) {
                    $data = Session::get('name1');
                    if (!empty($data)) {

                        $folder = '/uploads/images/';
                        $user->profile_image = $folder . $data;
                        $user->name = $request->name;
                        $user->email = $request->email;
                        $user->address = $request->address;
                        Session::forget('name1');
                        $user->save();
                        return redirect()->back();
                    } else {
                        $user->name = $request->name;
                        $user->email = $request->email;
                        $user->address = $request->address;
                        $user->save();
                        return redirect()->back();
                    }
                }
            }
        } else {
            $image = $request->file('profile_image');
            $folder = '/uploads/images/';
            $name = str_slug($request->input('name')) . '_' . time();
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $this->uploadOne($image, $folder, 'public', $name);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->profile_image = $filePath;
            $user->save();
            return redirect()->back();
        }

    }
}

