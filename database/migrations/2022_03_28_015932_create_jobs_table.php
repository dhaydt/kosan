<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('penempatan', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->integer('onsite')->nullable();
            $table->string('keahlian', 50)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->text('description')->nullable();
            $table->double('gaji')->default('0');
            $table->integer('hide_gaji')->default('1');
            $table->string('satuan_gaji', 50)->nullable();
            $table->string('penanggung_jwb', 100)->nullable();
            $table->string('hp_penanggung_jwb', 20)->nullable();
            $table->string('email_penanggung_jwb', 255)->nullable();
            $table->dateTime('expire')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
