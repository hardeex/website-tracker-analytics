<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('analytics', function (Blueprint $table) {
            $table->string('session_id')->nullable()->after('ip_address');
        });
    }

    public function down()
    {
        Schema::table('analytics', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
    }
};
