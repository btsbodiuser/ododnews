<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('source_name')->nullable()->after('meta');
            $table->string('source_url')->nullable()->after('source_name');
            $table->json('gallery')->nullable()->after('featured_video');
            $table->unsignedSmallInteger('reading_time')->nullable()->after('views_count');
            $table->string('seo_title')->nullable()->after('meta');
            $table->text('seo_description')->nullable()->after('seo_title');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'source_name',
                'source_url',
                'gallery',
                'reading_time',
                'seo_title',
                'seo_description',
            ]);
        });
    }
};
