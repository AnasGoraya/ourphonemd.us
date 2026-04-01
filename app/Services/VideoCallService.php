<?php

namespace App\Services;

use Illuminate\Support\Str;

class VideoCallService
{
    public function createRoom($appointmentId)
    {
        // Unique room name for this appointment
        $roomName = 'appointment_' . $appointmentId . '_' . Str::random(8);

        $baseUrl = rtrim(env('JITSI_BASE_URL', 'https://meet.jit.si'), '/');

        return [
            'id' => Str::uuid()->toString(),
            'name' => $roomName,
            'url' => $baseUrl . '/' . $roomName,
        ];
    }

    public function generateToken($roomName, $userName, $isOwner = false)
    {
        // Public Jitsi doesn't need token
        return null;
    }
}
