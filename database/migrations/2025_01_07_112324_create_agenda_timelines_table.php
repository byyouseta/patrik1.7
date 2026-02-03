<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_timelines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_timeline');
            $table->string('target');
            $table->string('instruktor');
            $table->integer('instruktor_id');
            $table->integer('unit_id');
            $table->integer('pic');
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->text('hambatan')->nullable();
            $table->text('rtl')->nullable();
            $table->string('progress', 15);
            $table->double('aktual', 5, 2);
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
        Schema::dropIfExists('agenda_timelines');
    }
}
