@extends('layouts/contentNavbarLayout')

@section('title', 'Detail User')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="avatar avatar-xl mb-3 mx-auto">
                    <img src="{{ $user->profile?->avatar_url ?? asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <div class="d-flex justify-content-center gap-2 mb-3">
                    @foreach($user->roles as $role)
                        <span class="badge bg-label-primary">{{ ucfirst($role->name) }}</span>
                    @endforeach
                </div>
                @if($user->status === 'active')
                    <span class="badge bg-label-success">Active</span>
                @elseif($user->status === 'inactive')
                    <span class="badge bg-label-warning">Inactive</span>
                @else
                    <span class="badge bg-label-danger">Banned</span>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informasi Akun</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <span class="text-muted">ID:</span>
                        <span class="float-end">#{{ $user->id }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="text-muted">Bergabung:</span>
                        <span class="float-end">{{ $user->created_at->format('d M Y') }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="text-muted">Login Terakhir:</span>
                        <span class="float-end">{{ $user->last_login_at?->format('d M Y H:i') ?? '-' }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="text-muted">IP Terakhir:</span>
                        <span class="float-end">{{ $user->last_login_ip ?? '-' }}</span>
                    </li>
                    <li class="mb-0">
                        <span class="text-muted">No. Telepon:</span>
                        <span class="float-end">{{ $user->profile?->phone_number ?? '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Profil</h6>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                    <i class="ri-edit-line me-1"></i>Edit
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Bio</label>
                        <p>{{ $user->profile?->bio ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Alamat</label>
                        <p>{{ $user->profile?->address ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Riwayat Aktivitas</h6>
            </div>
            <div class="card-body">
                @if($activities->count() > 0)
                    <ul class="timeline mb-0">
                        @foreach($activities as $activity)
                            <li class="timeline-item {{ !$loop->last ? 'timeline-item-transparent pb-3' : '' }}">
                                <span class="timeline-point timeline-point-primary"></span>
                                <div class="timeline-event">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">{{ $activity->description }}</h6>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">
                                        Oleh: {{ $activity->causer?->name ?? 'System' }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0 text-center py-4">Belum ada aktivitas</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
