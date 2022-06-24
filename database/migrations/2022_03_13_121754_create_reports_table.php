<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('month');
            $table->string('year');
            $table->string('admin_points')->nullable();
            $table->string('admin_deduct_points');
            $table->string('hr_points')->nullable();
            $table->string('admin_remarks')->nullable();
            $table->string('hr_remarks')->nullable();
            $table->string('avg_points')->nullable();
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
        Schema::dropIfExists('reports');
    }
}
