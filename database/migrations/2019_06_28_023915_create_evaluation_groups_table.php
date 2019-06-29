<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('appraiser1_FK')->unsigned();;
            $table->foreign('appraiser1_FK')->references('id')->on('profiles');
            $table->bigInteger('advisor_FK')->unsigned();;
            $table->foreign('advisor_FK')->references('id')->on('profiles');
            $table->bigInteger('appraiser2_FK')->unsigned();;
            $table->foreign('appraiser2_FK')->references('id')->on('profiles');
            $table->string('advisor_note');
            $table->string('defense_date');
            $table->string('status');
            $table->string('report_path');
            $table->string('appraiser_note1');
            $table->string('appraiser_note2');
            $table->bigInteger('company_FK')->unsigned();
            $table->foreign('company_FK')->references('id')->on('companies');
            $table->bigInteger('user_FK')->unsigned();;
            $table->foreign('user_FK')->references('id')->on('profiles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_groups');
    }
}
