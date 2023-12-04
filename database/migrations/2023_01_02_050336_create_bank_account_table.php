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
        Schema::create('bank_account', function (Blueprint $table)
		{
            $table->tinyIncrements('id');
			$table->unsignedTinyInteger('bank_id');
			$table->unsignedTinyInteger('currency_id');
			$table->string('number', 20);
			$table->string('cci', 25)->nullable();
			$table->string('iban', 34)->nullable();
			$table->boolean('is_active');
            $table->timestamps();

			$table->foreign('bank_id')->references('id')->on('bank');
			$table->foreign('currency_id')->references('id')->on('currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_account');
    }
};
