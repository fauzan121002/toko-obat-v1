
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlatKesehatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->string('code');
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('supplier_id');
            $table->bigInteger('price')->default(0);
            $table->bigInteger('stock')->default(0);
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');
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
