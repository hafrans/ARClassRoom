<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_s_images', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->text("path");
            $table->string("serial_id",255);
            $table->string("meta",255);
            $table->unsignedBigInteger("course_item_id");
            $table->timestamps();

            $table->foreign("course_item_id")->references("id")->on("ar_course_items")
                  ->onUpdate("cascade")->onDelete("cascade");

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
        Schema::dropIfExists('ar_s_images');
    }
}
