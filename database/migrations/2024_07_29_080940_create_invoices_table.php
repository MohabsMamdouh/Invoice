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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->integer('customer_id')->unsigned();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('reference')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->double('sub_total');
            $table->double('discount')->default(0);
            $table->double('total');
            $table->string('status')->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
