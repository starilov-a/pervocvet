<?php

namespace App\Http\Controllers;

use App\Abstracts\KindergartenService;
use Illuminate\Auth\Events\Validated;

use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Kid;
use App\Payment;

abstract class AjaxController extends Controller
{
    //TODO сделать выбор нужного роута в JS и каждый контроллер сам выполняет действия. После этого данный контроллер будет не нужен

    public function storeAjax ($serviceObj, Request $request) {
        parse_str($request->getContent(), $data);
        if(!empty($errorMessage = $serviceObj::validateForAjax($data)))
            return ['status' => false,'errors'=>$errorMessage];

        $serviceObj->createAjax($data);

        return ['status' => true, 'notificateMessage' => $serviceObj::$notificateMessage['add']];
    }

    public function updateAjax (KindergartenService $serviceObj, Request $request) {
        parse_str($request->getContent(), $data);

        if(!empty($errorMessage = $serviceObj::validateForAjax($data)))
            return ['status' => false,'errors'=>$errorMessage];

        $serviceObj->updateAjax($data);

        return ['status' => true, 'notificateMessage' => $serviceObj::$notificateMessage['update']];
    }

    public function destroyAjax (KindergartenService $serviceObj, Request $request) {
        parse_str($request->getContent(), $data);

        $serviceObj->delete();
        return ['status' => true, 'notificateMessage' => $serviceObj::$notificateMessage['delete']];
    }

    public function getList ($serviceObj, Request $request) {
        parse_str($request->getContent(), $data);

        $html = $serviceObj::filterList($data['filter'], static::$viewLists[$data['filter']['metaData']['data-list']]);

        return ['status' => true, 'html' => $html, 'list' => $data['filter']['metaData']['data-list']];
    }

    protected function isAjax(Request $request) {
        return $request->isJson();
    }

}
