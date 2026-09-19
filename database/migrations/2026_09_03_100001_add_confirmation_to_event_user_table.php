<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_user', function (Blueprint $table) {
            // Código único de confirmación (ej. EM-7K3F9) para el check-in
            $table->string('confirmation_code')->nullable()->unique()->after('event_id');
            // Si la persona ya llegó al evento (check-in)
            $table->boolean('attended')->default(false)->after('confirmation_code');
            $table->timestamp('attended_at')->nullable()->after('attended');
        });
    }

    public function down(): void
    {
        Schema::table('event_user', function (Blueprint $table) {
            $table->dropColumn(['confirmation_code', 'attended', 'attended_at']);
        });
    }
};
