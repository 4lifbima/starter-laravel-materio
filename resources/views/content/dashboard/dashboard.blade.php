@extends('layouts/contentNavbarLayout')
@section('title', 'Dashboard')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection
@section('vendor-script')
@vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('content')
<div class="row gy-4">
    <!-- Welcome Card -->
    <div class="col-md-12 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title mb-1">Selamat Datang, {{ auth()->user()->name }}! 🎉</h5>
                <p class="mb-2 text-muted">{{ now()->translatedFormat('l, d F Y') }}</p>
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-sm me-3">
                            <div class="avatar-initial bg-label-primary rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $newUsersToday }}</h6>
                            <small class="text-muted">User Baru Hari Ini</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3">
                            <div class="avatar-initial bg-label-success rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $todayLogins }}</h6>
                            <small class="text-muted">Login Hari Ini</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="card-title mb-1">Statistik User</h5>
                <p class="text-muted mb-0">Overview data pengguna sistem</p>
            </div>
            <div class="card-body pt-4">
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <div class="avatar-initial bg-primary rounded shadow-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                            </div>
                            <div class="ms-3">
                                <p class="mb-0 text-muted">Total User</p>
                                <h4 class="mb-0">{{ number_format($totalUsers) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <div class="avatar-initial bg-success rounded shadow-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
                                </div>
                            </div>
                            <div class="ms-3">
                                <p class="mb-0 text-muted">Aktif</p>
                                <h4 class="mb-0">{{ number_format($activeUsers) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <div class="avatar-initial bg-warning rounded shadow-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                                </div>
                            </div>
                            <div class="ms-3">
                                <p class="mb-0 text-muted">Inactive</p>
                                <h4 class="mb-0">{{ number_format($inactiveUsers) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <div class="avatar-initial bg-danger rounded shadow-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="18" y1="8" x2="23" y2="13"/><line x1="23" y1="8" x2="18" y2="13"/></svg>
                                </div>
                            </div>
                            <div class="ms-3">
                                <p class="mb-0 text-muted">Banned</p>
                                <h4 class="mb-0">{{ number_format($bannedUsers) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Growth Chart -->
    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1">Pertumbuhan User</h5>
                    <p class="text-muted mb-0">7 hari terakhir</p>
                </div>
                <div class="d-flex align-items-center">
                    <h4 class="mb-0 me-2">{{ $usersThisMonth }}</h4>
                    <span class="badge bg-label-{{ $userGrowthPercentage >= 0 ? 'success' : 'danger' }}">
                        {{ $userGrowthPercentage >= 0 ? '+' : '' }}{{ $userGrowthPercentage }}%
                    </span>
                </div>
            </div>
            <div class="card-body pt-2">
                <div id="userGrowthChart"></div>
            </div>
        </div>
    </div>

    <!-- Activity by Type Chart -->
    <div class="col-xl-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-1">Aktivitas Berdasarkan Kategori</h5>
                <p class="text-muted mb-0">30 hari terakhir</p>
            </div>
            <div class="card-body">
                <div id="activityByTypeChart"></div>
            </div>
        </div>
    </div>

    <!-- Users by Role -->
    <div class="col-xl-4 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">User Berdasarkan Role</h5>
            </div>
            <div class="card-body">
                <div id="usersByRoleChart"></div>
                <div class="mt-4">
                    @foreach($usersByRole as $role)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-label-primary me-2">{{ ucfirst($role->name) }}</span>
                        </div>
                        <span class="fw-semibold">{{ $role->users_count }} users</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Activity Trend -->
    <div class="col-xl-8 col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-1">Trend Aktivitas Bulanan</h5>
                <p class="text-muted mb-0">6 bulan terakhir</p>
            </div>
            <div class="card-body">
                <div id="monthlyActivityChart"></div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivities as $activity)
                        <tr>
                            <td>
                                <small>{{ $activity->created_at->format('d M, H:i') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $activity->log_name == 'auth' ? 'primary' : ($activity->log_name == 'user' ? 'info' : 'secondary') }}">
                                    {{ $activity->log_name }}
                                </span>
                            </td>
                            <td>{{ Str::limit($activity->description, 40) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <img src="{{ $activity->causer?->profile?->avatar_url ?? asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <span>{{ $activity->causer?->name ?? 'System' }}</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada aktivitas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color configuration
    const primaryColor = '#7367f0';
    const successColor = '#28c76f';
    const warningColor = '#ff9f43';
    const dangerColor = '#ea5455';
    const infoColor = '#00cfe8';
    const secondaryColor = '#82868b';
    
    // User Growth Chart
    const userGrowthOptions = {
        series: [{
            name: 'User Baru',
            data: @json($userGrowthData)
        }],
        chart: {
            height: 250,
            type: 'area',
            toolbar: { show: false },
            sparkline: { enabled: false }
        },
        colors: [primaryColor],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.2,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: @json($userGrowthLabels),
            labels: { style: { colors: secondaryColor } }
        },
        yaxis: {
            labels: { style: { colors: secondaryColor } }
        },
        grid: { borderColor: '#f1f1f1' },
        tooltip: { theme: 'light' }
    };
    new ApexCharts(document.querySelector("#userGrowthChart"), userGrowthOptions).render();

    // Activity by Type Chart
    const activityData = @json($activityByType);
    const activityByTypeOptions = {
        series: Object.values(activityData),
        chart: {
            height: 250,
            type: 'donut'
        },
        labels: Object.keys(activityData).map(k => k.charAt(0).toUpperCase() + k.slice(1)),
        colors: [primaryColor, successColor, warningColor, dangerColor, infoColor],
        legend: {
            position: 'bottom',
            labels: { colors: secondaryColor }
        },
        dataLabels: { enabled: true },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function(w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: { chart: { height: 300 } }
        }]
    };
    if (Object.keys(activityData).length > 0) {
        new ApexCharts(document.querySelector("#activityByTypeChart"), activityByTypeOptions).render();
    } else {
        document.querySelector("#activityByTypeChart").innerHTML = '<p class="text-center text-muted py-5">Belum ada data aktivitas</p>';
    }

    // Users by Role Chart
    const roleData = @json($usersByRole->pluck('users_count', 'name')->toArray());
    const usersByRoleOptions = {
        series: Object.values(roleData),
        chart: {
            height: 200,
            type: 'pie'
        },
        labels: Object.keys(roleData).map(k => k.charAt(0).toUpperCase() + k.slice(1)),
        colors: [primaryColor, successColor, warningColor, infoColor],
        legend: { show: false },
        dataLabels: { enabled: false },
        responsive: [{
            breakpoint: 480,
            options: { chart: { height: 150 } }
        }]
    };
    new ApexCharts(document.querySelector("#usersByRoleChart"), usersByRoleOptions).render();

    // Monthly Activity Chart
    const monthlyActivityOptions = {
        series: [{
            name: 'Aktivitas',
            data: @json($monthlyActivityData)
        }],
        chart: {
            height: 280,
            type: 'bar',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '50%',
                distributed: false
            }
        },
        colors: [primaryColor],
        dataLabels: { enabled: false },
        xaxis: {
            categories: @json($monthlyActivityLabels),
            labels: { style: { colors: secondaryColor } }
        },
        yaxis: {
            labels: { style: { colors: secondaryColor } }
        },
        grid: { borderColor: '#f1f1f1' },
        tooltip: { theme: 'light' }
    };
    new ApexCharts(document.querySelector("#monthlyActivityChart"), monthlyActivityOptions).render();
});
</script>
@endsection
