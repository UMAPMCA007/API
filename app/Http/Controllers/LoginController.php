<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function signup(Request $request)
    {
        $request->all();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'activity_type' => 'required',
            'activity_name[]' => '',
            'g-recaptcha-response' => 'required',
        ]);
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            
        ]);
        $user->save();
        $request->session()->put('user', $user);
        $user->notify(new WelcomeEmailNotification());
        $activity=new \App\Models\Activity;
       
        foreach($request->get('activity_name') as $activity_name){
            $activity->create([
                'user_id'=>$user->id,
                'activity_type'=>$request->get('activity_type'),
                'activity_name'=>$activity_name,
            ])->save;
        }        
    
        return redirect()->route('login')->with('success', 'User created');
    }
    //login function
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->get('email'))->first();
        if ($user) {
            if (Hash::check($request->get('password'), $user->password)) {
                $request->session()->put('user', $user);
                return view('dashboard');
            } else {
                return redirect()->route('login')->with('error', 'Wrong password');
            }
        } else {
            return redirect()->route('login')->with('error', 'User not found');
        }
    }
    
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}
