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

    private $modelClass = [
        'payment' => 'App\\Payment',
        'kid' => 'App\\Kid'
    ];

    private $viewLists = [
        'list-kid' => 'kid.kidsList',
        'list-payment' => 'payment.paymentsList',
        'list-payment-classrooms' => 'payment.byClassroomsList',
        'list-payment-kids' => 'payment.byKidsList',
    ];

    public function store (Request $request) {
        parse_str($request->getContent(), $data);

        $validator = Validator::make($data, $this->validateFields[$data['metaData']['data-class']],['required' => 'Необходимо указать поле :attribute']);
        if(!empty($validator->getMessageBag()->getMessages()))
            return json_encode($validator->getMessageBag()->getMessages());

        $this->addData($data);

        return true;
    }

    public function update (Request $request) {
        parse_str($request->getContent(), $data);

        $validator = Validator::make($data, $this->validateFields[$data['metaData']['data-class']],['required' => 'Необходимо указать поле :attribute']);
        if(!empty($validator->getMessageBag()->getMessages()))
            return json_encode($validator->getMessageBag()->getMessages());

        $this->updateData($data);

        return true;
    }

    public function destroy(Request $request) {
        parse_str($request->getContent(), $data);

        $this->modelClass[$data['metaData']['data-class']]::find($data['metaData']['data-id-item'])->delete();
        return 1;
    }

    private function addData ($data) {
        if ($data['metaData']['data-class'] == 'kid') {
            $obj = Kid::addKid(['name' => $data['name'],'desc' => $data['desc']]);
            $obj->classrooms()->attach($data['classrooms']);
        }
        if ($data['metaData']['data-class'] == 'payment') {
            unset($data['metaData']);
            $data = array_diff($data, array(''));
            Payment::addPayment($data);
        }
    }

    private function updateData ($data) {
        if ($data['metaData']['data-class'] == 'kid') {
            $kid = Kid::find($data['metaData']['data-id-item']);
            $kid->update([
                'name' => $data['name'],
                'desc' => $data['desc']
            ]);
            $kid->updateClassrooms($data['classrooms']);
        }
        if ($data['metaData']['data-class'] == 'payment') {
            $payment = Payment::find($data['metaData']['data-id-item']);
            unset($data['metaData']);
            $data = array_diff($data, array(''));
            $payment->update($data);
        }
    }

    public function list (Request $request) {
        parse_str($request->getContent(), $data);

        $html = $this->modelClass[$data['filter']['metaData']['data-class']]::filterList($data['filter'], $this->viewLists[$data['filter']['metaData']['data-list']]);

        return ['success' => true, 'html' => $html, 'list' => $data['filter']['metaData']['data-list']];
    }

}
