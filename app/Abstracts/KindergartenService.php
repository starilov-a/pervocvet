<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model,
    App\Interfaces;

abstract class KindergartenService extends Model implements Interfaces\ajaxDataEditor
{
    public static $notificateMessage;
    abstract public function filterList($filter = null, $view);
}
