<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('cpf', 11);
            $table->string('email', 100);
            $table->string('password', 200);
            $table->enum('type', ['L', 'U']);
            $table->decimal('balance', 8, 2)->default(0);
            $table->string('token', 200)->nullable();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payer');
            $table->unsignedBigInteger('payee');
            $table->decimal('value', 8, 2);
            $table->dateTime('created_at');

        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('payer')->references('id')->on('users');
            $table->foreign('payee')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('transactions');
    }
}
