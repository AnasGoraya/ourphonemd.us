<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PatientNotifications extends Component
{
    public $notifications;
    public $unreadCount;

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function refreshNotifications()
    {
        $user = Auth::guard('patient')->user();
        if (!$user) {
            $this->notifications = collect([]);
            $this->unreadCount = 0;
            return;
        }

        $this->notifications = $user->notifications()->limit(10)->get();
        $this->unreadCount = $user->unreadNotifications->count();
    }

    public function markAsRead($notificationId)
    {
        $user = Auth::guard('patient')->user();
        if ($user) {
            $notification = $user->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                $this->refreshNotifications();
                
                $data = $notification->data;
                if (isset($data['type'])) {
                    if ($data['type'] === 'note') {
                         return redirect()->route('patient.notes');
                    } elseif ($data['type'] === 'appointment') {
                         return redirect()->route('patient.appointment.dashboard');
                    } elseif ($data['type'] === 'appointment') {
                         return redirect()->route('patient.appointment.dashboard');
                    }
                    // Video call notifications are informational only
                }
            }
        }
    }

    public function deleteNotification($notificationId)
    {
        $user = Auth::guard('patient')->user();
        if ($user) {
            $notification = $user->notifications()->find($notificationId);
            if ($notification) {
                $notification->delete();
                $this->refreshNotifications();
            }
        }
    }

    public function render()
    {
        return view('livewire.patient-notifications');
    }
}
