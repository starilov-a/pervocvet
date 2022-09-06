<?php

namespace App;

use App\Abstracts\KindergartenService,
    App\Kid,
    App\Classroom;


class Payment extends KindergartenService
{
    public static $notificateMessage = [
        'add'=>'Оплата добавлена',
        'delete'=>'Информация об оплате удалена',
        'update'=>'Информация об оплате изменена',
    ];

    public static $requiredFields = [
        'kid_id' => 'required',
        'classroom_id' => 'required',
        'payment' => 'required',
    ];

    protected $fillable = ['payment','desc', 'kid_id', 'classroom_id', 'deleted'];

    public function kid() {
        return $this->belongsTo(Kid::class);
    }
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
    public static function addPayment($attr) {
        return Payment::create($attr);
    }
    public function delete() {
        $this->update([
            'deleted' => 1
        ]);
    }

    public static function filterList($filter = null, $view) {
        $payments = self::latest('created_at')->where('deleted', 0);

        $page = 1;
        if(isset($filter['page']))
            $page = $filter['page'];

        $limit = $page*config('app.limit_on_longlist');

        if (isset($filter['dateRange']) && !empty($filter['dateRange'])) {
            $dateRange = explode('|', $filter['dateRange']);
            $payments = $payments->where('created_at', '>=', $dateRange[0])->where('created_at', '<=', $dateRange[1]);
        }

        if(isset($filter['metaData']['count-on-page']))
            $limit = $page*$filter['metaData']['count-on-page'];

        if(isset($filter['classroom']))
            $payments = $payments->where('classroom_id', $filter['classroom']);

        if(isset($filter['kid']))
            $payments = $payments->where('kid_id', $filter['kid']);

        return view($view, ['payments' => $payments->limit($limit)->get()])->render();
    }

    public function updateAjax($data){
        unset($data['metaData']);
        $data = array_diff($data, array(''));
        $this->update($data);
    }
    public function createAjax($data){
        unset($data['metaData']);
        $data = array_diff($data, array(''));
        $this->create($data);
    }
}
