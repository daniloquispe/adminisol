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
        Schema::create('renewals', function (Blueprint $table)
		{
            $table->id();
			$table->unsignedInteger('customer_id')->index();
//			$table->integer('service_id');
//			$table->string('service_type');
			$table->date('due_at');
//			$table->unsignedInteger('price_year');
//			$table->unsignedInteger('price_month')->nullable();
			$table->unsignedTinyInteger('currency_id')->index();

			$table->date('notification_sent_at')->nullable();
			$table->date('payment_verified_at')->nullable();
			$table->date('renewed_at')->nullable();
			$table->date('invoice_sent_at')->nullable();

			$table->unsignedTinyInteger('bank_account_id')->nullable()->index();
			$table->text('notes')->nullable();
            $table->timestamps();

			$table->foreign('customer_id')->references('id')->on('organization');
			$table->foreign('currency_id')->references('id')->on('currency');
			$table->foreign('bank_account_id')->references('id')->on('bank_account');
        });

		Schema::create('renewables', function (Blueprint $table)
		{
			$table->foreignIdFor(\App\Models\Renewal::class)->constrained()->cascadeOnDelete();
			$table->unsignedTinyInteger('renewable_id');
			$table->string('renewable_type');
			$table->unsignedInteger('amount');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewables');
        Schema::dropIfExists('renewals');
    }
};
