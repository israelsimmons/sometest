<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email']);
        });

        Schema::create('user_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('email', 150)->unique();
            $table->boolean('is_default')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });

        Schema::create('share_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name', 150);
            $table->string('instrument_name', 150);
            $table->integer('quantity')->default(1);
            $table->decimal('price', 18, 10)->default(0);
            $table->decimal('total_investment', 18, 10);
            $table->string('certificate_number', 80);
            $table->datetime('transaction_date');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_emails');
        Schema::dropIfExists('share_purchases');
    }
}
