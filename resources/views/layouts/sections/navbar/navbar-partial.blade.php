@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
$user = Auth::user();
@endphp

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if(isset($navbarFull))
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-6">
    <a href="{{url('/')}}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">@include('_partials.macros')</span>
        <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
    </a>
</div>
@endif

<!-- ! Not required for layout-without-menu -->
@if(!isset($navbarHideToggle))
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="icon-base ri ri-menu-line icon-md"></i>
    </a>
</div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="icon-base ri ri-search-line icon-lg lh-0"></i>
            <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search...">
        </div>
    </div>
    <!-- /Search -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        @auth
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ $user->profile?->avatar_url ?? asset('assets/img/avatars/1.png') }}" alt="{{ $user->name }}" class="rounded-circle" />
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="{{ $user->profile?->avatar_url ?? asset('assets/img/avatars/1.png') }}" alt="{{ $user->name }}" class="w-42 h-42 rounded-circle" />
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-body-secondary">{{ ucfirst($user->roles->first()?->name ?? 'User') }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="icon-base ri ri-user-3-line icon-md me-3"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
                @if($user->hasRole(['super-admin', 'admin']))
                <li>
                    <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                        <i class="icon-base ri ri-settings-4-line icon-md me-3"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.activity-logs.index') }}">
                        <i class="icon-base ri ri-history-line icon-md me-3"></i>
                        <span>Activity Logs</span>
                    </a>
                </li>
                @endif
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <div class="d-grid px-4 pt-2 pb-1">
                        <button type="button" class="btn btn-danger d-flex w-100 justify-content-center" onclick="showLogoutModal()">
                            <small class="align-middle">Logout</small>
                            <i class="ri ri-logout-box-r-line ms-2 icon-xs"></i>
                        </button>
                    </div>
                </li>
            </ul>
        </li>
        <!--/ User -->
        @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        @endauth
    </ul>
</div>

@auth
@push('page-script')
<script>
function showLogoutModal() {
    // Close dropdown first
    const dropdown = document.querySelector('.dropdown-user .dropdown-menu');
    if (dropdown) {
        dropdown.classList.remove('show');
    }
    
    // Show modal after small delay
    setTimeout(() => {
        const modal = new bootstrap.Modal(document.getElementById('logoutConfirmModal'));
        modal.show();
    }, 100);
}
</script>
@endpush
@endauth