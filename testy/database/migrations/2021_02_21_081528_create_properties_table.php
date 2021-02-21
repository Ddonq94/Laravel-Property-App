<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('county');
            $table->string('country');
            $table->string('town');
            $table->text('description');
            $table->text('address');
            $table->text('image_full');
            $table->text('image_thumbnail');
            $table->float('latitude', 9, 6)->nullable();
            $table->float('longitude', 9, 6)->nullable();
            $table->smallInteger('num_bedrooms');
            $table->smallInteger('num_bathrooms');
            $table->float('price', 14, 2);
            $table->string('property_type_id');
            $table->enum('type', ['sale', 'rent']);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
