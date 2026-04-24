<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Users: role + 2fa + status
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'editor', 'author'])->default('author')->after('is_admin');
            $table->string('avatar')->nullable()->after('role');
            $table->string('two_factor_secret')->nullable()->after('avatar');
            $table->boolean('two_factor_enabled')->default(false)->after('two_factor_secret');
            $table->enum('status', ['active', 'suspended', 'invited'])->default('active')->after('two_factor_enabled');
            $table->timestamp('last_login_at')->nullable()->after('status');
            $table->string('invite_token')->nullable()->after('last_login_at');
        });

        // Articles: scheduling + soft-delete + revision pointer
        Schema::table('articles', function (Blueprint $table) {
            $table->timestamp('scheduled_at')->nullable()->after('published_at');
            $table->unsignedBigInteger('user_id')->nullable()->after('author_id');
            $table->string('canonical_url')->nullable()->after('seo_description');
            $table->string('og_image')->nullable()->after('canonical_url');
            $table->softDeletes();
        });

        // Article revisions
        Schema::create('article_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->json('snapshot')->nullable();
            $table->timestamps();
            $table->index(['article_id', 'created_at']);
        });

        // Comments
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->nullOnDelete();
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->string('author_ip', 45)->nullable();
            $table->text('body');
            $table->enum('status', ['pending', 'approved', 'rejected', 'spam'])->default('pending');
            $table->boolean('is_flagged')->default(false);
            $table->timestamps();
            $table->index(['article_id', 'status']);
            $table->index('status');
        });

        // Banned users / IPs
        Schema::create('banned_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45)->unique();
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        // Newsletter subscribers
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->enum('status', ['pending', 'active', 'unsubscribed', 'bounced'])->default('active');
            $table->string('confirmation_token')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('source')->nullable(); // footer / popup / import
            $table->json('tags')->nullable();
            $table->timestamps();
            $table->index('status');
        });

        // Newsletter campaigns
        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('from_name')->default('ODOD News');
            $table->string('from_email')->default('news@ododnews.mn');
            $table->longText('html_body');
            $table->text('plain_body')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'sending', 'sent', 'failed'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedInteger('recipients_count')->default(0);
            $table->unsignedInteger('opens_count')->default(0);
            $table->unsignedInteger('clicks_count')->default(0);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        // Campaign recipients (per-email tracking)
        Schema::create('campaign_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('newsletter_campaigns')->cascadeOnDelete();
            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->string('tracking_token')->unique();
            $table->timestamps();
        });

        // Ad slots (zones on the site)
        Schema::create('ad_slots', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();          // e.g. home_top, sidebar_right
            $table->string('name');
            $table->string('size')->nullable();        // e.g. 728x90
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Ads (creatives placed into slots)
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slot_id')->constrained('ad_slots')->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['image', 'html', 'adsense'])->default('image');
            $table->string('image_path')->nullable();
            $table->longText('html_code')->nullable();
            $table->string('target_url')->nullable();
            $table->string('geo_targets')->nullable(); // comma-separated country codes
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->unsignedInteger('impressions')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->timestamps();
            $table->index(['slot_id', 'is_active']);
        });

        // Breaking-news alerts / push
        Schema::create('breaking_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->nullable()->constrained()->nullOnDelete();
            $table->string('headline');
            $table->text('message')->nullable();
            $table->string('url')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['draft', 'active', 'expired'])->default('draft');
            $table->boolean('push_sent')->default(false);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'starts_at']);
        });

        // Site settings (key/value)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general'); // general, seo, social, mail, analytics
            $table->string('type')->default('string');   // string, text, bool, int, json, image
            $table->timestamps();
        });

        // Activity / audit log
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');                    // created, updated, deleted, login, logout
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('description')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
        });

        // Notifications (in-app: pending comments, scheduled articles, breaking drafts)
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');                      // comment.pending, article.review, breaking.draft
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('link')->nullable();
            $table->enum('level', ['info', 'success', 'warning', 'danger'])->default('info');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('breaking_alerts');
        Schema::dropIfExists('ads');
        Schema::dropIfExists('ad_slots');
        Schema::dropIfExists('campaign_recipients');
        Schema::dropIfExists('newsletter_campaigns');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('banned_ips');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('article_revisions');

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'user_id', 'canonical_url', 'og_image']);
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'two_factor_secret', 'two_factor_enabled', 'status', 'last_login_at', 'invite_token']);
        });
    }
};
