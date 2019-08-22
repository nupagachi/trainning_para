<?php

 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Session;

 if(!function_exists('orderByName')){
     function orderByName($sort){
          $users=DB::table('users')
             ->orderBy('name', $sort);
        return $users;
     }
 }
 if(!function_exists('sortByPlus')){
     function sortByPlus($name,$index,$sort){
         Session::put('c',$index);
         $user=DB::table('users')->orderBy($name,$sort)->paginate(20);
         $user->appends(['sort'=>$sort,'field'=>$name]);
         return $user;
     }
 }


