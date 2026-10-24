<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('completed');
        });

        DB::table('todos')->where('completed', true)->update(['status' => 'completed']);
        DB::table('todos')->where('completed', false)->update(['status' => 'pending']);
    }

    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};