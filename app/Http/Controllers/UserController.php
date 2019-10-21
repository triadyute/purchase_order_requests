<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Department;


class UserController extends Controller
{
    public function create(){
        $departments = Department::all();
        return view('users.create', compact('departments'));
    }

    public function store(Request $request){
        //dd(request()->all());
        $random_password = base64_encode(random_bytes(15));
        $data = request()->validate([
            'name' => 'string|max:255',
            'email' => 'string|max:255',
            'department' => 'string|max:255',
            'job_title' => 'string|max:255'
            //'password' => 'string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'department_id' => $data['department'],
            'job_title' => $data['job_title'],
            'password' => $random_password
            //'password' => Hash::make($data['password'])
        ]);


        if(request()->role_select == 'role_user'){
            $role = 2;
        }
        if(request()->role_select == 'role_manager'){
            $role = 2;
        }
        if(request()->role_select == 'role_senior_manager'){
            $role = 2;
        }
        if(request()->role_select == 'role_admin'){
            $role = 2;
        }
        $user->roles()->detach();
        $user->roles()->attach($role);
        $user->save();
        return redirect(route('home'))->with('status', 'User added');
    }
}
