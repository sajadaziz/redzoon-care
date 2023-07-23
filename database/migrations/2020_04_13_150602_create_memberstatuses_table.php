<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberstatuses', function (Blueprint $table) {
            $table->id();
            $table->integer('donee_id_fk');
            $table->char('donee_type',2); 
            $table->char('status',2);
            $table->timestamp('s_from');
            $table->timestamp('s_to')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->string('responsibilities');
            $table->text('remarks');
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
        Schema::dropIfExists('memberstatuses');
    }
}
