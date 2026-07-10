@php
$user = auth()->user();
@endphp

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                {{-- ================= ADMIN ================= --}}
                @if($user && $user->isSuperAdmin())

                <li>
                    <a href="{{ route('admin.dashboard.index') }}">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">PERMISSIONS & COMPANIES</li>
                <li>
                    <a href="{{ route('admin.companies.index') }}">
                        <i class="bx bx-user-circle"></i>
                        <span>Companies</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.permissions.index') }}">
                        <i class="bx bx-lock-alt"></i>
                        <span>Permission</span>
                    </a>
                </li>
                
                <li class="menu-title">Registration</li>

                <li>
                    <a href="{{ route('admin.delivery_rates.index') }}">
                        <i class="bx bxs-truck"></i>
                        <span>Visitors</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.coupons.index') }}">
                        <i class="bx bxs-discount"></i>
                        <span>Students</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.product_categories.index') }}">
                        <i class="bx bx-box"></i>
                        <span>Stall Registration</span>
                    </a>
                </li>

                {{-- ================= EMPLOYEE ================= --}}
                @elseif($user)

                    @if($user->hasAccess('dashboard'))
                    <li>
                        <a href="{{ route('admin.dashboard.index') }}">
                            <i class="bx bx-home-circle"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @endif

                    @if($user->hasAccess('orders') || $user->hasAccess('returns'))
                    <li class="menu-title">Registration</li>
                    @endif

                    @if($user->hasAccess('orders'))
                    <li>
                        <a href="{{ route('admin.orders.index') }}">
                            <i class="bx bx-cart"></i>
                            <span>Visitors</span>
                        </a>
                    </li>
                    @endif

                    @if($user->hasAccess('returns'))
                    <li>
                        <a href="{{ route('admin.returns.index') }}">
                            <i class="bx bx-undo"></i>
                            <span>Students</span>
                        </a>
                    </li>
                    @endif
                    
                @endif

            </ul>
        </div>
    </div>
</div>