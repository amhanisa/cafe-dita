<?php

use App\Models\Habit;
use App\Models\Patient;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_habits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Patient::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Habit::class)->constrained();
            $table->year('year');
            $table->integer('month');
            $table->boolean('week1')->nullable();
            $table->boolean('week2')->nullable();
            $table->boolean('week3')->nullable();
            $table->boolean('week4')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('patient_habits');
    }
};
