@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Activity Log')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Aktivitas</h5>
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small">ID</label>
                        <p class="mb-0">#{{ $activityLog->id }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small">Kategori</label>
                        <p class="mb-0"><span class="badge bg-label-primary">{{ $activityLog->log_name }}</span></p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small">Waktu</label>
                        <p class="mb-0">{{ $activityLog->created_at->format('d M Y H:i:s') }}</p>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="text-muted small">Deskripsi</label>
                        <p class="mb-0">{{ $activityLog->description }}</p>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Dilakukan Oleh</label>
                        <p class="mb-0">{{ $activityLog->causer?->name ?? 'System' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Subject</label>
                        <p class="mb-0">{{ $activityLog->subject_type ? class_basename($activityLog->subject_type) . ' #' . $activityLog->subject_id : '-' }}</p>
                    </div>
                </div>

                @if($activityLog->properties && count($activityLog->properties) > 0)
                    <hr>
                    <div class="mb-3">
                        <label class="text-muted small">Properties</label>
                        <pre class="bg-light p-3 rounded mt-2" style="max-height: 400px; overflow: auto;"><code>{{ json_encode($activityLog->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
