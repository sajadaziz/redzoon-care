<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFyintialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fyintials', function (Blueprint $table) {
            $table->bigIncrements('fy_id');
            $table->date('fyStart');
            $table->date('fyEnd');
            $table->decimal('totCollection',10,2)->nullable();
            $table->integer('totDonars')->nullable();
            $table->decimal('totDisburse',10,2)->nullable();
            $table->integer('totBenificiary')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('fyintials');
    }
}
