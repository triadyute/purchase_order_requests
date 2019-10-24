<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Department;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $departments = Department::all();
        return view('auth.register', compact('departments'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //dd(request()->all());
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'department_id' => ['required', 'integer'],
            'job_title' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:4000']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'department_id' => $data['department_id'],
            'job_title' => $data['job_title'],
            'password' => Hash::make($data['password']),
            'profile_photo' => $data['profile_photo']
        ]);
        $role = 1;
        $user->roles()->attach($role);
        $imageName = request()->file('profile_photo');
        if($imageName!==null)
         {
        //     // get the extension
        //     $extension = $imageName->getClientOriginalExtension();
        //     // create a new file name
        //     $new_name = date( 'Y-m-d' ) . '-' . Str::random( 10 ) . '.' . $extension;
        //     // move file to public/images/new and use $new_name
        //     $imageName->move( public_path('/public/profile_photos'), $new_name);
        //     $user->profile_photo = $new_name;
        // }
        // if (!empty(request()->profile_photo))
        // {
        //     // $fileNameWithExt = request()->file('profile_photo')->getClientOriginalName();
        //     // $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        //     // $extension = request()->file('profile_photo')->getClientOriginalExtension();
        //     // $fileNameToStore = $filename.'_'.time().'.'.$extension;
        //     // $path = request()->file('profile_photo')->storeAs('public/profile_photos', $fileNameToStore);
        //     // $final_name = $fileNameToStore;
        //     // //dd($final_name);
        //     // $user->profile_photo = $final_name;     
             $file = request()->input('profile_photo');
             $destinationPath = public_path(). '/public/profile_photos';
             $filename = $file->getClientOriginalName();
             request()->input('profile_photo')->move($destinationPath, $filename);       
        }
        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);

        return $this->registered($request, $user)
        // ?: redirect($this->redirectPath());
                        ?: redirect(route('home'))->with('status', 'Account created');
    }
}
