@extends('layouts.doctor')

@section('title', 'Create Template - OurPhoneMD')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="mb-4">
            <a href="{{ route('doctor.templates.index') }}" class="btn btn-link p-0 mb-2" style="color: #3EA293; text-decoration: none; font-weight: 600;">
                <i class="fas fa-arrow-left mr-2"></i> Back to Templates
            </a>
            <h1 class="h3 font-weight-bold text-gray-900" style="color: #1a2e35;">Create New Template</h1>
            <p class="text-muted">Fill in the details to create a reusable template.</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <form action="{{ route('doctor.templates.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Template Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Standard Prescription, Follow-up Note" style="border-radius: 10px; padding: 12px;">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Template Type</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" style="border-radius: 10px; height: 50px;">
                                    <option value="">Select Type</option>
                                    <option value="prescription" {{ old('type') == 'prescription' ? 'selected' : '' }}>Prescription</option>
                                    <option value="report" {{ old('type') == 'report' ? 'selected' : '' }}>Report</option>
                                    <option value="follow-up" {{ old('type') == 'follow-up' ? 'selected' : '' }}>Follow-up Note</option>
                                    <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>Physical Exam</option>
                                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label font-weight-bold">Template Content</label>
                                <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="12" placeholder="Write your template content here..." style="border-radius: 10px; padding: 12px;">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-2 d-block">This content will be reusable when writing notes or prescriptions for patients.</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg px-5" style="background-color: #3EA293; border: none; border-radius: 10px; font-weight: 700;">
                                    Save Template
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
                        <h5 class="font-weight-bold mb-3" style="color: #3EA293;">Tips & Guidelines</h5>
                        <div class="d-flex mb-3">
                            <div class="mr-2 text-primary mt-1"><i class="fas fa-info-circle"></i></div>
                            <p class="small text-muted mb-0">Use clear, descriptive titles so you can easily find your templates later.</p>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="mr-2 text-primary mt-1"><i class="fas fa-info-circle"></i></div>
                            <p class="small text-muted mb-0">You can use placeholders like [Patient Name] or [Date] if you want to remind yourself to fill them in.</p>
                        </div>
                        <div class="d-flex">
                            <div class="mr-2 text-primary mt-1"><i class="fas fa-info-circle"></i></div>
                            <p class="small text-muted mb-0">Keep templates concise but thorough to ensure clinical standards are met.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
