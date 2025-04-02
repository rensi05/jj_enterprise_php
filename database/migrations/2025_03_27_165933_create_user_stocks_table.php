<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->after('vehicle_no', function ($table) {
                $table->enum('status',['pending','completed'])->default('pending');
            });
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->enum('customer_type',['purchase','sales'])->nullable();
            });
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('order_date');
            $table->dropColumn('delivery_date');
            $table->dropColumn('close_date');
            $table->dropColumn('order_no');
            $table->dropColumn('vehicle_no');
            $table->dropColumn('bill_no');
            $table->dropColumn('order_type');
            $table->integer('quantity_1')->nullable()->after('unit');
            $table->string('unit_1')->nullable()->after('quantity_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->date('order_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('close_date')->nullable();
            $table->string('order_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('order_type')->nullable();
            $table->dropColumn('quantity_1');
            $table->dropColumn('unit_1');
        });
    }
};
