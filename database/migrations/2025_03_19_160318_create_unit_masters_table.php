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
        Schema::create('unit_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
        
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('item_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('order_no')->nullable();
            $table->string('address')->nullable();
            $table->string('order_type')->nullable();
            $table->string('category_1')->nullable();
            $table->string('category_2')->nullable();
            $table->string('category_3')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->date('order_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('close_date')->nullable();
            $table->string('remarks')->nullable();
            $table->string('location')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
        
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('category_1')->nullable();
            $table->string('category_2')->nullable();
            $table->string('category_3')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('remarks')->nullable();
            $table->date('order_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('close_date')->nullable();
            $table->string('location')->nullable();
            $table->string('order_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('order_type')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
        
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('type')->nullable();
            $table->string('gst_no')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
        
        Schema::create('cheque_books', function (Blueprint $table) {
            $table->id();
            $table->string('payee_name')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('cheque_date')->nullable();
            $table->float('amount',8,2)->default(0.00);
            $table->date('drop_date')->nullable();
            $table->date('clearing_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('receiver_name')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
        
        Schema::create('stock_namagement', function (Blueprint $table) {
            $table->id();
            $table->string('item_name')->nullable();
            $table->string('category_1')->nullable();
            $table->string('category_2')->nullable();
            $table->string('category_3')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('remarks')->nullable();
            $table->string('in_bill_no')->nullable();
            $table->string('outward')->nullable();
            $table->string('bill_no')->nullable();
            $table->integer('quantity_1')->nullable();
            $table->string('unit_1')->nullable();
            $table->integer('quantity_2')->nullable();
            $table->string('unit_2')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_masters');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('items');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('stock_namagement');
        Schema::dropIfExists('cheque_books');
    }
};
