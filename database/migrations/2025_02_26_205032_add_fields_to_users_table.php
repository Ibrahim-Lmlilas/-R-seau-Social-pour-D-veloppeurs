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
        Schema::table('users', function (Blueprint $table) {
            $table->text('skills')->nullable();
            $table->text('programming_languages')->nullable();
            $table->text('projects')->nullable();
            $table->text('certifications')->nullable();
            $table->string('github_url')->nullable();
            $table->string('image')->nullable();
            $table->string('industry')->nullable();
            $table->string('banner')->nullable();
            $table->text('bio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('skills');
            $table->dropColumn('programming_languages');
            $table->dropColumn('projects');
            $table->dropColumn('certifications');
            $table->dropColumn('github_url');
            $table->dropColumn('image');
            $table->dropColumn('industry');
            $table->dropColumn('banner');
            $table->dropColumn('bio');
        });
    }
};
