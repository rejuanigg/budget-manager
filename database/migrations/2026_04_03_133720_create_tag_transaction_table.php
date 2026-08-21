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
        Schema::create('tag_transaction', function (Blueprint $table) {
            // Pivot table for the many-to-many relationship between tags and transactions.
            // Contains foreign keys to tags.id and transactions.id, and timestamps for auditing.
            $table->id();
            $table->foreignId('tag_id')
                ->constrained('tags')
                ->restrictOnDelete();
            $table->foreignId('transaction_id')
                ->constrained('transactions')
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_transaction');
    }
};
