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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Link transaction to a user
            $table->string('source'); // External source of the transaction (e.g., bank, PayPal)
            $table->decimal('amount', 10, 2); // Transaction amount
            $table->string('status')->default('Pending'); // Status of the transaction
            $table->text('note')->nullable(); // Optional note about the transaction
            $table->timestamp('transaction_date')->nullable(); // Date of the transaction
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
