<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriaRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('first_criteria_id');
            $table->integer('second_criteria_id');
            $table->integer('weight');
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
        Schema::dropIfExists('criteria_relations');
    }
}
