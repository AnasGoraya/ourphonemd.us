@extends('layouts.doctor')

@section('title', 'Edit Template - OurPhoneMD')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="mb-4">
            <a href="{{ route('doctor.templates.index') }}" class="btn btn-link p-0 mb-2" style="color: #3EA293; text-decoration: none; font-weight: 600;">
                <i class="fas fa-arrow-left mr-2"></i> Back to Templates
            </a>
            <h1 class="h3 font-weight-bold text-gray-900" style="color: #1a2e35;">Edit Template</h1>
            <p class="text-muted">Modify the details of your reusable template.</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <form action="{{ route('doctor.templates.update', $template) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Template Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $template->title) }}" placeholder="e.g. Standard Prescription, Follow-up Note" style="border-radius: 10px; padding: 12px;">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Template Type</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" style="border-radius: 10px; height: 50px;">
                                    <option value="">Select Type</option>
                                    <option value="prescription" {{ old('type', $template->type) == 'prescription' ? 'selected' : '' }}>Prescription</option>
                                    <option value="report" {{ old('type', $template->type) == 'report' ? 'selected' : '' }}>Report</option>
                                    <option value="follow-up" {{ old('type', $template->type) == 'follow-up' ? 'selected' : '' }}>Follow-up Note</option>
                                    <option value="exam" {{ old('type', $template->type) == 'exam' ? 'selected' : '' }}>Physical Exam</option>
                                    <option value="other" {{ old('type', $template->type) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label font-weight-bold">Template Content</label>
                                <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="12" placeholder="Write your template content here..." style="border-radius: 10px; padding: 12px;">{{ old('content', $template->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg px-5" style="background-color: #3EA293; border: none; border-radius: 10px; font-weight: 700;">
                                    Update Template
                                </button>
                                <a href="{{ route('doctor.templates.index') }}" class="btn btn-outline-secondary btn-lg px-4 ml-2" style="border-radius: 10px; font-weight: 600;">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; background-color: #f8fafc;">
                    <div class="card-body p-4">
                        <h5 class="font-weight-bold mb-3" style="color: #3EA293;">Template Details</h5>
                        <p class="small text-muted mb-2"><strong>Created:</strong> {{ $template->created_at->format('M d, Y') }}</p>
                        <p class="small text-muted mb-0"><strong>Last Modified:</strong> {{ $template->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
