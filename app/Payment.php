<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Kid;
use App\Classroom;


class Payment extends Model
{

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

    public static function filterList($filter = null) {
        $payments = self::latest('created_at')->where('deleted', 0);

        $page = 1;
        if(isset($filter['page'])) {
            $page = $filter['page'];
        }

        return view('payment.paymentsList', ['payments' => $payments->limit($page*config('app.limit_on_longlist'))->get()])->render();
    }
}
