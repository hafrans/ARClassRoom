<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_course_items', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name",255);
            $table->text("video_path")->nullable(true);
            $table->text("audio_path")->nullable(true);
            $table->text("model_path")->nullable(true);
            $table->text("content")->nullable(true);
            $table->unsignedBigInteger("course_id");
            $table->timestamps();

            $table->foreign("course_id","fk_courses")->references("id")->on("ar_courses")
                  ->onDelete("cascade")->onUpdate("cascade");
            $table->engine = "InnoDB";
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_unicode_ci";

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_course_items');
    }
}
