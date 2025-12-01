<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pharmacy;

class PharmacySeeder extends Seeder
{
    public function run(): void
    {
        $pharmacies = [
            [
                'name' => 'Union Chemist',
                'owner_name' => 'Union Pharmacy Owner',
                'email' => 'unionchemist@carebridge.lk',
                'phone' => '0112345678',
                'address' => '123 Union Place, Colombo 02',
                'latitude' => 6.9271,
                'longitude' => 79.8612,
                'license_number' => 'PH-UNION-001',
                'status' => 'approved',
                'opening_time' => '08:00:00',
                'closing_time' => '20:00:00',
                'is_24_hours' => false,
            ],
            [
                'name' => 'Rajya Osu Sala',
                'owner_name' => 'Government Pharmacy',
                'email' => 'rajyaosu@carebridge.lk',
                'phone' => '0113456789',
                'address' => '456 Government Road, Colombo 10',
                'latitude' => 6.9350,
                'longitude' => 79.8620,
                'license_number' => 'PH-RAJYA-002',
                'status' => 'approved',
                'opening_time' => '07:00:00',
                'closing_time' => '22:00:00',
                'is_24_hours' => false,
            ]
        ];

        foreach ($pharmacies as $pharmacy) {
            Pharmacy::create($pharmacy);
        }

        $this->command->info('Pharmacies seeded successfully!');
    }
}