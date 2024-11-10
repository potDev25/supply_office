<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Applicant;
use App\Models\Category;
use App\Models\Department;
use App\Models\Media;
use App\Models\Supplier;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index(Request $request){
        if(auth()->user()->role === 'general admin' || auth()->user()->role === 'supply office'){
            $user = $request->user();
        }else{
            $user = User::select('users.*', 'departments.department_name')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->where('users.id',auth()->user()->id)->first();
        }
        $departments = Department::orderBy('department_name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $supplier = Supplier::where('status', 'Active')->orderBy('supplier_name', 'ASC')->get();
        $supplies = Supply::orderBy('supply_name', 'ASC')->get();
        
        return response(compact('user', 'departments', 'categories', 'supplier', 'supplies'));
    }

    public function edit(User $user, Request $request)
    {
        $payload = $request->validate([
            "lastname" => 'required',
            "firstname" => 'required',
            "email" => 'required|unique:users,email,'.$user->id,
            "role" => 'required',
        ]);

        if(isset($request->photo)){
            $request->validate([
                'photo' => 'mimes:png,jpg'
            ]);
            $payload['photo'] = $request->file('photo')->store('media', 'public');
        }

        if(isset($request->password)){
             $request->validate([
                'password' => 'required|confirmed'
            ]);

            $payload['password'] = Hash::make($request->password);
        }

        DB::transaction(function () use ($request, $payload, $user){
            $user->update($payload);
        });
    }

    public function login(LoginRequest $request){
        $credentials = $request->validated();

        if(!Auth::attempt($credentials)){
            return response([
                'message_error' => 'Invalid Credentials'
            ], 422);
        }

       /** @var User $user **/
        $user = Auth::user();
        $user_token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'user_token'));
    }

    public function logout(Request $request){
        $user = $request->user();
        /** @var User $user **/
        $user->currentAccessToken()->delete();
    }

    public function getUser(User $user){
        $data = User::select('users.id as user_id',
                        'users.lastname',
                        'users.firstname',
                        'users.middle_name',
                        'users.position',
                        'users.contact_number',
                        'users.username',
                        'users.email',
                        'users.department_id',
                        'media.profile_image'
                    )
                ->join('applicants', 'users.id', '=', 'applicants.user_id')
                ->join('media', 'applicants.id', '=', 'media.applicant_id')
                ->where('users.id', $user->id)->first();
        return response($data);
    }

    public function editUser(User $user, Request $request){
        $image = '';
        $payload = $request->validate([
            "lastname" => 'required',
            "firstname" => 'required',
            "middle_name" => 'nullable',
            "position" => 'required',
            "email" => 'required',
            "contact_number" =>  'required',
            "username" =>  'required',
            "department_id" => 'nullable'
        ]);
        if($request->hasFile('profile_image')){
            $request->validate([
                "profile_image" =>  'nullable|mimes:png,jpg',
            ]);
            $image = $request->file('profile_image')->store('media', 'public');
        }

        if($request->filled('password')){
            $request->validate([
                "password" => 'required|confirmed'
            ]);

            $payload['password'] = Hash::make($request->password);
        }

        // $user->lastname = $payload['lastname'];
        // $user->firstname = $payload['firstname'];
        // $user->middle_name = $payload['middle_name'];
        // $user->position = $payload['position'];
        // $user->email = $payload['email'];
        // $user->contact_number = $payload['contact_number'];
        // $user->username = $payload['username'];
        // $user->department_id = $payload['department_id'];
        // $user->profile_image = $payload['profile_image'];

        DB::transaction(function() use ($user, $payload, $request, $image){
            $user->update($payload);

            if($request->hasFile('profile_image')){
                $user_id = Applicant::where('user_id', $user->id)->first();
                if($image != ''){
                    Media::where('applicant_id', $user_id->id)->update([
                        'profile_image' => $image
                    ]);
                }
            }
        });
    }
}
