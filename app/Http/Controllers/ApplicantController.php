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
    public function index()
    {
        $applicants = Applicant::select('applicants.*', 'applicants.id as applicant_id', 'media.*')
                    ->join('media', 'applicants.id', '=', 'media.applicant_id')
                    ->orderBy('applicants.id', 'DESC')->paginate(10);

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

        if($request->hasFile('sanitary_permit')){
            $payload['sanitary_permit'] = $request->file('sanitary_permit')->store('media', 'public');
        }

        if($request->hasFile('barangay_clearance')){
            $payload['barangay_clearance'] = $request->file('barangay_clearance')->store('media', 'public');
        }

        DB::transaction(function () use (&$payload){
            $user = User::create([
                'lastname' => $payload['lastname'],
                'firstname' => $payload['firstname'],
                'role' => 'applicant',
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
                "province" => $payload['province'],
                "city" => $payload['city'],
                "barangay" => $payload['barangay'],
                "email" => $payload['email'],
                "contact_number" =>  $payload['contact_number'],
                "username" =>  $payload['username'],
            ]);

            Media::create([
                'applicant_id' => $applicant->id,
                'profile_image' => $payload['profile_image'],
                'sanitary_permit' => $payload['sanitary_permit'],
                'barangay_clearance' => $payload['barangay_clearance'],
            ]);
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
    public function destroy(string $id)
    {
        //
    }
}
