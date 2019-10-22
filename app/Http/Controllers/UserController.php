<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\User;
use App\Department;
use App\Mail\AdminCreatedUser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $this->authorize('manage-all-users');
        $users = User::all();
        //return $users;
        return view('users.index', compact('users'));
    }
    
    public function create(){
        $departments = Department::all();
        return view('users.create', compact('departments'));
    }

    public function store(Request $request){
        //dd(request()->all());
        $random_password = Str::random(16);
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
            'password' => Hash::make($random_password)
            //'password' => Hash::make($data['password'])
        ]);


        if(request()->role_select == 'role_user'){
            $role = 1;
        }
        if(request()->role_select == 'role_manager'){
            $role = 2;
        }
        if(request()->role_select == 'role_senior_manager'){
            $role = 3;
        }
        if(request()->role_select == 'role_admin'){
            $role = 4;
        }
        $user->roles()->detach();
        $user->roles()->attach($role);
        $user->save();
        Mail::to($user->email)->queue(new AdminCreatedUser($user, $random_password));
        return redirect(route('user.index'))->with('status', 'User added');
    }

    public function show(User $user){
        $managers = User::getManagers($user->department->id);
        $purchase_order_requests = $user->myPurchaseOrders();
        //return $managers;
        return view('users.show', compact('user', 'managers', 'purchase_order_requests'));
    }

    public function edit(User $user){
        $departments = Department::all();
        return view('users.edit', compact('user', 'departments'));
    }
}
