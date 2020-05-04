<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseItem extends Model
{
    //
    protected $table = "ar_course_items";

    protected $primaryKey = "id";


    public function simages(){
        return $this->hasMany("App\SImage","course_item_id");
    }

}
