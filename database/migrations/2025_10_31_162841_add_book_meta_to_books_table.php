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
        Schema::table('books', function (Blueprint $table) {
            $table->json('character_traits')->nullable()->after('rating');
            $table->text('intrigue')->nullable()->after('character_traits');
            $table->string('setting')->nullable()->after('intrigue');
            $table->unsignedInteger('approx_words_per_chapter')->default(0)->after('setting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['character_traits','intrigue','setting','approx_words_per_chapter']);
        });
    }
};
