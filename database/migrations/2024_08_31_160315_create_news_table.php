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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('url')->nullable();
            $table->string('soruce')->nullable();
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->text('comment_neutral')->nullable();
            $table->text('comment_left')->nullable();
            $table->text('comment_right')->nullable();
            $table->string('location_country')->nullable();
            $table->string('location_region')->nullable();
            $table->text('key_figures')->nullable();
            $table->text('keywords')->nullable();
            $table->integer('credibility_score')->nullable();
            $table->integer('importance_score')->nullable();
            $table->integer('timeliness_score')->nullable();
            $table->string('credibility_explanation')->nullable();
            $table->string('media_bias')->nullable();
            $table->timestamp('processed_timestamp')->nullable();
            $table->string('locale');
            $table->timestamps();

            $table->index(['title']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
