<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpysOneFilterSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spys_one_filter_sets', function (Blueprint $table) {
            $table->id();
            $table->integer('xpp');
            $table->integer('xf1');
            $table->integer('xf2');
            $table->integer('xf3');
            $table->integer('xf4');
            $table->integer('xf5');
            $table->string('status');
            $table->timestamps();
            $table->unique(['xpp', 'xf1','xf2','xf3','xf4','xf5']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spys_one_filter_sets');
    }
}
