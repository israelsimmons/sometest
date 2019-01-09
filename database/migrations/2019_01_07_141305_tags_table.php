<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('description', 40);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });

        Schema::create('share_purchase_tag', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->integer('share_purchase_id')->unsigned();
            $table->timestamps();

            $table->foreign('tag_id')
                  ->references('id')
                  ->on('tags');

            $table->foreign('share_purchase_id')
                ->references('id')
                ->on('share_purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_purchase_tag');
        Schema::dropIfExists('tags');
    }
}
