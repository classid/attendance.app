<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresenceTable extends Migration
{
    protected $table = 'log_presences';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->string('machine_id', 32);
            $table->string('pin', 30);
            $table->timestamp('datetime')->nullable();
            $table->string('status', 20);
            $table->string('verified', 15);
            $table->string('locked', 32)->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['pin', 'datetime']);
            $table->foreign('machine_id')
                ->references('id')->on('machines')
                ->onUpdate('cascade')->onDelete('no action');
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
