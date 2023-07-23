<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecieptbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recieptbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_no');
            $table->integer('rno_from');
            $table->integer('rno_to');
            $table->integer('nol');
            $table->char('bookmode',2);
            $table->char('status');
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
        Schema::dropIfExists('recieptbooks');
    }
}
