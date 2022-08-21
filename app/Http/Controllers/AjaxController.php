<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;

use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Kid;
use App\Payment;

class AjaxController extends Controller
{
    //Проблемы с защитой, тк в js могу поменять kid на payment (Например)
    private $validateFields = [
        'payment' => [
            'kid_id' => 'required',
            'classroom_id' => 'required',
            'payment' => 'required',
            ],
        'kid' => [
            'name' => 'required',
            'classrooms' => 'required',
            'desc' => 'required'
            ]
    ];

    public function store (Request $request) {
        parse_str($request->getContent(), $data);

        $validator = Validator::make($data, $this->validateFields[$data['class']],['required' => 'Необходимо указать поле :attribute']);
        if(!empty($validator->getMessageBag()->getMessages()))
            return json_encode($validator->getMessageBag()->getMessages());

        $this->addData($data);

        return true;
    }

    private function addData($data) {
        if ($data['class'] == 'kid') {
            $obj = Kid::addKid(['name' => $data['name'],'desc' => $data['desc']]);
            $obj->classrooms()->attach($data['classrooms']);
        }
        if ($data['class'] == 'payment') {
            $data = array_diff($data, array(''));
            unset($data['class']);
            Payment::addPayment($data);
        }
    }

}
