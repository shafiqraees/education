<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('class_room_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('roll_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->text('profile_photo_path')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('org_password')->nullable();
            $table->text('address')->nullable();
            $table->text('about')->nullable();
            $table->string('device_token')->nullable();
            $table->enum('is_active', ['true', 'false'])->default('true');
            $table->enum('notification_status', ['true', 'false'])->default('true');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
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
    }
}
