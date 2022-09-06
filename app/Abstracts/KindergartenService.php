<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model,
    App\Interfaces;
use Illuminate\Support\Facades\Validator;

abstract class KindergartenService extends Model
{
    public static $notificateMessage;
    public static $requiredFields;

    abstract static public function filterList($filter = null, $view);

    protected static function validateForAjax($data) {
        return Validator::make($data, static::$requiredFields,['required' => 'Необходимо указать поле :attribute'])->getMessageBag()->getMessages();
    }
    abstract protected function updateAjax($data);
    abstract protected function createAjax($data);
}
