<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('diet_type')->nullable();
            $table->boolean('low_carb')->default(false);
            $table->boolean('high_protein')->default(false);
            $table->boolean('low_fat')->default(false);
            $table->boolean('gluten_free')->default(false);
            $table->boolean('dairy_free')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
