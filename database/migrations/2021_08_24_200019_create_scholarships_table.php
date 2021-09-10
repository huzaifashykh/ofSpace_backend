<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("thumbnail");
            $table->unsignedSmallInteger("country_id");
            $table->unsignedTinyInteger("category_id");
            $table->unsignedBigInteger("created_by");
            $table->timestamp("deadline");
            $table->timestamps();
        });

        Schema::table("scholarships", function (Blueprint $table) {
            $table->foreign("country_id")->references("id")->on("countries");
            $table->foreign("category_id")->references("id")->on("categories");
            $table->foreign("created_by")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scholarships');
    }
}
