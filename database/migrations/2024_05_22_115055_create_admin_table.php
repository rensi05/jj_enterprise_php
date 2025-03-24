<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('number')->unique();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->integer('msg_otp')->nullable();
            $table->timestamp('otp_expire_time')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
        
        DB::table('admins')->insert(
            array(
                'role' => 'Admin',
                'first_name' => "JJ",
                'last_name' => 'Admin',
                'email' => 'admin@mailinator.com',
                'number' => '5879483215',
                'password' => bcrypt('Admin@123'),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
