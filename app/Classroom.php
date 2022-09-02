<?php

namespace App;

use App\Abstracts\KindergartenService,
    App\Kid;


class Classroom extends KindergartenService
{
    public static $notificateMessage = [
        'add'=>'Услуга добавлена',
        'delete'=>'Информация об улсуге удалена',
        'update'=>'Информация об улсуге изменена',
    ];

    public static function addData($data) {
        $obj = self::addClassroom(['classroom' => $data['name'],'desc' => $data['desc']]);
        $obj->classrooms()->attach($data['classrooms']);
    }
    public static function delData($data) {

    }
    public static function updateData($data) {

    }

    public function kids() {
        return $this->belongsToMany(Kid::class);
    }
    public static function addClassroom($attr) {
        return Classroom::create($attr);
    }
    public static function filterList($filter = null, $view) {
        $classrooms = self::latest('created_at')->where('deleted', 0);

        $page = 1;
        if(isset($filter['page']))
            $page = $filter['page'];

        $limit = $page*config('app.limit_on_longlist');

        if(isset($filter['metaData']['count-on-page']))
            $limit = $page*$filter['metaData']['count-on-page'];

        return view($view, ['payments' => $classrooms->limit($limit)->get()])->render();
    }
}
