<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization', function (Blueprint $table)
		{
            $table->integerIncrements('id');
            $table->string('name', 45);
			$table->string('legal_name', 100)->unique();
			$table->unsignedTinyInteger('id_doc_type_id')->nullable();
			$table->string('id_doc_num', 25)->nullable();
			$table->unsignedTinyInteger('invoice_type_id');
			$table->date('as_client_at')->nullable();
			$table->date('as_vendor_at')->nullable();
			$table->text('notes')->nullable();
			$table->boolean('is_enabled');
			$table->date('prospecting_at')->nullable();
            $table->timestamps();

            $table->foreign('id_doc_type_id')->references('id')->on('id_doc_type')->cascadeOnUpdate();
			$table->foreign('invoice_type_id')->references('id')->on('invoice_type')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization');
    }
}
