<?php namespace Klubitus\Venue\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateVenuesTable extends Migration {

    public function up() {
        Schema::create('venues', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->integer('author_id')->references('id')->on('users');

            $table->string('name');
            $table->string('url')->nullable();
            $table->string('description')->nullable();
            $table->text('info')->nullable();

            $table->string('address')->nullable();
            $table->string('city_name')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->string('foursquare_id', 32)->nullable()->unique();
            $table->string('foursquare_category_id', 32)->nullable();
            $table->bigInteger('facebook_id')->nullable()->unique();
        });
    }


    public function down() {
        //Schema::dropIfExists('klubitus_venue_venues');
    }

}
