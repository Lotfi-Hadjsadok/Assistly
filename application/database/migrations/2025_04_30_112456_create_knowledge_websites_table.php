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
        Schema::create('knowledge_websites', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('status')->default('untrained');
            $table->json('sitemap')->nullable();
            $table->timestamp('trained_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_websites');
    }
};
