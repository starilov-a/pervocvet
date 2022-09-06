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
        'update'=>'Информация об улсуге изменена'
    ];
    public static $requiredFields = [
        'classroom' => 'required'
    ];

    public static function filterList($filter = null, $view) {
        $classrooms = self::latest('created_at')->where('deleted', 0);

        $page = 1;

        if(isset($filter['page']) && (int)$filter['page'] > 0)
            $page = $filter['page'];

        $limit = $page*config('app.limit_on_longlist');

        if(isset($filter['metaData']['count-on-page']))
            $limit = $page*$filter['metaData']['count-on-page'];

        return view($view, ['classrooms' => $classrooms->limit($limit)->get()])->render();
    }

    public function kids() {
        return $this->belongsToMany(Kid::class);
    }

    public function updateAjax($data){
        $this->update([
            'classroom' => $data['classroom'],
            'desc' => $data['desc']
        ]);
    }
    public function createAjax($data){
        $this->create(['classroom' => $data['classroom'],'desc' => $data['desc']]);
    }
}
