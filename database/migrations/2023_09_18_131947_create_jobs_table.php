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
            $table->id();
            $table->text('position');
            $table->text('slug');
            $table->longText('summary')->nullable();
            $table->text('thumbnail');
            $table->text('edu_requirement')->nullable();
            $table->text('salary');
            $table->text('published_on');
            $table->tinyInteger('vacancy');
            $table->text('employment_status');
            $table->text('office_time');
            $table->text('location');
            $table->text('office_days');
            $table->text('experience_req')->nullable();
            $table->text('app_deadline');
            $table->text('applying_url');
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
