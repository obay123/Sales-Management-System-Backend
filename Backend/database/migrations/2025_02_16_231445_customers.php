<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('salesmen_code', 100);
            $table->foreign('salesmen_code')->references('code')->on('salesmens')->onDelete('cascade');
        
            $table->string('name')->unique();
            $table->string('tel1');
            $table->string('tel2')->nullable();
            $table->text('address')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('subscription_date');
            $table->unsignedTinyInteger('rate')->default(1)->comment('Rating from 1 to 5');
            $table->string('photo')->nullable();
            $table->json('tag')->nullable(); 
            $table->timestamps();
        });
        
    }
    
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
