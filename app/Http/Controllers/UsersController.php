<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Country;
use Auth;
use Session;

class UsersController extends Controller
{

   public function userLoginRegister(){
      return view('users.login_register');
   }

   public function login(Request $request){
      if($request->isMethod('post')){
         $data = $request->all();
         // echo "<pre>"; print_r($data); die;
         if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
            Session::put('frontSession',$data['email']);
            return redirect('/cart');
         }else{
            return redirect()->back()->with('flash_message_error','Invalid username or password!');
         }
      }
   }

   public function register(Request $request){
   	if($request->isMethod('post')){
      $data = $request->all();
      // echo "<pre>"; print_r($data); die;
      //check if email is exists or not
      $usersCount = User::where('email',$data['email'])->count();
      if ($usersCount>0){
      	return redirect()->back()->with('flash_message_error','Email already exists!');
      }else{
      	$user = new User;
         $user->name = $data['name'];
         $user->email = $data['email'];
         $user->password = bcrypt($data['password']);
         $user->save();
         if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
            Session::put('frontSession',$data['email']);
            return redirect('/cart');
         }
        }
   	}
   }

   public function account(){
      $user_id = Auth::user()->id;
      $userDetails = User::find($user_id);
       // echo "<pre>"; print_r($userDetails); die;
      $countries = Country::get();
      return view('users.account')->with(compact('countries','userDetails'));
   }

   public function logout(){
      Auth::logout();
      Session::forget('frontSession');
      return redirect('/');
   }

   public function checkEmail(Request $request){
       $data = $request->all();
      // echo "<pre>"; print_r($data); die;
      //check if email is exists or not
      $usersCount = User::where('email',$data['email'])->count();
      if ($usersCount>0){
         echo "false";
      }else{
         echo "true"; die;
      }
   	}
}
