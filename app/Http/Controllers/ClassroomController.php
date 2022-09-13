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
        if($this->isAjax($request)) {
            list($validate, $data) = $this->validateAjaxData(Classroom::class, $request);
            if(!$validate)
                return $data;

            $classroom = Classroom::create([
                'classroom' => $data['classroom'],
                'price_day' => $data['price_day'],
                'price_month' => $data['price_month'],
                'price_discount' => $data['price_discount'],
                'count_visits' => $data['count_visits'],
                'desc' => $data['desc']
            ]);

            return ['status' => true, 'notificateMessage' => $classroom::$notificateMessage['add']];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom,Request $request)
    {
        if($this->isAjax($request)) {
            $data['classroom'] = $classroom->classroom;
            $data['price_day'] = $classroom->price_day;
            $data['price_month'] = $classroom->price_month;
            $data['price_discount'] = $classroom->price_discount;
            $data['count_visits'] = $classroom->count_visits;
            $data['desc'] = $classroom->desc;

            return $data;
        }
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
        if($this->isAjax($request)) {
            list($validate, $data) = $this->validateAjaxData($classroom, $request);
            if(!$validate)
                return $data;

            $classroom->update([
                'classroom' => $data['classroom'],
                'price_day' => $data['price_day'],
                'price_month' => $data['price_month'],
                'price_discount' => $data['price_discount'],
                'count_visits' => $data['count_visits'],
                'desc' => $data['desc']
            ]);

            return ['status' => true, 'notificateMessage' => $classroom::$notificateMessage['update']];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom, Request $request)
    {
        if($this->isAjax($request)) {
            $classroom->delete();
            return ['status' => true, 'notificateMessage' => $classroom::$notificateMessage['delete']];
        }
    }

    public function list(Request $request) {
        if($this->isAjax($request))
            return $this->getList(new Classroom, $request);
    }
}
