<?php

namespace App\Interfaces;

interface ajaxDataEditor
{
    public static function addData($data);
    public static function delData($data);
    public static function updateData($data);
}
