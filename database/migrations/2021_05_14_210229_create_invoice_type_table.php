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
        Schema::create('invoice_type', function (Blueprint $table)
		{
            $table->tinyIncrements('id');
			$table->char('code', 2)->unique();
			$table->string('name', 350);
			$table->boolean('has_tax');
			$table->boolean('is_active');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_type');
    }
};
