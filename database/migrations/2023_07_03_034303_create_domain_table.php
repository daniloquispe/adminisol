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
        Schema::create('domain', function (Blueprint $table)
		{
			$table->tinyIncrements('id');
			$table->unsignedInteger('client_id');
			$table->string('name', 255);
			$table->date('registered_at')->nullable();
			$table->date('expiring_at')->nullable();
			$table->date('cancelled_at')->nullable();
			$table->boolean('is_external')->default(false);
			$table->unsignedTinyInteger('status')->default(\App\Enums\DomainStatus::Active);
			$table->text('notes')->nullable();
			$table->timestamps();

			$table->foreign('client_id')->references('id')->on('organization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain');
    }
};
