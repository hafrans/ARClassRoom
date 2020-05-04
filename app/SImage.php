<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SImage extends Model
{
    //

    protected $table = "ar_s_images";

    protected $primaryKey = "id";

    public function courseItem(){
        return $this->hasOne("App\CourseItem", "course_item_id");
    }
}
