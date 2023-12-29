<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Database migration for contacts.
 *
 * @package AdminISOL\Contact
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact', function (Blueprint $table)
		{
			$table->id();
			$table->unsignedInteger('organization_id')->nullable();
			$table->string('last_name');
			$table->string('first_name');
			$table->string('nickname')->nullable();
			$table->string('job_title')->nullable();
			$table->date('birthdate')->nullable();
			$table->tinyInteger('status');
			$table->boolean('is_owner');
			$table->boolean('is_billing');
			$table->text('notes')->nullable();
			$table->string('avatar_filename', 255)->nullable();
			$table->timestamps();

			$table->foreign('organization_id')
				->references('id')->on('organization')
				->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::dropIfExists('contact');
    }
};
