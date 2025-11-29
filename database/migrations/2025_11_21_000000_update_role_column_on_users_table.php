<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('staff')->after('password');
            });
            return;
        }

        $existingRoles = DB::table('users')
            ->select('id', 'role')
            ->get();

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('staff')->after('password');
        });

        foreach ($existingRoles as $row) {
            DB::table('users')
                ->where('id', $row->id)
                ->update([
                    'role' => $row->role ?? 'staff',
                ]);
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['owner', 'staff'])->default('staff')->after('password');
            });
            return;
        }

        $existingRoles = DB::table('users')
            ->select('id', 'role')
            ->get();

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['owner', 'staff'])->default('staff')->after('password');
        });

        foreach ($existingRoles as $row) {
            $fallbackRole = in_array($row->role, ['owner', 'staff'], true) ? $row->role : 'staff';

            DB::table('users')
                ->where('id', $row->id)
                ->update([
                    'role' => $fallbackRole,
                ]);
        }
    }
};


