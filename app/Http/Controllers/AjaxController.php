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
    //FIXIT сделать выбор нужного роута в JS и каждый контроллер сам выполняет действия. После этого данный контроллер будет не нужен
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
            ],
        'classroom' => [
            'classroom' => 'required'
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
        'list-classroom' => 'classroom.kidsList',
    ];

    public function store (Request $request) {
        parse_str($request->getContent(), $data);

        $validator = Validator::make($data, $this->validateFields[$data['metaData']['data-class']],['required' => 'Необходимо указать поле :attribute']);
        if(!empty($validator->getMessageBag()->getMessages()))
            return json_encode($validator->getMessageBag()->getMessages());

        $this->modelClass[$data['metaData']['data-class']]::addData($data);

        return ['success' => true, 'notificateMessage' => $this->modelClass[$data['metaData']['data-class']]::$notificateMessage['add']];
    }

    public function update (Request $request) {
        parse_str($request->getContent(), $data);

        $validator = Validator::make($data, $this->validateFields[$data['metaData']['data-class']],['required' => 'Необходимо указать поле :attribute']);
        if(!empty($validator->getMessageBag()->getMessages()))
            return json_encode($validator->getMessageBag()->getMessages());

        $this->updateData($data);

        return ['success' => true, 'notificateMessage' => $this->modelClass[$data['metaData']['data-class']]::$notificateMessage['update']];
    }

    public function destroy(Request $request) {
        parse_str($request->getContent(), $data);

        $this->modelClass[$data['metaData']['data-class']]::find($data['metaData']['data-id-item'])->delete();
        return ['success' => true, 'notificateMessage' => $this->modelClass[$data['metaData']['data-class']]::$notificateMessage['delete']];
    }

    private function updateData ($data) {
        if ($data['metaData']['data-class'] == 'kid') {

        }
        if ($data['metaData']['data-class'] == 'payment') {
            $payment = Payment::find($data['metaData']['data-id-item']);
            unset($data['metaData']);
            $data = array_diff($data, array(''));
            $payment->update($data);
        }
        if ($data['metaData']['data-class'] == 'classroom') {
            $kid = Kid::find($data['metaData']['data-id-item']);
            $kid->update([
                'name' => $data['name'],
                'desc' => $data['desc']
            ]);
            $kid->updateClassrooms($data['classrooms']);
        }
    }

    public function list (Request $request) {
        parse_str($request->getContent(), $data);

        $html = $this->modelClass[$data['filter']['metaData']['data-class']]::filterList($data['filter'], $this->viewLists[$data['filter']['metaData']['data-list']]);

        return ['success' => true, 'html' => $html, 'list' => $data['filter']['metaData']['data-list']];
    }

}
