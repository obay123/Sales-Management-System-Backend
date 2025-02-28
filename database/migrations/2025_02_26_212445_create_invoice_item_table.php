<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_item', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id');
            $table->string('item_code');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('line_total', 10, 2);


            $table->foreign('invoice_id')
                  ->references('id')
                  ->on('invoices')
                  ->onDelete('cascade');

            $table->foreign('item_code')
                  ->references('code')
                  ->on('items')
                  ->onDelete('cascade');

            // Composite primary key (optional, but often used)
            $table->primary(['invoice_id', 'item_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_item');
    }
};
