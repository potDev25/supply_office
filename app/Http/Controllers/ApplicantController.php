<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicantRequest;
use App\Models\Applicant;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $applicants = Applicant::select('applicants.*', 'applicants.id as applicant_id', 'media.*', 'users.*')
                    ->join('media', 'applicants.id', '=', 'media.applicant_id')
                    ->join('users', 'applicants.user_id', '=', 'users.id')
                    ->orderBy('applicants.lastname', 'ASC')->paginate($request->limit);

        return response($applicants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicantRequest $request)
    {
        $payload = $request->validated();

        if($request->hasFile('profile_image')){
            $payload['profile_image'] = $request->file('profile_image')->store('media', 'public');
        }

        DB::transaction(function () use (&$payload){
            $user = User::create([
                'lastname' => $payload['lastname'],
                'firstname' => $payload['firstname'],
                'role' => 'admin',
                'email' => $payload['email'],
                'username' => $payload['username'],
                'password' => Hash::make($payload['password']),
            ]);

            $payload['user_id'] = $user->id;
            $applicant = Applicant::create([
                "user_id" => $payload['user_id'],
                "lastname" => $payload['lastname'],
                "firstname" => $payload['firstname'],
                "middlename" => $payload['middlename'],
                "email" => $payload['email'],
                "contact_number" =>  $payload['contact_number'],
                "username" =>  $payload['username'],
                "position" => $payload['position']
            ]);

            Media::create([
                'applicant_id' => $applicant->id,
                'profile_image' => $payload['profile_image'],
            ]);
        });

        return response(200);
    }

    public function batch_delete(Request $request){
        $ids = $request->all();

        DB::transaction(function () use (&$ids){
            User::whereIn('id', $ids)->delete();
            Applicant::whereIn('user_id', $ids)->delete();
        });

        return response(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::transaction(function () use (&$user){
            Applicant::where('user_id', $user->id)->delete();
            $user->delete();
        });

        return response(200);
    }
}
