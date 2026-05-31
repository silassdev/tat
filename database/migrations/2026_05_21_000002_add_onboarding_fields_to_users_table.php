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
            $table->boolean('onboarded')->default(false)->after('role');
            $table->string('country')->nullable()->after('onboarded');
            $table->string('state')->nullable()->after('country');
            $table->string('lga')->nullable()->after('state');
            $table->string('town')->nullable()->after('lga');
            $table->string('street')->nullable()->after('town');
            $table->string('next_of_kin')->nullable()->after('street');
            $table->string('gender')->nullable()->after('next_of_kin');
            $table->date('dob')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'onboarded',
                'country',
                'state',
                'lga',
                'town',
                'street',
                'next_of_kin',
                'gender',
                'dob',
            ]);
        });
    }
};
