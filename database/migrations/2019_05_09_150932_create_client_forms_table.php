<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('client_forms')) {
            Schema::create('client_forms', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('client_forms_id');
                $table->integer('client_id');
                $table->bigInteger('form_id')->unsigned();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
            Schema::table('client_forms',function (Blueprint $table) {
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
        Schema::dropIfExists('client_forms');
    }
}
