@extends('layouts.doctor')

@section('title', 'Patient Templates - OurPhoneMD')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 font-weight-bold text-gray-900" style="color: #1a2e35;">Patient Templates</h1>
                <p class="text-muted">Manage your reusable templates for prescriptions, reports, and more.</p>
            </div>
            <a href="{{ route('doctor.templates.create') }}" class="btn btn-primary" style="background-color: #3EA293; border: none; border-radius: 10px; font-weight: 700; padding: 12px 24px;">
                <i class="fas fa-plus mr-2"></i> Create New Template
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #ecfdf5; border-left: 5px solid #10b981; border-radius: 12px; color: #064e3b;">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            @if($templates->count() > 0)
                @foreach($templates as $template)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: transform 0.2s;">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge" style="background-color: #e6f7f3; color: #3EA293; border-radius: 6px; padding: 6px 12px; font-weight: 600;">{{ strtoupper($template->type) }}</span>
                                    <div class="dropdown">
                                        <button class="btn btn-link link-secondary p-0" data-toggle="dropdown" style="color: #999;">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm">
                                            <a class="dropdown-item" href="{{ route('doctor.templates.edit', $template) }}">
                                                <i class="fas fa-edit mr-2 text-primary"></i> Edit
                                            </a>
                                            <form action="{{ route('doctor.templates.destroy', $template) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this template?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash-alt mr-2"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="card-title font-weight-bold mb-2" style="color: #1a2e35;">{{ $template->title }}</h5>
                                <p class="card-text text-muted small flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $template->content }}
                                </p>
                                
                                <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Updated {{ $template->updated_at->diffForHumans() }}</small>
                                    <a href="{{ route('doctor.templates.edit', $template) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px; font-weight: 600;">Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5 bg-white rounded shadow-sm" style="border-radius: 15px;">
                        <div class="mb-4">
                            <i class="fas fa-file-medical-alt fa-5x" style="color: #e6f7f3;"></i>
                        </div>
                        <h4 class="text-muted">No templates created yet</h4>
                        <p class="text-muted mb-4">You can save time by creating reusable templates for your common notes and prescriptions.</p>
                        <a href="{{ route('doctor.templates.create') }}" class="btn btn-primary" style="background-color: #3EA293; border: none; border-radius: 10px; font-weight: 700; padding: 12px 24px;">
                            Create Your First Template
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(62, 162, 147, 0.1) !important;
    }
    .dropdown-item i {
        width: 16px;
    }
</style>
@endsection
