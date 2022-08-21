<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classroom;
use App\Payment;

class Kid extends Model
{
    protected $fillable = ['name','desc'];

    public static function addKid($attr) {
        return Kid::create($attr);
    }

    public function classrooms() {
        return $this->belongsToMany(Classroom::class);
    }

    public function updateClassrooms($newClassrooms) {
        $newClassrooms = collect($newClassrooms)->keyBy(function ($item) {return $item;});
        $oldClassrooms = $this->classrooms->keyBy('id');
        $this->classrooms()->attach($newClassrooms->diffKeys($oldClassrooms));
        $this->classrooms()->detach($oldClassrooms->diffKeys($newClassrooms));
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public static function filterList($filter = null) {
        $kids = self::latest('created_at');

        if (isset($filter['classroom']) && $filter['classroom'] > 0) {
            $kids = $kids->whereHas('classrooms', function ($query) use($filter) {
                $query->where('id', '=', $filter['classroom']);
            });
        }

        $page = 100;
        if(isset($filter['page'])) {
            $page = $filter['page'];
        }

        //Добавить константу лимита
        return $kids->limit($page*8)->get();
    }

}
