@extends('layouts.admin')

@section('css')
    <style>
        .booking-widget {
            background: var(--recent-chart-bg);
            border-radius: 15px;
            border: 1px solid var(--chart-border);
            overflow: hidden;
        }

        .booking-widget .card-header {
            background: transparent;
            border-bottom: 1px solid var(--chart-border);
            padding: 20px 25px;
        }

        .booking-widget .card-header h5 {
            color: var(--chart-text-color);
            font-weight: 600;
            font-size: 18px;
        }

        .booking-widget .card-body {
            padding: 25px;
        }

        .stat-item {
            background: var(--recent-chart-bg);
            border: 1px solid var(--chart-border);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--theme-default);
        }

        .stat-item h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--theme-default);
        }

        .stat-item h4 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-item p {
            color: var(--chart-text-color);
            font-size: 14px;
            margin: 0;
            opacity: 0.8;
        }

        .dark-only .booking-widget {
            background: var(--dark-body);
            border-color: var(--dark-border);
        }

        .dark-only .stat-item {
            background: var(--dark-body);
            border-color: var(--dark-border);
        }

        .dark-only .stat-item:hover {
            border-color: var(--theme-default);
            background: var(--dark-hover);
        }

        #bookingChart {
            min-height: 300px;
        }

        .period-selector {
            min-width: 150px;
        }

        .period-selector .form-select {
            background: var(--recent-chart-bg);
            border: 1px solid var(--chart-border);
            color: var(--chart-text-color);
            font-size: 13px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .period-selector .form-select:hover {
            border-color: var(--theme-default);
        }

        .period-selector .form-select:focus {
            border-color: var(--theme-default);
            box-shadow: 0 0 0 0.2rem rgba(var(--theme-default-rgb), 0.25);
        }

        .dark-only .period-selector .form-select {
            background: var(--dark-body);
            border-color: var(--dark-border);
            color: var(--dark-text);
        }

        .dark-only .period-selector .form-select:hover {
            border-color: var(--theme-default);
            background: var(--dark-hover);
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid default-dashboard pt-4">
        @if (getSetting('dashboard_menu') && !empty(json_decode(getSetting('dashboard_menu'), true)))
            @php
                $dashboard_menu = json_decode(getSetting('dashboard_menu'), true);
            @endphp
            <div class="row">
                @foreach ($dashboard_menu as $menu => $route)
                    <div class="col-md-3">
                        <a href="{{ route($route) }}" class="btn btn-primary w-100 pt-3 pb-3">
                            {{ ucfirst(str_replace('_', ' ', $menu)) }}
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Booking Chart Widget - Zono Theme Style -->
        <div class="row mt-4">
            <div class="col-6">
                <div class="booking-widget">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fa fa-chart-line me-2"></i>
                                Booking Statistics
                            </h5>
                            <div class="period-selector">
                                <select class="form-select form-select-sm" id="periodSelect" onchange="changePeriod()">
                                    <option value="7days">Last 7 Days</option>
                                    <option value="month">Last Month</option>
                                    <option value="year">Last Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>

            <div class="col-xl-6 box-col-7 proorder-md-1">
                <div class="card">
                    <div class="card-body premium-card">
                        <div class="row premium-courses-card">
                            <div class="col-md-5 premium-course">
                                <h1 class="f-w-700">Get Your Sales Details and More Statistics on Maintainance.</h1><a
                                    class="btn btn-square btn-primary f-w-700" href="https://www.rextertech.com/contacts">Go Premium</a>
                            </div>
                            <div class="col-md-7 premium-course-img">
                                <div class="premium-books"><img class="img-fluid" src="../assets/images/dashboard/books.gif"
                                        alt="books"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection