<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('manager_id')->nullable();
            $table->string('approved_by_manager')->default('pending');
            $table->date('approved_by_manager_on')->nullable();
            $table->unsignedInteger('senior_manager_id')->nullable();
            $table->string('approved_by_senior_manager')->default('pending');
            $table->date('approved_by_senior_manager_on')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
            $table->string('approved_by_admin')->default('pending');
            $table->date('approved_by_admin_on')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->text('request_details')->nullable();
            $table->unsignedInteger('amount')->nullable();
            $table->string('currency')->nullable();
            $table->date('expected_on')->nullable();
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
        Schema::dropIfExists('purchase_order_requests');
    }
}
