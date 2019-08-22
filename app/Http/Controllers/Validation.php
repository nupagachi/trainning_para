<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class Validation extends Controller
{
    public function rule(Request $request)
    {

        $ar = [
            'name' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required',
            'profile_image' => 'required|image|mimes:png,jpg,gif|max:2048'
        ];
        if($request->has('password')){
            $ar = array_merge($ar,['password'=>'required|min:5']);
        }
        return $ar;
    }
    public function rule_noImg(Request $request)
    {

        $ar = [
            'name' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required',
        ];
        if($request->has('password')){
            $ar = array_merge($ar,['password'=>'required|min:5']);
        }
        return $ar;
    }
     public function messeger()
    {
        return[
        'name.required'=>'Bạn phải nhập tên user',
        'name.string'=>'Tên phải là kiểu kí tự',
        'email.required'=>'Bạn phải nhập email',
        'email.email'=>'Bạn phải nhập định dạng kiểu email',
        'password.required'=>'Bạn phải nhập mật khẩu',
        'password.min'=>'Mật khẩu tối thiểu là 5 ký tự',
        'address.required'=>'Bạn phải nhập vào địa chỉ',
        'profile_image.required'=>'Bạn phải nhập vào ảnh',
        'profile_image.image'=>'Dữ liệu nhập vào phải là ảnh',
        'profile_image.mimes'=>'Dữ liệu nhập vào phải đúng định dạng:png,jpg,gif'
    ];
}
}
