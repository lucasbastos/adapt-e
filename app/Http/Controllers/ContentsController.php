<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Requests\ContentRequest;

class ContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($courseId, $moduleId)
    {
        return Content::where('module_id', $moduleId)->simplePaginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($courseId, $moduleId,ContentRequest $request)
    {
        $request['module_id'] = $moduleId;
        return response()->json(Content::create($request->all()),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show($courseId, $moduleId, Content $id)
    {
        $content = Content::all()->where('module_id', $moduleId)->find($id);
        $content->module;
        return $content;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update($courseId,$moduleId,Request $request, Content $id)
    {
        $content = Content::all()->where('module_id', $moduleId)->find($id);

        if (!empty($content)) {
            $content->update($request->all());
            return response()->json($content, 200);
        }
        return response()->json(['erro' => 'Content not found' ], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy($courseId,$moduleId,Content $id)
    {
        Content::all()->where('module_id', $moduleId)->find($id)->delete();
        return response()->json( ['message' => 'Content remove success' ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $id
     * @param  \App\Models\Content  $module
     * @return \Illuminate\Http\Response
     */
    public function restore($courseId,$moduleId,$id)
    {
        $content = Content::onlyTrashed()->where('module_id', $moduleId)->find($id);
        if (!empty($content)) {
            $content->restore();
            return response()->json($content, 200);
        }
        return response()->json(['erro' => 'Module not found' ], 204);
    }

    /**
     * Display deleted a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchDeletedContents($courseId, $moduleId)
    {
        return Content::onlyTrashed()->where('module_id', $moduleId)->simplePaginate(10);
    }
}
