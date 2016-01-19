<?php namespace Klubitus\BBCode\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateEmoticonsTable extends Migration {

    public function up() {
        Schema::create('emoticons', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->jsonb('notation');
            $table->boolean('is_secret')->default(false);
        });
    }


    public function down() {
        Schema::dropIfExists('emoticons');
    }

}
