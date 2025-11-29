<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"><a href="index.html">
                <img class="img-fluid for-light" src="{{ getCompanyLogo() }}" alt="{{ getSetting('company_name', 'Company') }}" style="max-height: 40px; max-width: 200px; object-fit: contain;">
                    <img class="img-fluid for-dark" src="{{ getCompanyLogo() }}"
                        alt="{{ getSetting('company_name', 'Company') }}" style="max-height: 40px; max-width: 200px; object-fit: contain;"></a></div>
            <div class="toggle-sidebar">
                <svg class="sidebar-toggle">
                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-animation') }}"></use>
                </svg>
            </div>
        </div>
        <div class="col-sm-4 form-inline search-full d-none d-xl-block">
            {{-- <div class="form-group">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                            placeholder="Type to Search .." name="q" title="" autofocus>
                        <svg class="search-bg svg-color">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#search') }}"></use>
                        </svg>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="nav-right col-xl-8 col-lg-12 col-auto pull-right right-header p-0">
            <ul class="nav-menus">
                @can('admin-notification-list')
                <li class="onhover-dropdown">
                    <div class="notification-toggle">
                        <svg>
                            <use href="{{ asset('assets/svg/icon-sprite.svg#notification') }}"></use>
                        </svg>
                        <span class="badge rounded-pill notification-badge" id="notification-badge" style="display: none;">0</span>
                    </div>
                    <ul class="notification-dropdown-menu onhover-show-div">
                        <li>
                            <div class="notification-title-section">
                                <span class="notification-title-text">Notifications</span>
                                <button class="btn btn-sm btn-outline-primary ms-2" onclick="if(window.adminNotifications) window.adminNotifications.refreshNotifications()" title="Refresh">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </li>
                        <li>
                            <div class="notification-list" id="notification-list" style="max-height: 400px; overflow-y: auto;">
                                <!-- Notifications will be loaded here -->
                                <div class="text-center py-3">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-muted mt-2 mb-0">Loading notifications...</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-footer text-center">
                                <a href="#" class="btn btn-primary btn-sm">View All</a>
                            </div>
                        </li>
                    </ul>
                </li>
                @endcan

                <li class="profile-nav onhover-dropdown pe-0 py-0">
                    <div class="d-flex align-items-center profile-media">
                        @if (Auth::check() && isset(Auth::user()->staff_photo) && file_exists(public_path('uploads/staffs/'.Auth::user()->staff_photo)))
                        <img class="b-r-25" style="width: 40px; height: 40px;"
                            src="{{ asset('uploads/staffs/'.Auth::user()->staff_photo) }}" alt="">
                        @else
                        <img class="b-r-25" style="width: 40px; height: 40px;"
                            src="{{ asset('uploads/staffs/default.png') }}" alt="">
                        @endif
                        <div class="flex-grow-1 user">
                            @if (Auth::check())
                                <span>{{ Auth::user()->name }}</span>
                            @else
                                <span>Unknown User</span>
                            @endif
                            @if (Auth::check())
                            <p class="mb-0 font-nunito"> {{ Auth::user()->getRoleNames()->first() }}
                                <svg>
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#header-arrow-down') }}"></use>
                                </svg>
                            </p>
                            @endif
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="{{ route('admin.profile') }}"><i data-feather="user"></i><span>Profile </span></a></li>
                        @can('setting-list')
                        <li><a href="{{ route('admin.settings.index') }}"><i data-feather="settings"></i><span>Settings</span></a></li>
                        @endcan
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
                                @csrf
                                <button class="text-danger border-0 p-0 bg-transparent" type="submit">
                                    <i data-feather="log-in"></i><span>Log Out</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">name</div>
            </div>
            </div>
        </script>
        <script class="empty-template" type="text/x-handlebars-template">
            <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div>
        </script>
    </div>
</div>

