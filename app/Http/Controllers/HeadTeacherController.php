<?php

namespace App\Http\Controllers;

use App\Models\HeadTeacher;
use Illuminate\Http\Request;

class HeadTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = HeadTeacher::select('head_teachers.*', 'users.lastname', 'users.firstname', 'users.position')
        ->join('users', 'head_teachers.user_id', '=', 'users.id')
        ->where('head_teachers.user_id', auth()->user()->id)
        ->get();
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = HeadTeacher::where('user_id', auth()->user()->id)->first();

        if($data){
            if($request->hasFile('image')){
                $file = $request->file('image')->store('media', 'public');
                $data->image = $file;
            }

            $data->save();
        }else{
            $request->validate([
                'image' => 'required|image|mimes:png,jpg,webp',
            ]);

            if($request->hasFile('image')){
                $file = $request->file('image')->store('media', 'public');
            }
            HeadTeacher::create([
                'user_id' => auth()->user()->id,
                'image' => $file
            ]);
        }
        // return response($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HeadTeacher $teacher)
    {
        return response($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HeadTeacher $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeadTeacher $teacher)
    {
        $teacher->delete();
    }
}
