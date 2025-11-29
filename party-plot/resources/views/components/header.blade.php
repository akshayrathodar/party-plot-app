<!-- header Section Start-->
<div class="topbar-area d-lg-block d-none">
    <div class="container">
        <div class="topbar-wrap">
            <div class="logo-and-search-area">
                <a href="{{ route('home') }}" class="header-logo">
                    <img src="{{ asset('theme/assets/img/header-logo.svg') }}" alt="Party Plot Platform">
                </a>
                <form class="search-area" action="{{ route('search') }}" method="GET">
                    <div class="form-inner">
                        <button type="submit">
                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M15.8044 14.8855L13.0544 12.198L12.99 12.1002C12.8688 11.9807 12.7055 11.9137 12.5353 11.9137C12.3651 11.9137 12.2018 11.9807 12.0806 12.1002C9.74343 14.2443 6.14312 14.3605 3.66561 12.3724C1.18811 10.3843 0.604677 6.90645 2.30061 4.24832C3.99655 1.5902 7.44655 0.573637 10.3631 1.87332C13.2797 3.17301 14.755 6.38739 13.8125 9.38239C13.7793 9.48905 13.7753 9.60268 13.8011 9.71137C13.8269 9.82007 13.8815 9.91983 13.9591 10.0002C14.0375 10.082 14.1358 10.1421 14.2443 10.1746C14.3528 10.2071 14.4679 10.211 14.5784 10.1858C14.6883 10.1616 14.79 10.109 14.8732 10.0332C14.9564 9.95744 15.0182 9.86113 15.0525 9.75395C16.1775 6.19989 14.4781 2.37489 11.0525 0.75395C7.62686 -0.866988 3.50468 0.200824 1.35124 3.26864C-0.802198 6.33645 -0.34001 10.4818 2.43905 13.0239C5.21811 15.5661 9.47968 15.7408 12.4687 13.4377L14.9037 15.8183C15.026 15.9358 15.1889 16.0014 15.3584 16.0014C15.5279 16.0014 15.6909 15.9358 15.8131 15.8183C15.8728 15.7599 15.9201 15.6902 15.9525 15.6133C15.9848 15.5363 16.0015 15.4537 16.0015 15.3702C16.0015 15.2867 15.9848 15.2041 15.9525 15.1271C15.9201 15.0502 15.8728 14.9805 15.8131 14.9221L15.8044 14.8855Z"/>
                                </g>
                            </svg>
                        </button>
                        <input type="text" name="q" placeholder="Find Your Perfect Party Plot" value="{{ request('q') }}">
                    </div>
                </form>
            </div>
            <div class="topbar-right">
                <div class="support-and-language-area">
                    <a href="{{ route('contact') }}">Need Help?</a>
                </div>
                {{-- TODO: Add authentication routes when implementing login system --}}
                <a href="#" class="primary-btn1 black-bg" onclick="alert('Login feature coming soon!'); return false;">
                    <span>
                        <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M7.50105 7.78913C9.64392 7.78913 11.3956 6.03744 11.3956 3.89456C11.3956 1.75169 9.64392 0 7.50105 0C5.35818 0 3.60652 1.75169 3.60652 3.89456C3.60652 6.03744 5.35821 7.78913 7.50105 7.78913ZM14.1847 10.9014C14.0827 10.6463 13.9467 10.4082 13.7936 10.1871C13.0113 9.0306 11.8038 8.2653 10.4433 8.07822C10.2732 8.06123 10.0861 8.09522 9.95007 8.19727C9.23578 8.72448 8.38546 8.99658 7.50108 8.99658C6.61671 8.99658 5.76638 8.72448 5.05209 8.19727C4.91603 8.09522 4.72895 8.04421 4.5589 8.07822C3.19835 8.2653 1.97387 9.0306 1.20857 10.1871C1.05551 10.4082 0.919443 10.6633 0.817424 10.9014C0.766415 11.0034 0.783407 11.1225 0.834416 11.2245C0.970484 11.4626 1.14054 11.7007 1.2936 11.9048C1.53168 12.2279 1.78679 12.517 2.07592 12.7891C2.31401 13.0272 2.58611 13.2483 2.85824 13.4694C4.20177 14.4728 5.81742 15 7.48409 15C9.15076 15 10.7664 14.4728 12.1099 13.4694C12.382 13.2653 12.6541 13.0272 12.8923 12.7891C13.1644 12.517 13.4365 12.2279 13.6746 11.9048C13.8446 11.6837 13.9977 11.4626 14.1338 11.2245C14.2188 11.1225 14.2358 11.0034 14.1847 10.9014Z"/>
                            </g>
                        </svg>
                        Login
                    </span>
                    <span>
                        <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M7.50105 7.78913C9.64392 7.78913 11.3956 6.03744 11.3956 3.89456C11.3956 1.75169 9.64392 0 7.50105 0C5.35818 0 3.60652 1.75169 3.60652 3.89456C3.60652 6.03744 5.35821 7.78913 7.50105 7.78913ZM14.1847 10.9014C14.0827 10.6463 13.9467 10.4082 13.7936 10.1871C13.0113 9.0306 11.8038 8.2653 10.4433 8.07822C10.2732 8.06123 10.0861 8.09522 9.95007 8.19727C9.23578 8.72448 8.38546 8.99658 7.50108 8.99658C6.61671 8.99658 5.76638 8.72448 5.05209 8.19727C4.91603 8.09522 4.72895 8.04421 4.5589 8.07822C3.19835 8.2653 1.97387 9.0306 1.20857 10.1871C1.05551 10.4082 0.919443 10.6633 0.817424 10.9014C0.766415 11.0034 0.783407 11.1225 0.834416 11.2245C0.970484 11.4626 1.14054 11.7007 1.2936 11.9048C1.53168 12.2279 1.78679 12.517 2.07592 12.7891C2.31401 13.0272 2.58611 13.2483 2.85824 13.4694C4.20177 14.4728 5.81742 15 7.48409 15C9.15076 15 10.7664 14.4728 12.1099 13.4694C12.382 13.2653 12.6541 13.0272 12.8923 12.7891C13.1644 12.517 13.4365 12.2279 13.6746 11.9048C13.8446 11.6837 13.9977 11.4626 14.1338 11.2245C14.2188 11.1225 14.2358 11.0034 14.1847 10.9014Z"/>
                            </g>
                        </svg>
                        Login
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
<header class="style-1">
    <div class="container d-flex flex-nowrap align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="header-logo d-lg-none d-block">
            <img src="{{ asset('theme/assets/img/header-logo.svg') }}" alt="Party Plot Platform">
        </a>
        <div class="main-menu">
            <div class="mobile-logo-area d-lg-none d-flex align-items-center justify-content-between">
                <a href="{{ route('home') }}" class="mobile-logo-wrap">
                    <img src="{{ asset('theme/assets/img/header-logo.svg') }}" alt="Party Plot Platform">
                </a>
                <div class="menu-close-btn">
                    <i class="bi bi-x"></i>
                </div>
            </div>
            <ul class="menu-list">
                <li class="menu-item-has-children {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="drop-down">
                        Home
                    </a>
                </li>
                <li class="menu-item-has-children {{ request()->routeIs('party-plots.*') ? 'active' : '' }}">
                    <a href="#" class="drop-down">
                        Party Plots
                        <i class="bi bi-caret-down-fill"></i>
                    </a>
                    <i class="bi bi-plus dropdown-icon"></i>
                    <ul class="sub-menu">
                        <li><a href="{{ route('party-plots.index') }}">All Party Plots</a></li>
                        <li><a href="{{ route('party-plots.create') }}">List Your Plot</a></li>
                    </ul>
                </li>
                <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}">About</a>
                </li>
                <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
            <div class="contact-area d-lg-none d-flex">
                <div class="single-contact">
                    <div class="icon">
                        <img src="{{ asset('theme/assets/img/home1/icon/whatsapp-icon.svg') }}" alt="">
                    </div>
                    <div class="content">
                        <span>WhatsApp</span>
                        <a href="https://wa.me/91345533865">+91 345 533 865</a>
                    </div>
                </div>
                <i class="bi bi-caret-down-fill contact-dropdown-btn"></i>
                <ul class="contact-list">
                    <li class="single-contact">
                        <div class="icon">
                            <img src="{{ asset('theme/assets/img/home1/icon/mail-icon.svg') }}" alt="">
                        </div>
                        <div class="content">
                            <span>Mail Support</span>
                            <a href="mailto:info@partyplot.com">info@partyplot.com</a>
                        </div>
                    </li>
                </ul>
            </div>
            {{-- TODO: Add authentication routes when implementing login system --}}
            <a href="#" class="primary-btn1 black-bg d-lg-none d-flex" onclick="alert('Login feature coming soon!'); return false;">
                <span>
                    <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path
                                d="M7.50105 7.78913C9.64392 7.78913 11.3956 6.03744 11.3956 3.89456C11.3956 1.75169 9.64392 0 7.50105 0C5.35818 0 3.60652 1.75169 3.60652 3.89456C3.60652 6.03744 5.35821 7.78913 7.50105 7.78913ZM14.1847 10.9014C14.0827 10.6463 13.9467 10.4082 13.7936 10.1871C13.0113 9.0306 11.8038 8.2653 10.4433 8.07822C10.2732 8.06123 10.0861 8.09522 9.95007 8.19727C9.23578 8.72448 8.38546 8.99658 7.50108 8.99658C6.61671 8.99658 5.76638 8.72448 5.05209 8.19727C4.91603 8.09522 4.72895 8.04421 4.5589 8.07822C3.19835 8.2653 1.97387 9.0306 1.20857 10.1871C1.05551 10.4082 0.919443 10.6633 0.817424 10.9014C0.766415 11.0034 0.783407 11.1225 0.834416 11.2245C0.970484 11.4626 1.14054 11.7007 1.2936 11.9048C1.53168 12.2279 1.78679 12.517 2.07592 12.7891C2.31401 13.0272 2.58611 13.2483 2.85824 13.4694C4.20177 14.4728 5.81742 15 7.48409 15C9.15076 15 10.7664 14.4728 12.1099 13.4694C12.382 13.2653 12.6541 13.0272 12.8923 12.7891C13.1644 12.517 13.4365 12.2279 13.6746 11.9048C13.8446 11.6837 13.9977 11.4626 14.1338 11.2245C14.2188 11.1225 14.2358 11.0034 14.1847 10.9014Z"/>
                        </g>
                    </svg>
                    Login
                </span>
                <span>
                    <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path
                                d="M7.50105 7.78913C9.64392 7.78913 11.3956 6.03744 11.3956 3.89456C11.3956 1.75169 9.64392 0 7.50105 0C5.35818 0 3.60652 1.75169 3.60652 3.89456C3.60652 6.03744 5.35821 7.78913 7.50105 7.78913ZM14.1847 10.9014C14.0827 10.6463 13.9467 10.4082 13.7936 10.1871C13.0113 9.0306 11.8038 8.2653 10.4433 8.07822C10.2732 8.06123 10.0861 8.09522 9.95007 8.19727C9.23578 8.72448 8.38546 8.99658 7.50108 8.99658C6.61671 8.99658 5.76638 8.72448 5.05209 8.19727C4.91603 8.09522 4.72895 8.04421 4.5589 8.07822C3.19835 8.2653 1.97387 9.0306 1.20857 10.1871C1.05551 10.4082 0.919443 10.6633 0.817424 10.9014C0.766415 11.0034 0.783407 11.1225 0.834416 11.2245C0.970484 11.4626 1.14054 11.7007 1.2936 11.9048C1.53168 12.2279 1.78679 12.517 2.07592 12.7891C2.31401 13.0272 2.58611 13.2483 2.85824 13.4694C4.20177 14.4728 5.81742 15 7.48409 15C9.15076 15 10.7664 14.4728 12.1099 13.4694C12.382 13.2653 12.6541 13.0272 12.8923 12.7891C13.1644 12.517 13.4365 12.2279 13.6746 11.9048C13.8446 11.6837 13.9977 11.4626 14.1338 11.2245C14.2188 11.1225 14.2358 11.0034 14.1847 10.9014Z"/>
                        </g>
                    </svg>
                    Login
                </span>
            </a>
        </div>
        <div class="nav-right">
            <div class="contact-area d-lg-flex d-none">
                <div class="single-contact">
                    <div class="icon">
                        <img src="{{ asset('theme/assets/img/home1/icon/whatsapp-icon.svg') }}" alt="">
                    </div>
                    <div class="content">
                        <span>WhatsApp</span>
                        <a href="https://wa.me/91345533865">+91 345 533 865</a>
                    </div>
                </div>
                <i class="bi bi-caret-down-fill contact-dropdown-btn"></i>
                <ul class="contact-list">
                    <li class="single-contact">
                        <div class="icon">
                            <img src="{{ asset('theme/assets/img/home1/icon/mail-icon.svg') }}" alt="">
                        </div>
                        <div class="content">
                            <span>Mail Support</span>
                            <a href="mailto:info@partyplot.com">info@partyplot.com</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="sidebar-button mobile-menu-btn">
                <svg width="20" height="18" viewBox="0 0 20 18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.29445 2.8421H10.5237C11.2389 2.8421 11.8182 2.2062 11.8182 1.42105C11.8182 0.635903 11.2389 0 10.5237 0H1.29445C0.579249 0 0 0.635903 0 1.42105C0 2.2062 0.579249 2.8421 1.29445 2.8421Z"></path>
                    <path d="M1.23002 10.421H18.77C19.4496 10.421 20 9.78506 20 8.99991C20 8.21476 19.4496 7.57886 18.77 7.57886H1.23002C0.550421 7.57886 0 8.21476 0 8.99991C0 9.78506 0.550421 10.421 1.23002 10.421Z"></path>
                    <path d="M18.8052 15.1579H10.2858C9.62563 15.1579 9.09094 15.7938 9.09094 16.5789C9.09094 17.3641 9.62563 18 10.2858 18H18.8052C19.4653 18 20 17.3641 20 16.5789C20 15.7938 19.4653 15.1579 18.8052 15.1579Z"></path>
                </svg>
            </div>
        </div>
    </div>
</header>
<!-- header Section End-->

