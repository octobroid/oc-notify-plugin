<?php namespace Octobro\Notify\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('octobro_notify_notifications', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('recipient_id')->unsigned();
            $table->integer('from_id')->unsigned()->nullable();
            $table->string('from_type')->nullable();
            $table->integer('related_id')->unsigned()->nullable();
            $table->string('related_type')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->string('template_code')->nullable();
            $table->json('data')->nullable();
            $table->string('link_url')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('octobro_notify_notifications');
    }
}
