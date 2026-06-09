<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Builder block model (JSON) used to rebuild the editor on edit.
            $table->longText('content_json')->nullable()->after('description');
            // Short plain-text excerpt shown on cards.
            $table->string('excerpt', 500)->nullable()->after('content_json');
        });

        // description now holds rich rendered HTML — widen it.
        Schema::table('services', function (Blueprint $table) {
            $table->longText('description')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['content_json', 'excerpt']);
            $table->text('description')->nullable(false)->change();
        });
    }
};
