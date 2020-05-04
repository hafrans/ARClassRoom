<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $primaryKey = "id";
    protected $table  = "ar_courses";

    protected $fillable = [
      'name', "description"
    ];

    public function courseItems(){
        return $this->hasMany('App\CourseItem',"course_id");
    }

}
