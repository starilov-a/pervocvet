<?php

namespace App\Http\Controllers;


use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

use App\Classroom;
use App\Kid;


class KidController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
        parse_str($request->getContent(), $data);

        $validator = Validator::make($data, [
            'name' => 'required',
            'desc' => 'required',
            'classrooms' => 'required'
        ],['required' => 'Необходимо указать поле :attribute']);

        if(!empty($validator->getMessageBag()->getMessages()))
            return json_encode($validator->getMessageBag()->getMessages());

        $kid = Kid::addKid(['name' => $data['name'],'desc' => $data['desc']]);
        $kid->classrooms()->attach($data['classrooms']);

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kid  $kid
     * @return \Illuminate\Http\Response
     */
    public function show(Kid $kid)
    {
        $data['classrooms'] = $kid->classrooms;
        $data['name'] = $kid->name;
        $data['desc'] = $kid->desc;

        return $data;
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kid  $kid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kid $kid)
    {

    }
}
