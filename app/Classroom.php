<?php

namespace App;

use App\Abstracts\KindergartenService,
    App\Kid;


class Classroom extends KindergartenService
{
    protected $fillable = ['classroom','desc','deleted'];

    public static $notificateMessage = [
        'add'=>'Услуга добавлена',
        'delete'=>'Информация об улсуге удалена',
        'update'=>'Информация об улсуге изменена',
    ];

    //AJAX
    public static function addData($data) {
        self::addClassroom(['classroom' => $data['classroom'],'desc' => $data['desc']]);
    }
    public static function updateData($data) {
        $kid = self::find($data['metaData']['data-id-item']);
        $kid->update([
            'classroom' => $data['classroom'],
            'desc' => $data['desc']
        ]);
    }
    public static function delData($data) {
        self::find($data['metaData']['data-id-item'])->delete();
    }
    //

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

        return view($view, ['classrooms' => $classrooms->limit($limit)->get()])->render();
    }

    public function delete() {
        $this->update([
            'deleted' => 1
        ]);
    }
}
