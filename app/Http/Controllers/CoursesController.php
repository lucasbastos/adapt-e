<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests\CourseRequest;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Course::simplePaginate(10);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function meCourses()
    {
        return Course::where('user_id', Auth::user()->id)->simplePaginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        return response()->json(Course::create($request->all()),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $id)
    {
        $course = Course::all()->find($id);
        $course->user;
        $course->modules;
        return $course;
    }
    //teste

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $id)
    {
        $course = Course::all()->find($id);
        $course->update($request->all());
        return $course;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $id)
    {
        $course = Course::all()->where('user_id', Auth::user()->id)->find($id);
        $modules = Module::all()->where('course_id', $id->id);

        foreach ($modules as $key => $module) {
            $module->delete();
        }

        $course->delete();
        return response()->json([ 'message' => 'Course deleted' ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $id
     * @param  \App\Models\Course  $module
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $course = Course::onlyTrashed()->where('user_id', Auth::user()->id)->find($id);
        if (!empty($course)) {
            $modules = Module::onlyTrashed()->where('course_id', 1)->get();

            foreach ($modules as $key => $module) {
                $module->restore();
            }

            $course->restore();
            $course->modules;
            return response()->json(['message' => 'Course restored' , 'course' => $course] , 200);
        }
        return response()->json(['erro' => 'Course not found' ], 204);
    }

    /**
     * Display deleted a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchDeletedCourses()
    {
        return Course::onlyTrashed()->where('user_id', Auth::user()->id)->simplePaginate(10);
    }
}
