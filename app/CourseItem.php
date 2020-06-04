<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseItem extends Model
{
    //
    protected $table = "ar_course_items";

    protected $primaryKey = "id";

    protected $dateFormat = "Y-m-d H:i:s";


    protected $fillable = [
        "name",
        "course_id",
        "content",
        "video_path",
        "audio_path",
        "graph_path",
        "model_path",
    ];


    public function simages(){
        return $this->hasMany("App\SImage","course_item_id");
    }

    public function course(){
        return $this->belongsTo("App\Course","course_id");
    }

}
