<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Http\Controllers\AjaxController,
    App\Classroom;

class ClassroomController extends AjaxController
{

    protected static $viewLists = [
        'list-classroom' => 'classroom.classroomsList'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('classroom.index', ['classrooms' => Classroom::latest('created_at')->where('deleted', 0)->limit(config('app.limit_on_longlist'))->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->isAjax($request))
            return $this->storeAjax(new Classroom, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom,Request $request)
    {
<<<<<<< HEAD
        if($this->isAjax($request)) {
            $data['classroom'] = $classroom->classroom;
            $data['desc'] = $classroom->desc;

            return $data;
        }
=======
        $data['classroom'] = $classroom->classroom;
        $data['desc'] = $classroom->desc;

        return $data;
>>>>>>> develop-ajax
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Classroom $classroom, Request $request)
    {
        if($this->isAjax($request))
            return $this->updateAjax($classroom, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom, Request $request)
    {
        if($this->isAjax($request))
            return $this->destroyAjax($classroom, $request);
    }

    public function list(Request $request) {
        if($this->isAjax($request))
            return $this->getList(new Classroom, $request);
    }
}
