<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('form_config')) {
            Schema::create('form_config', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('form_config_id');
                $table->integer('version');
                $table->string('config');
                $table->boolean('is_active');
                $table->bigInteger('form_id')->unsigned();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
            Schema::table('form_config',function (Blueprint $table) {
                $table->foreign('form_id')
                    ->references('form_id')
                    ->on('forms')
                    ->onDelete('cascade');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_config');
    }
}
