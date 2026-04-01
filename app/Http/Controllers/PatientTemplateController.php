<?php

namespace App\Http\Controllers;

use App\Models\PatientTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientTemplateController extends Controller
{
    public function index()
    {
        $templates = PatientTemplate::where('doctor_id', Auth::id())->latest()->get();
        return view('doctor.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('doctor.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        PatientTemplate::create([
            'doctor_id' => Auth::id(),
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
        ]);

        return redirect()->route('doctor.templates.index')->with('success', 'Template created successfully.');
    }

    public function edit(PatientTemplate $template)
    {
        if ($template->doctor_id !== Auth::id()) {
            abort(403);
        }
        return view('doctor.templates.edit', compact('template'));
    }

    public function update(Request $request, PatientTemplate $template)
    {
        if ($template->doctor_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        $template->update($request->only(['title', 'type', 'content']));

        return redirect()->route('doctor.templates.index')->with('success', 'Template updated successfully.');
    }

    public function destroy(PatientTemplate $template)
    {
        if ($template->doctor_id !== Auth::id()) {
            abort(403);
        }

        $template->delete();

        return redirect()->route('doctor.templates.index')->with('success', 'Template deleted successfully.');
    }
}
