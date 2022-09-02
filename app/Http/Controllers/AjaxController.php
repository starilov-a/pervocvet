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
        'kid' => 'App\\Kid',
        'classroom' => 'App\\Classroom'
    ];

    private $viewLists = [
        'list-kid' => 'kid.kidsList',
        'list-payment' => 'payment.paymentsList',
        'list-payment-classrooms' => 'payment.byClassroomsList',
        'list-payment-kids' => 'payment.byKidsList',
        'list-classroom' => 'classroom.classroomsList',
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

        $this->modelClass[$data['metaData']['data-class']]::updateData($data);

        return ['success' => true, 'notificateMessage' => $this->modelClass[$data['metaData']['data-class']]::$notificateMessage['update']];
    }

    public function destroy(Request $request) {
        parse_str($request->getContent(), $data);
        $this->modelClass[$data['metaData']['data-class']]::delData($data);

        return ['success' => true, 'notificateMessage' => $this->modelClass[$data['metaData']['data-class']]::$notificateMessage['delete']];
    }

    public function list (Request $request) {
        parse_str($request->getContent(), $data);

        $html = $this->modelClass[$data['filter']['metaData']['data-class']]::filterList($data['filter'], $this->viewLists[$data['filter']['metaData']['data-list']]);

        return ['success' => true, 'html' => $html, 'list' => $data['filter']['metaData']['data-list']];
    }

}
