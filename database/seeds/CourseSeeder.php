<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Course;
class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Course::class, 10)->create()->each(function(Course $course){
            $course->courseItems()->save(factory(\App\CourseItem::class)->make());
            $course->courseItems()->save(factory(\App\CourseItem::class)->make());
            $course->courseItems()->save(factory(\App\CourseItem::class)->make());
        });

    }
}
