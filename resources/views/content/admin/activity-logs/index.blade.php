@extends('layouts/contentNavbarLayout')

@section('title', 'Activity Logs')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Activity Logs</h5>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                </span>
                                <input type="text" class="form-control" name="search" placeholder="Cari deskripsi..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="date_from" placeholder="Dari Tanggal" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="date_to" placeholder="Sampai Tanggal" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>User</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                                <tr>
                                    <td>
                                        <small class="text-muted">{{ $activity->created_at->format('d M Y, H:i') }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $colors = [
                                                'auth' => 'primary',
                                                'user' => 'info',
                                                'role' => 'warning',
                                                'permission' => 'secondary',
                                                'settings' => 'success',
                                            ];
                                        @endphp
                                        <span class="badge bg-label-{{ $colors[$activity->log_name] ?? 'secondary' }}">
                                            {{ ucfirst($activity->log_name) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($activity->description, 50) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <img src="{{ $activity->causer?->profile?->avatar_url ?? asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle">
                                            </div>
                                            <span>{{ $activity->causer?->name ?? 'System' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.activity-logs.show', $activity) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada aktivitas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($activities->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Menampilkan {{ $activities->firstItem() ?? 0 }} - {{ $activities->lastItem() ?? 0 }} dari {{ $activities->total() }} data
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($activities->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">‹</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $activities->previousPageUrl() }}">‹</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                                @if ($page == $activities->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($activities->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $activities->nextPageUrl() }}">›</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">›</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
