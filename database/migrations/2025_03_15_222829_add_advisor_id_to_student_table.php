<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {

        });
    }

    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            $table->dropForeign('students_advisor_id_foreign');
            $table->dropColumn('advisor_id');
        });
    }
};
