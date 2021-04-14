<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('sub_admin_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->text('profile_photo_path')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->text('about')->nullable();
            $table->text('org_password')->nullable();
            $table->string('device_token')->nullable();
            $table->string('country')->nullable();
            $table->string('terms_and_conditions')->nullable();
            $table->string('organization_type')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('organization_role')->nullable();
            $table->enum('is_active', ['true', 'false'])->default('true');
            $table->enum('notification_status', ['true', 'false'])->default('true');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('sub_admin_id')->references('id')->on('sub_admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
