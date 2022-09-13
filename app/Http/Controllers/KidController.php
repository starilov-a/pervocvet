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
        if($this->isAjax($request)) {
            list($validate, $data) = $this->validateAjaxData(Kid::class, $request);
            if(!$validate)
                return $data;

            $kid = Kid::create(['name' => $data['name'],'desc' => $data['desc'], 'birthday' => $data['birthday'], 'parents' => $data['parents']]);

            $parentsAttr = false;
            if(isset($data['nameParent']) && $data['numberParent'])
                foreach ($data['nameParent'] as $key => $name)
                    if (!empty($name) || !empty($data['numberParent'][$key]))
                        $parentsAttr[] = ['name' => $name, 'number' => (!empty($data['numberParent'][$key])) ? $data['numberParent'][$key] : null];

            if($parentsAttr)
                $kid->parents()->createMany($parentsAttr);
            $kid->classrooms()->attach($data['classrooms']);

            return ['status' => true, 'notificateMessage' => $kid::$notificateMessage['add']];
        }

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
                $data['birthday'] = $kid->birthday;
                $data['parents'] = $kid->parents;
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
        if($this->isAjax($request)) {
            list($validate, $data) = $this->validateAjaxData($kid, $request);
            if(!$validate)
                return $data;

            if(isset($data['nameParent']) && $data['numberParent'])
                foreach ($data['nameParent'] as $key => $name)
                    $parents[]= ['name' => $name, 'number' => (!empty($data['numberParent'][$key])) ? $data['numberParent'][$key] : null];

            $kid->update([
                'name' => $data['name'],
                'desc' => $data['desc'],
                'birthday' => $data['birthday'],
                'parents' => $data['parents']
            ]);
            $kid->updateClassrooms($data['classrooms']);

            return ['status' => true, 'notificateMessage' => $kid::$notificateMessage['update']];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kid  $kid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kid $kid, Request $request)
    {
        if($this->isAjax($request)) {
            $kid->delete();
            return ['status' => true, 'notificateMessage' => $kid::$notificateMessage['delete']];
        }

    }

    public function list(Request $request) {
        if($this->isAjax($request))
            return $this->getList(new Kid, $request);
    }
}
