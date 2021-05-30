
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->enum('name',['drug','medical_devices','supplement']);
            $table->bigInteger('order_quantity');
            $table->bigInteger('total_price');
            $table->unsignedBigInteger('cashier_id');
            $table->unsignedBigInteger('drug_id')->nullable();
            $table->unsignedBigInteger('medical_device_id')->nullable();
            $table->unsignedBigInteger('supplement_id')->nullable();
            $table->timestamps();
            
            $table->foreign('cashier_id')->references('id')->on('cashiers')->onDelete('cascade');
            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('cascade');
            $table->foreign('medical_device_id')->references('id')->on('medical_devices')->onDelete('cascade');
            $table->foreign('supplement_id')->references('id')->on('supplements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
