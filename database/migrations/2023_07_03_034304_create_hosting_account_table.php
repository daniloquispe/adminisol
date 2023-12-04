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
        Schema::create('hosting_account', function (Blueprint $table)
		{
			$table->tinyIncrements('id');
			$table->unsignedInteger('client_id');
			$table->unsignedTinyInteger('main_domain_id');
			$table->unsignedTinyInteger('plan_id');
			$table->date('registered_at')->nullable();
			$table->date('expiring_at')->nullable();
			$table->date('terminated_at')->nullable();
			$table->string('cpanel_custom_url', 255)->nullable();
			$table->string('webmail_custom_url', 255)->nullable();
			$table->unsignedTinyInteger('status')->default(\App\Enums\DomainStatus::Active);
			$table->text('notes')->nullable();
			$table->timestamps();

			$table->foreign('client_id')->references('id')->on('organization');
			$table->foreign('main_domain_id')->references('id')->on('domain');
			$table->foreign('plan_id')->references('id')->on('hosting_plan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_account');
    }
};
