<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineUserFingersTable extends Migration
{
    protected $table = 'machine_user_fingers';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->string('machine_user_id', 32);
            $table->unsignedTinyInteger('finger')->default(1);
            $table->string('size', 3)->default('');
            $table->boolean('valid')->default(true);
            $table->string('template')->default('');
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
        Schema::dropIfExists($this->table);
    }
}
