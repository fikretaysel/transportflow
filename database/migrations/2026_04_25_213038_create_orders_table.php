<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('customer_name');
            $table->string('customer_phone')->nullable();

            $table->string('pickup_address');
            $table->string('dropoff_address');

            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_plate')->nullable();

            $table->string('service_type')->default('transport');
            $table->string('priority')->default('normal');

            $table->string('status')->default('new');

            $table->unsignedBigInteger('assigned_driver_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->foreign('assigned_driver_id')
                ->references('id')
                ->on('drivers')
                ->onDelete('set null');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
