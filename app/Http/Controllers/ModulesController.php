<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests\ModuleRequest;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Module::simplePaginate(10);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function meModules($courseId)
    {
        return Module::where('course_id', $courseId)->simplePaginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleRequest $request, $courseId)
    {
        $request['course_id'] = $courseId;
        return response()->json(Module::create($request->all()),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $id
     * @return \Illuminate\Http\Response
     */
    public function show($courseId, Module $id )
    {
        $module = Module::all()->where('course_id', $courseId)->find($id);
        $module->course;
        return $module;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $id
     * @return \Illuminate\Http\Response
     */
    public function update($courseId,Request $request, Module $id)
    {
        $module = Module::all()->where('course_id', $courseId)->find($id);

        if (!empty($module)) {
            $module->update($request->all());
            return response()->json($module, 200);
        }
        return response()->json(['erro' => 'Module not found' ], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($courseId,Module $id)
    {
        Module::all()->where('course_id', $courseId)->find($id)->delete();
        return response()->json( ['message' => 'Module remove success' ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $id
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function restore($courseId,$id)
    {
        $module = Module::onlyTrashed()->where('course_id', $courseId)->find($id);
        if (!empty($module)) {
            $module->restore();
            return response()->json($module, 200);
        }
        return response()->json(['erro' => 'Module not found' ], 204);
    }
    
    /**
     * Display deleted a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchDeletedModules($courseId)
    {
        return Module::onlyTrashed()->where('course_id', $courseId)->simplePaginate(10);
    }
}
