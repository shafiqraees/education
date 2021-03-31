<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransanctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transanctions', function (Blueprint $table) {
            $table->id();
            $table->text('transaction_id')->nullable();
            $table->text('payer_id')->nullable();
            $table->text('invoice_number')->nullable();
            $table->string('state')->nullable();
            $table->string('package_name')->nullable();
            $table->string('status')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('amount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transanctions');
    }
}
