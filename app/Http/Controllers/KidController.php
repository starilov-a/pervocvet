<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request,
    App\Http\Controllers\AjaxController,
    App\Classroom,
    App\Kid;

class KidController extends AjaxController
{
    protected static $viewLists = [
        'list-kid' => 'kid.kidsList'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kid.index', [
            'classrooms' => Classroom::latest('created_at')->where('deleted', 0)->get(),
            'kids' => Kid::latest('created_at')->where('deleted', 0)->limit(config('app.limit_on_longlist'))->get()]);
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
            return $this->storeAjax(new Kid, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kid  $kid
     * @return \Illuminate\Http\Response
     */
    public function show(Kid $kid, Request $request)
    {
        if($this->isAjax($request))
            if ($this->isAjax($request)) {
                $data['classrooms'] = $kid->classrooms;
                $data['name'] = $kid->name;
                $data['desc'] = $kid->desc;

                return $data;
            }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kid  $kid
     * @return \Illuminate\Http\Response
     */
    public function edit(Kid $kid, Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kid  $kid
     * @return \Illuminate\Http\Response
     */
    public function update(Kid $kid, Request $request)
    {
        if($this->isAjax($request))
            return $this->updateAjax($kid, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kid  $kid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kid $kid, Request $request)
    {
        if($this->isAjax($request))
            return $this->destroyAjax($kid, $request);
    }

    public function list(Request $request) {
        if($this->isAjax($request))
            return $this->getList(new Kid, $request);
    }
}
