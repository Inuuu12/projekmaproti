<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Cabang;

class AdminPusatSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Cabang untuk Owner (Misal: Kantor Pusat)
        // Kita pakai firstOrCreate agar tidak duplikat jika seeder dijalankan 2x
        $cabangOwner = Cabang::firstOrCreate(
            ['nama_cabang' => 'Kantor Pusat'], // Cek apakah nama ini ada
            [
                'lokasi' => 'Jakarta', // Data lokasi jika belum ada
            ]
        );

        $hasUsername = Schema::hasColumn('users', 'username');
        $hasEmail = Schema::hasColumn('users', 'email');

        $identifierColumn = $hasUsername ? 'username' : 'name';
        $adminName = 'Admin Pusat';
        $ownerName = 'Owner Cabang';
        $adminIdentifierValue = $hasUsername ? 'adminpusat' : $adminName;
        $ownerIdentifierValue = $hasUsername ? 'owner' : $ownerName;

        $adminAttributes = [
            'name' => $adminName,
            'password' => Hash::make('Rahasia!123'),
            'role' => 'superadmin',
            'cabang_id' => $cabangOwner->id,
        ];

        $ownerAttributes = [
            'name' => $ownerName,
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'cabang_id' => $cabangOwner->id,
        ];

        if ($hasUsername) {
            $adminAttributes['username'] = 'adminpusat';
            $ownerAttributes['username'] = 'owner';
        }

        if ($hasEmail) {
            $adminAttributes['email'] = 'admin@lafleur.com';
            $ownerAttributes['email'] = 'owner@lafleur.com';
        }

        User::updateOrCreate(
            [$identifierColumn => $adminIdentifierValue],
            $adminAttributes
        );

        User::updateOrCreate(
            [$identifierColumn => $ownerIdentifierValue],
            $ownerAttributes
        );

        // Seeder memastikan dua akun penting tersedia:
        // 1. Admin pusat (superadmin)
        // 2. Owner cabang (owner)
    }
}
