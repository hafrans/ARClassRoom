<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SImage extends Model
{
    //

    protected $table = "ar_s_images";

    protected $primaryKey = "id";

    protected $dateFormat = "Y-m-d H:i:s";

    protected $fillable = [
        "name","path","serial_id","meta"
    ];

    public function courseItem(){
        return $this->belongsTo("App\CourseItem", "course_item_id");
    }
}
