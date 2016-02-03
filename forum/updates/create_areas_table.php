<?php namespace Klubitus\Forum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAreasTable extends Migration {

    public function up() {
        Schema::create('forum_areas', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();

            $table->integer('parent_id')->index()->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();

            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('topic_count')->default(0);
            $table->integer('post_count')->default(0);

            $table->boolean('is_hidden')->default(0);
            $table->boolean('is_moderated')->default(0);
            $table->boolean('is_private')->default(0);
        });
    }

    public function down() {
//        Schema::dropIfExists('forum_areas');
    }

}
