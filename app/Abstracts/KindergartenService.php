<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model,
    App\Interfaces;

abstract class KindergartenService extends Model implements Interfaces\ajaxDataEditor
{
    public static $notificateMessage;
    abstract public static function filterList($filter = null, $view);
}
