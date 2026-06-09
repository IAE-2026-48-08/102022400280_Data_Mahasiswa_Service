<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'nim' => '102022400280',
            'nama' => 'Hans Dhika Slamet',
            'status' => 'AKTIF',
            'quota_sks' => 24,
            'used_sks' => 18
        ]);

        Student::create([
            'nim' => '102022400281',
            'nama' => 'Budi Santoso',
            'status' => 'AKTIF',
            'quota_sks' => 24,
            'used_sks' => 20
        ]);
    }
}