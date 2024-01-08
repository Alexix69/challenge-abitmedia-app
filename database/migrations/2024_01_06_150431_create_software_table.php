<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 10);
            $table->string('type');
            $table->string('serial');
            $table->timestamps();
        });

        Schema::create('operating_system_software', function (Blueprint $table) {
            $table->unsignedBigInteger('operating_system_id');
            $table->foreign('operating_system_id')->references('id')->on('operating_systems')->onDelete('cascade');
            $table->unsignedBigInteger('software_id');
            $table->foreign('software_id')->references('id')->on('software')->onDelete('cascade');
            $table->decimal('price', 10, 4, true);
            $table->integer('stock', false, true);
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('software');
        Schema::dropIfExists('operating_system_software');
        Schema::enableForeignKeyConstraints();
    }
};
