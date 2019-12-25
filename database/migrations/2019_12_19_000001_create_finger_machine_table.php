<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFingerMachineTable extends Migration
{
    protected $table = 'finger_machines';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->string('name', 30);
            $table->string('host', 100)->default('127.0.0.1');
            $table->unsignedSmallInteger('port')->default(80);
            $table->string('key', 20)->default('0');
            $table->boolean('enable')->default(true);
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
