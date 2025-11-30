<div class="sidebar-wrapper" data-layout="{{ getSidebarIcon() }}">
    <div>
        <div class="logo-wrapper">
            <a href="javascript:void(0)">
                <img class="img-fluid for-light" src="{{ getCompanyLogo() }}"
                    alt="{{ getSetting('company_name', 'Company') }}"
                    style="max-height: 30px; max-width: 150px; object-fit: contain;">
                <img class="img-fluid for-dark" src="{{ getCompanyLogo() }}"
                    alt="{{ getSetting('company_name', 'Company') }}"
                    style="max-height: 30px; max-width: 150px; object-fit: contain;">
            </a>
            <div class="toggle-sidebar">
                <svg class="sidebar-toggle">
                    <use href="{{ asset('assets/svg/icon-sprite.svg#toggle-icon') }}"></use>
                </svg>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="javascript:void(0)">
                <img class="img-fluid" src="{{ getCompanyLogo() }}" alt="{{ getSetting('company_name', 'Company') }}"
                    style="max-height: 25px; max-width: 25px; object-fit: contain;">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="javascript:void(0)">
                            <img class="img-fluid" src="{{ getCompanyLogo() }}"
                                alt="{{ getSetting('company_name', 'Company') }}"
                                style="max-height: 25px; max-width: 25px; object-fit: contain;">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span>
                            <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-8">Applications</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link @if (request()->routeIs('admin.dashboard')) active @endif"
                            href="{{ route('admin.dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span class="lan-3">Dashboard </span>
                        </a>
                    </li>

                    @can('user-list')
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"> </i>
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                                </svg>
                                <span>Staff</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('user-list')
                                    <li><a href="{{ route('admin.users.index') }}">Staff List</a></li>
                                @endcan
                                @can('user-create')
                                    <li><a href="{{ route('admin.users.create') }}">Create new</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"> </i>
                        <a class="sidebar-link sidebar-title @if (request()->routeIs('admin.party-plots.*')) active @endif" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                            </svg>
                            <span>Party Plots</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.party-plots.index') }}">All Party Plots</a></li>
                            <li><a href="{{ route('admin.party-plots.create') }}">Add New</a></li>
                            <li><a href="{{ route('admin.party-plots.csv-upload') }}">Upload CSV</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"> </i>
                        <a class="sidebar-link @if (request()->routeIs('admin.leads.*')) active @endif"
                            href="{{ route('admin.leads.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg>
                            <span>Leads</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>General Settings</h6>
                        </div>
                    </li>

                    @can('role-list')
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"> </i>
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#Ticket-Star') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                                </svg>
                                <span>Role</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('role-list')
                                    <li><a href="{{ route('admin.roles.index') }}">Role List</a></li>
                                @endcan
                                @can('role-create')
                                    <li><a href="{{ route('admin.roles.create') }}">Create new</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('permission-list')
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"> </i>
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                                </svg>
                                <span>Permission</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('permission-list')
                                    <li><a href="{{ route('admin.permissions.index') }}">Permission List</a></li>
                                @endcan
                                @can('permission-create')
                                    <li><a href="{{ route('admin.permissions.create') }}">Create new</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['setting-list', 'setting-create'])
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Admin Settings</h6>
                            </div>
                        </li>
                    @endcanany


                    @can('setting-list')
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"> </i>
                            <a class="sidebar-link @if (request()->routeIs('settings.*')) active @endif"
                                href="{{ route('admin.settings.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#setting') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#setting') }}"></use>
                                </svg>
                                <span>Settings</span>
                            </a>
                        </li>
                    @endcan

                    @can('admin-notification-list')
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"> </i>
                            <a class="sidebar-link @if (request()->routeIs('notifications.*')) active @endif"
                                href="{{ route('notifications.index') }}">
                                <span class="stroke-icon badge badge-secondary" style="right: 0px;top: -7px;color: #fff" id="sidebar-notification-badge">{{ \App\Models\User::first()->notifications()->whereNull('read_at')->count() }}</span>
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#notification') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#notification') }}"></use>
                                </svg>
                                <span>Notifications</span>
                            </a>
                        </li>
                    @endcan

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
