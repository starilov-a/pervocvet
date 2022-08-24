<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classroom;
use App\Payment;

class Kid extends Model
{
    protected $fillable = ['name','desc','deleted'];

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

    public function delete() {
        $this->update([
            'deleted' => 1
        ]);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public static function filterList($filter = null, $view) {
        $kids = self::latest('created_at')->where('deleted', 0);

        if (isset($filter['classroom']) && $filter['classroom'] > 0)
            $kids = $kids->whereHas('classrooms', function ($query) use($filter) {
                $query->where('id', '=', $filter['classroom']);
            });

        $page = 1;
        if(isset($filter['page']))
            $page = $filter['page'];

        $kids = $kids->limit($page*config('app.limit_on_longlist'))->get();

        return view($view, ['kids' => $kids])->render();
    }

}
