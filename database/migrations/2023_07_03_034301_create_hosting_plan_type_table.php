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
        Schema::create('hosting_plan_type', function (Blueprint $table)
		{
			$table->tinyIncrements('id');
			$table->unsignedTinyInteger('order');
			$table->string('name', 25)->unique();
			$table->string('description');
			$table->string('color', 9);
			$table->boolean('is_active')->default(true);
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_plan_type');
    }
};
