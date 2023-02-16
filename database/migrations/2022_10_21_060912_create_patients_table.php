<?php

use App\Models\Village;
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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('medical_record_number')->unique();
            $table->string('nik')->nullable();
            $table->char('sex', 1)->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->foreignIdFor(Village::class)->constrained()->restrictOnDelete();
            $table->string('job')->nullable();
            $table->string('phone_number')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
