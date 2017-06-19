<?php namespace Octobro\Notify\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('octobro_notify_templates', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->text('properties')->nullable();
            $table->string('link_page')->nullable();
            $table->text('link_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('octobro_notify_templates');
    }
}