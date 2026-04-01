<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

try {
    $patientId = DB::table('patients')->value('id');

    // Try to find a doctor id from existing appointments first, then doctors table
    $doctorId = DB::table('appointments')->value('doctor_id');
    if (!$doctorId) {
        $doctorId = DB::table('doctors')->value('id');
    }
    if (!$doctorId) {
        // try users by is_doctor flag (if present)
        $doctorId = DB::table('users')->where('is_doctor', 1)->value('id');
    }

    if (!$patientId || !$doctorId) {
        echo "missing_patient_or_doctor: patient={$patientId}, doctor={$doctorId}\n";
        exit(1);
    }

    $data = [
        'patient_id' => $patientId,
        'doctor_id' => $doctorId,
        'appointment_date' => date('Y-m-d', strtotime('+7 days')),
        'appointment_time' => '10:00:00',
        'symptoms' => 'Test insertion via script',
        'priority' => 'normal',
        'status' => 'in_progress',
        'token' => Str::random(24),
        'appointment_mode' => 'in_person',
    ];

    $appointment = \App\Models\Appointment::create($data);
    echo "created: " . $appointment->id . "\n";
    echo json_encode($appointment->toArray(), JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "error:" . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
