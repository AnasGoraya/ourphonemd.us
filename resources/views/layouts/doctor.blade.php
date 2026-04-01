@extends('adminlte::master')

@section('title', 'Doctor Dashboard - OurPhoneMD')

@section('plugins.Datatables', false)
@section('plugins.TempusDominusBs4', false)
@section('plugins.TempusDominusBs5', false)
@section('plugins.Select2', false)
@section('plugins.Chartjs', false)
@section('plugins.Sweetalert2', false)
@section('plugins.Toastr', false)
@section('plugins.IziToast', false)
@section('plugins.FontAwesome', false)

@section('adminlte_css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --body-bg: #f8fafc;
            --header-bg: #fff;
            --header-border: #e5e7eb;
            --sidebar-bg: #fff;
            --sidebar-border: #ffffff;
            --content-bg: #f8fafc;
            --text-primary: #1a2e35;
            --text-secondary: #666;
            --nav-text: #1a2e35;
            --card-bg: white;
            --card-text: #1a1a1a;
        }

        body.dark-theme {
            --body-bg: #000;
            --header-bg: #111;
            --header-border: #222;
            --sidebar-bg: #111;
            --sidebar-border: #222;
            --content-bg: #000;
            --text-primary: #fff;
            --text-secondary: #ddd;
            --nav-text: #fff;
            --card-bg: #1a1a1a;
            --card-text: #fff;
        }

        body {
            background: var(--body-bg);
            transition: background 0.3s ease;
        }

        .main-header {
            background: var(--header-bg) !important;
            border-bottom: 1px solid var(--header-border) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            min-height: 64px;
            padding: 20px 0;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        /* Reduce width of main header */
        nav.main-header {
            max-width: 95%;
            margin-left: auto;
            margin-right: auto;
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .navbar-nav .nav-link {
            color: var(--nav-text) !important;
            font-weight: 500;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #3EA293 !important;
        }

        .action-btn,
        .action-btn.secondary {
            background: #3EA293 !important;
            color: #fff !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            padding: 10px 24px !important;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.08);
            border: none;
            margin-right: 10px;
            transition: background 0.2s;
        }

        .action-btn.secondary {
            background: #51A897 !important;
        }

        .action-btn:hover,
        .action-btn.secondary:hover {
            background: #2e8c7e !important;
            color: #fff !important;
        }

        .main-sidebar {
            background: var(--sidebar-bg) !important;
            border-right: 1.5px solid var(--sidebar-border) !important;
            min-width: 250px;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        /* Remove shadow from aside menu */
        aside.main-sidebar.elevation-4 {
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        /* Lighten the left border of sidebar navigation */
        .sidebar .nav-sidebar {
            border-left: 2.5px solid #ffffff;
            padding-left: 8px;
        }

        .sidebar .nav-sidebar .nav-link {
            color: var(--nav-text) !important;
            font-size: 16px;
            font-weight: 500;
            border-radius: 6px;
            margin-bottom: 6px;
            padding: 10px 18px;
            transition: all 0.3s ease;
            border: none !important;
            box-shadow: none !important;
        }

        /* Active state styles - No border, no shadow */
        .sidebar .nav-sidebar .nav-link.active {
            background: #EDF6F4 !important;
            color: #62B1A1 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .sidebar .nav-sidebar .nav-link.active .nav-icon {
            color: #62B1A1 !important;
        }

        .sidebar .nav-sidebar .nav-link.active p {
            color: #51A897 !important;
            font-weight: 600;
        }

        .sidebar .nav-sidebar .nav-link:hover {
            background: #e6f7f3 !important;
            color: #3EA293 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .sidebar .nav-icon {
            margin-right: 10px;
            font-size: 18px;
            transition: color 0.2s;
            -webkit-text-stroke:3px #000000;
            paint-order: stroke fill;
            color: white !important;
            text-shadow: none !important;
        }

        /* For active and hover states */
        .sidebar .nav-sidebar .nav-link.active .nav-icon {
            -webkit-text-stroke: 2px #62B1A1 !important;
            color: white !important;
        }

        .sidebar .nav-sidebar .nav-link:hover .nav-icon {
            -webkit-text-stroke: 2px #3EA293 !important;
            color: white !important;
        }

        .sidebar .user-panel {
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 18px;
            padding-bottom: 12px;
        }

        .sidebar .user-panel .info a {
            color: #1a2e35 !important;
            font-weight: 600;
        }

        .content-wrapper {
            background: var(--content-bg) !important;
            border-left: 2px solid #d3d3d3 !important;
            min-height: 100vh;
            transition: background 0.3s ease;
        }

        .main-footer {
            background: #fff;
            border-top: 1px solid #e5e7eb;
            color: #888;
            font-size: 15px;
        }

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }

        .stat-card {
            background: #f9fdfc;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.07);
            padding: 32px 24px 24px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 180px;
            position: relative;
            border: 1.5px solid #e5e7eb;
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 24px;
        }

        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1a2e35;
            margin-bottom: 6px;
        }

        .stat-card .stat-label {
            color: #3EA293;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .stat-card .stat-link {
            color: #1976d2;
            font-size: 0.98rem;
            font-weight: 500;
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .support-card {
            background: linear-gradient(135deg, #67e8f9 0%, #3EA293 100%);
            color: #fff;
            padding: 32px 24px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 180px;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.10);
        }

        .support-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .support-subtitle {
            font-size: 1.05rem;
            opacity: 0.95;
            margin-bottom: 18px;
        }

        .support-btn {
            background: #fff;
            color: #3EA293;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.08);
            transition: background 0.2s, color 0.2s;
        }

        .support-btn:hover {
            background: #e6f7f3;
            color: #1976d2;
        }

        /* Divider lines */
        .sidebar hr,
        .main-header hr {
            border: none;
            border-top: 1.5px solid #e5e7eb;
            margin: 12px 0;
        }

        .sidebar .nav-sidebar {
            border-left: 2.5px solid #e5e7eb;
            padding-left: 8px;
        }

        /* New styles for header dropdown */
        .user-dropdown {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .user-dropdown:hover {
            background: #f5f5f5;
        }

        .user-email {
            margin-right: 8px;
            font-weight: 500;
            color: #1a2e35;
        }

        .dropdown-icon {
            font-size: 12px;
            color: #6b7280;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 8px 0;
            min-width: 160px;
        }

        .dropdown-item {
            padding: 8px 16px;
            color: #1a2e35;
            display: flex;
            align-items: center;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: #e6f7f3;
            color: #3EA293;
        }

        .dropdown-item i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
            color: #51A897 !important;
        }
        .user-profile-icon {
            font-size: 18px;
            color: #51A897;
            background-color: transparent !important;
            vertical-align: middle;
        }

        /* Header Action Buttons */
        .header-action-btn {
            background: #3EA293 !important;
            color: #fff !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 8px 16px !important;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.08);
            border: none;
            margin-right: 8px;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .header-action-btn:hover {
            background: #2e8c7e !important;
            color: #fff !important;
            text-decoration: none;
        }

        .header-action-btn svg {
            width: 16px;
            height: 16px;
        }

        /* Theme Toggle Button */
        .theme-toggle-btn {
            background: #222 !important;
            color: #fff !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 8px 16px !important;
            border: none;
            margin-right: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .theme-toggle-btn:hover {
            background: #333 !important;
        }

        .theme-toggle-btn.light {
            background: #f3f3f3 !important;
            color: #222 !important;
        }

        .theme-toggle-btn.light:hover {
            background: #e0e0e0 !important;
        }

        body.dark-theme .user-email,
        body.dark-theme .navbar-brand span {
            color: var(--text-primary) !important;
        }
    </style>
@stop

@section('body')
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-lightgreen navbar-light"
            style="background-color: white !important; border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('doctor.dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <script>
                // Header patient search overlay
                document.addEventListener('DOMContentLoaded', function(){
                    const headerBtn = document.getElementById('headerSearchBtn');
                    if(!headerBtn) return;
                    // create overlay
                    const overlayHtml = `
                        <div id="headerPatientSearchOverlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.25); z-index:1400;">
                            <div style="max-width:720px; margin:80px auto; background:#fff; border-radius:8px; padding:14px; position:relative;">
                                <button id="headerPatientSearchClose" style="position:absolute; right:12px; top:8px; background:none; border:none; font-size:18px;">&times;</button>
                                <input id="headerPatientSearchInput" placeholder="Search patient by name or email..." style="width:100%; padding:12px; border-radius:6px; border:1px solid #e6eef5; font-size:16px;" />
                                <div id="headerPatientSearchResults" style="margin-top:10px; max-height:340px; overflow:auto; border-radius:6px; padding:6px; border:1px solid #f1f5f7;"></div>
                            </div>
                        </div>`;
                    document.body.insertAdjacentHTML('beforeend', overlayHtml);
                    const overlay = document.getElementById('headerPatientSearchOverlay');
                    const input = document.getElementById('headerPatientSearchInput');
                    const results = document.getElementById('headerPatientSearchResults');
                    document.getElementById('headerPatientSearchClose').addEventListener('click', ()=> overlay.style.display='none');

                    let debounceTimer = null;
                    function renderResults(items){
                        results.innerHTML = '';
                        if(!items || items.length===0){ results.innerHTML = '<div style="color:#666;padding:10px">No matches</div>'; return; }
                        items.forEach(p=>{
                            const row = document.createElement('div');
                            row.style.padding='10px'; row.style.borderBottom='1px solid #f3f4f6'; row.style.cursor='pointer';
                            row.innerHTML = `<div style="font-weight:700;color:#0f172a">${p.name}</div><div style="color:#6b7280;font-size:13px">${p.email||''}</div>`;
                            row.addEventListener('click', ()=>{ overlay.style.display='none'; window.location.href = '/doctor/patients/'+p.id; });
                            results.appendChild(row);
                        });
                    }

                    input.addEventListener('input', function(){
                        const q = this.value.trim();
                        if(debounceTimer) clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(()=>{
                            if(!q){ results.innerHTML=''; return; }
                            fetch('/api/doctor/patient-search', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify({q:q})})
                            .then(r=>r.json()).then(json=>{
                                const data = json.data||[];
                                // filter startsWith for name/email
                                const ql = q.toLowerCase();
                                const filtered = data.filter(d=> (d.name && d.name.toLowerCase().startsWith(ql)) || (d.email && d.email.toLowerCase().startsWith(ql)) );
                                renderResults(filtered);
                            }).catch(()=>{ results.innerHTML = '<div style="color:#c53030;padding:10px">Search failed</div>'; });
                        }, 220);
                    });

                    headerBtn.addEventListener('click', function(e){ e.preventDefault(); overlay.style.display = 'block'; input.value=''; results.innerHTML=''; input.focus(); });
                });
            </script>

            <!-- Center navbar links -->
            <ul class="navbar-nav mx-auto" style="transform: translateX(180px);">
                <li class="nav-item" style="margin-right: 8px;">
                    <a href="#" id="doctorBookBtn" class="header-action-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Book New Appointment
                    </a>
                </li>
                <li class="nav-item" style="margin-right: 8px;">
                    <a href="{{ url('doctor/patients/create') }}" class="header-action-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                            </path>
                        </svg>
                        Add New Patient
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" id="headerSearchBtn" class="header-action-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                            </path>
                        </svg>
                        Search Patient
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto" >
                <li class="nav-item" style="margin-right: 8px;">
                    <button class="theme-toggle-btn light" id="themeToggleBtn" title="Toggle dark/light mode">
                        <i class="fas fa-moon"></i>
                    </button>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link user-dropdown" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-user-md user-profile-icon"></i>
                        <span class="user-email" style="margin-left: 5px;">Dr. {{ Auth::user()->name }}</span>
                        <i class="dropdown-icon fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('patient.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('patient.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4"
            style="background-color: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(10px) !important; -webkit-backdrop-filter: blur(10px) !important;">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center justify-content-center" href="{{ route('doctor.dashboard') }}"
                style="font-size: 20px; font-weight: 600; margin-top: 20px; padding: 0 10px; text-align: center; width: 100%;">
                <i class="fas fa-stethoscope me-1" style="color: black; font-size: 16px;"></i>
                <span style="color: #3EA293;">OurPhone</span><span style="color: #FF3B3B;">MD</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    {{-- <div class="info">
                        <a href="#" class="d-block"
                            style="color: black !important;">{{ Auth::guard('patient')->user()->first_name }}
                            {{ Auth::guard('patient')->user()->last_name }}</a>
                    </div> --}}
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <!-- Simplified Sidebar Menu -->
                        <li class="nav-item">
                            <a href="{{ route('doctor.dashboard') }}" onclick="event.preventDefault(); if(typeof showDoctorDashboard === 'function'){ showDoctorDashboard(); history.pushState(null, '', '{{ route('doctor.dashboard') }}'); } else { window.location.href='{{ route('doctor.dashboard') }}' }" class="nav-link {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-home"></i>
                                <p style="color: black !important;">Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('doctor.appointments.upcoming') }}" onclick="event.preventDefault(); if(typeof showUpcomingAppointmentsCalendar === 'function'){ showUpcomingAppointmentsCalendar(); history.pushState(null, '', '{{ route('doctor.appointments.upcoming') }}'); } else { window.location.href='{{ route('doctor.appointments.upcoming') }}' }" class="nav-link {{ request()->routeIs('doctor.appointments.upcoming') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p style="color: black !important;">Appointments</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('doctor/patients') }}" class="nav-link {{ request()->is('doctor/patients*') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-users"></i>
                                <p style="color: black !important;">Patients</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('doctor.templates.index') }}" class="nav-link {{ request()->routeIs('doctor.templates.*') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-file-medical"></i>
                                <p style="color: black !important;">Patient Templates</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('doctor/patients/create') }}" class="nav-link {{ request()->is('doctor/patients/create') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p style="color: black !important;">Add New Patient</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('doctor.contact') }}" class="nav-link {{ request()->routeIs('doctor.contact') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p style="color: black !important;">Contact us</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper"
            style="background-color: white !important; border-left: 2px solid rgb(87, 165, 150);">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            {{-- <strong>Copyright &copy; 2024 OurPhoneMD.</strong>. --}}
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeBtn = document.getElementById('themeToggleBtn');
            const body = document.body;

            // Load saved theme preference
            const savedTheme = localStorage.getItem('doctorDashboardTheme');
            if (savedTheme === 'dark') {
                setDarkTheme();
            } else {
                setLightTheme();
            }

            // Theme toggle click handler
            themeBtn.addEventListener('click', function() {
                if (body.classList.contains('dark-theme')) {
                    setLightTheme();
                    localStorage.setItem('doctorDashboardTheme', 'light');
                } else {
                    setDarkTheme();
                    localStorage.setItem('doctorDashboardTheme', 'dark');
                }
            });

            function setDarkTheme() {
                body.classList.add('dark-theme');
                themeBtn.classList.remove('light');
                themeBtn.innerHTML = '<i class="fas fa-sun"></i>';
            }

            function setLightTheme() {
                body.classList.remove('dark-theme');
                themeBtn.classList.add('light');
                themeBtn.innerHTML = '<i class="fas fa-moon"></i>';
            }
        });
    </script>

    @yield('scripts')
@stop
