<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseItem extends Model
{
    //
    protected $table = "ar_course_items";

    protected $primaryKey = "id";

    protected $dateFormat = "Y-m-d H:i:s";


    public function simages(){
        return $this->hasMany("App\SImage","course_item_id");
    }

}
