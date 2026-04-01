<?php

namespace App\Http\Controllers;

use App\Models\DoctorContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorContactController extends Controller
{
    public function index()
    {
        return view('doctor.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        DoctorContact::create([
            'doctor_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your message has been sent successfully. Our support team will get back to you soon.');
    }
}
