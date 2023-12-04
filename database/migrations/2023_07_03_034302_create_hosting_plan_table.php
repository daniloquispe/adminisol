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
        Schema::create('hosting_plan', function (Blueprint $table)
		{
			$table->tinyIncrements('id');
			$table->unsignedTinyInteger('type_id');
			$table->string('name', 25);
			$table->boolean('is_active')->default(true);
			$table->unsignedTinyInteger('capacity');
			$table->char('capacity_unit', 2);
			$table->unsignedSmallInteger('transfer');
			$table->char('transfer_unit', 4);
//			$table->decimal('price_year');
			$table->unsignedInteger('price_year');
//			$table->decimal('price_month');
			$table->unsignedInteger('price_month');
			$table->timestamps();

			$table->foreign('type_id')->references('id')->on('hosting_plan_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_plan');
    }
};
