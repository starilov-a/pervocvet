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
    //TODO
    public function validateAjaxData($serviceObj, $request) {
        parse_str($request->getContent(), $data);
        if(!empty($errorMessage = $serviceObj::validateForAjax($data)))
            return [false, ['status' => false,'errors'=>$errorMessage]];
        return [true, $data];
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
