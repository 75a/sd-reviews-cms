<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewReviewAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_reviewattribute', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('review_attribute_id');
            $table->text("contents")->nullable();
            $table->timestamps();

            $table->foreign("review_id")
                ->references("id")
                ->on("reviews")
                ->onDelete('cascade');
            $table->foreign("review_attribute_id")
                ->references("id")
                ->on("review_attributes")
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_reviewattribute');
    }
}
