<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Kid;
use App\Classroom;


class Payment extends Model
{

    protected $fillable = ['payment','desc', 'kid_id', 'classroom_id'];

    public function kid() {
        return $this->belongsTo(Kid::class);
    }
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
    public static function addPayment($attr) {
        return Payment::create($attr);
    }
}
