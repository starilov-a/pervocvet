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

    protected $fillable = ['payment','desc', 'kid_id', 'classroom_id', 'deleted'];

    //AJAX
    public static function addData($data) {
        //FIXIT убрать unset
        unset($data['metaData']);
        $data = array_diff($data, array(''));
        self::addPayment($data);
    }
    public static function updateData($data) {
        $payment = self::find($data['metaData']['data-id-item']);
        //FIXIT убрать unset
        unset($data['metaData']);
        $data = array_diff($data, array(''));
        $payment->update($data);
    }
    public static function delData($data) {
        self::find($data['metaData']['data-id-item'])->delete();;
    }
    //


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
}
