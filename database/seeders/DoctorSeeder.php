<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        $doctors = [
            [
                'name' => 'Dr. Ahmed Khan',
                'specialization' => 'Cardiologist',
                'qualification' => 'MBBS, FCPS',
                'experience_years' => 15,
                'phone' => '0300-1234567',
                'email' => 'ahmed.khan@hospital.com',
                'bio' => 'Senior Cardiologist with 15 years of experience in heart diseases.',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Sara Ali',
                'specialization' => 'Dermatologist',
                'qualification' => 'MBBS, MD',
                'experience_years' => 8,
                'phone' => '0300-7654321',
                'email' => 'sara.ali@hospital.com',
                'bio' => 'Expert in skin diseases and cosmetic dermatology.',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Usman Malik',
                'specialization' => 'Orthopedic',
                'qualification' => 'MBBS, FRCS',
                'experience_years' => 12,
                'phone' => '0300-1122334',
                'email' => 'usman.malik@hospital.com',
                'bio' => 'Specialist in bone and joint surgeries.',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Fatima Noor',
                'specialization' => 'Pediatrician',
                'qualification' => 'MBBS, DCH',
                'experience_years' => 10,
                'phone' => '0300-5566778',
                'email' => 'fatima.noor@hospital.com',
                'bio' => 'Child specialist with expertise in pediatric care.',
                'status' => 'active',
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}
