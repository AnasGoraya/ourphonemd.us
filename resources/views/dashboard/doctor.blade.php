@extends('layouts.doctor')

@section('title', 'Doctor Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<style>
    .dashboard-container {
        background: transparent;
        min-height: 100vh;
        padding: 0;
    }

    .dashboard-header {
        margin-bottom: 25px;
        display: none;
    }

    .dashboard-header h2 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .dashboard-header p {
        color: #7f8c8d;
        font-size: 14px;
    }

    .appointment-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 25px;
    }

    @media (max-width: 1400px) {
        .appointment-cards {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 1024px) {
        .appointment-cards {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .appointment-card.cancelled .card-icon {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .appointment-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    body.dark-theme .appointment-card {
        background: #1a1a1a;
        box-shadow: 0 1px 3px rgba(255,255,255,0.05);
    }

    .appointment-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transform: translateY(-1px);
    }

    body.dark-theme .appointment-card:hover {
        box-shadow: 0 4px 12px rgba(255,255,255,0.1);
    }

    .card-icon {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        margin-bottom: 12px;
    }

    .appointment-card.upcoming .card-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .appointment-card.finished .card-icon {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .appointment-card.walk-in .card-icon {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .appointment-card.unfinished .card-icon {
        background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);
    }

    .appointment-card.followup .card-icon {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
    }

    .appointment-card.unconfirmed .card-icon {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    }

    .card-title {
        font-size: 12px;
        font-weight: 600;
        color: #666;
        text-transform: capitalize;
        letter-spacing: 0.3px;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    body.dark-theme .card-title {
        color: #ddd;
    }

    .card-number {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    body.dark-theme .card-number {
        color: #fff;
    }

    .view-details-link {
        color: #20c997;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .view-details-link:hover {
        color: #1aa179;
    }

    .doctor-info-card {
        background: white;
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        margin-top: 20px;
    }

    body.dark-theme .doctor-info-card {
        background: #1a1a1a;
        box-shadow: 0 1px 3px rgba(255,255,255,0.05);
    }

    .doctor-info-card h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
    }

    body.dark-theme .doctor-info-card h5 {
        color: #fff;
    }

    .doctor-info-row {
        display: flex;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .doctor-info-label {
        font-weight: 600;
        color: #333;
        min-width: 120px;
    }

    body.dark-theme .doctor-info-label {
        color: #ddd;
    }

    .doctor-info-value {
        color: #666;
    }

    body.dark-theme .doctor-info-value {
        color: #bbb;
    }

    .alert {
        border-radius: 8px;
        margin-bottom: 20px;
        border: none;
    }

    .page-header-section {
        background: white;
        padding: 24px 0;
        margin-bottom: 25px;
        border-bottom: 1px solid #e5e7eb;
    }

    body.dark-theme .page-header-section {
        background: #111;
        border-bottom: 1px solid #222;
    }

    .page-header-content h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    body.dark-theme .page-header-content h1 {
        color: #fff;
    }

    .page-header-content p {
        font-size: 14px;
        color: #666;
        margin-bottom: 4px;
    }

    body.dark-theme .page-header-content p {
        color: #ddd;
    }

    .bottom-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 25px;
    }

    .today-appointments-card {
        background: white;
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    body.dark-theme .today-appointments-card {
        background: #1a1a1a;
        box-shadow: 0 1px 3px rgba(255,255,255,0.05);
    }

    .today-appointments-card h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
    }

    body.dark-theme .today-appointments-card h5 {
        color: #fff;
    }

    .appointment-item {
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
        font-size: 13px;
    }

    body.dark-theme .appointment-item {
        border-bottom: 1px solid #333;
    }

    .appointment-item:last-child {
        border-bottom: none;
    }

    .appointment-item-time {
        font-weight: 600;
        color: #333;
    }

    body.dark-theme .appointment-item-time {
        color: #fff;
    }

    .appointment-item-patient {
        color: #666;
        margin-top: 2px;
    }

    body.dark-theme .appointment-item-patient {
        color: #bbb;
    }

    .no-appointments {
        text-align: center;
        padding: 30px 20px;
        color: #999;
    }

    body.dark-theme .no-appointments {
        color: #666;
    }

    @media (max-width: 1024px) {
        .bottom-section {
            grid-template-columns: 1fr;
        }
    }

    /* Calendar Styles */
    .calendar-full-page {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 20px;
    }

    .calendar-nav {
        display: flex;
        gap: 10px;
    }

    .calendar-nav button {
        background-color: #f3f4f6;
        border: 0px solid #d1d5db;
        padding: 8px 16px;
        border-radius: 0px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .calendar-nav button:hover {
        background-color: rgb(87, 165, 150);
        color: white;
        border-color: rgb(87, 165, 150);
    }

    .calendar-title {
        font-size: 24px;
        font-weight: bold;
        color: #111827;
        margin: 0;
    }

    .calendar-view-toggles {
        display: flex;
        gap: 10px;
    }

    .view-btn {
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .view-btn.active {
        background-color: rgb(87, 165, 150);
        color: white;
        border-color: rgb(87, 165, 150);
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-bottom: 20px;
    }

    .weekday-header {
        text-align: center;
        font-weight: bold;
        color: rgb(87, 165, 150);
        padding: 10px;
        font-size: 14px;
        text-transform: uppercase;
    }

    .calendar-day {
        aspect-ratio: 1.5;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 19px;
        cursor: pointer;
        font-weight: 500;
        background-color: #fff;
        transition: all 0.2s;
        position: relative;
    }

    .calendar-day:hover:not(.empty):not(.other-month) {
        border-color: rgb(87, 165, 150);
        box-shadow: 0 0 0 2px rgba(87, 165, 150, 0.1);
    }

    .calendar-day.empty,
    .calendar-day.other-month {
        background-color: #f9fafb;
        cursor: not-allowed;
        color: #d1d5db;
    }

    .calendar-day.has-appointment {
        background-color: #dcfce7;
        border-color: #86efac;
        color: #166534;
        font-weight: bold;
    }

    .calendar-day.today {
        border: 2px solid rgb(87, 165, 150);
        background-color: rgba(87, 165, 150, 0.05);
    }

    .calendar-day.has-appointment::after {
        content: '';
        position: absolute;
        bottom: 2px;
        width: 4px;
        height: 4px;
        background-color: #16a34a;
        border-radius: 50%;
    }

    .appointments-list {
        background-color: #f9fafb;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #e5e7eb;
    }

    .appointments-list h3 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 15px;
    }

    .appointment-item {
        background-color: #fff;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 10px;
        border-left: 4px solid rgb(87, 165, 150);
        display: flex;
        justify-content: space-between;
        align-items: start;
    }

    .appointment-details {
        flex: 1;
    }

    .appointment-details strong {
        color: #111827;
        display: block;
        margin-bottom: 4px;
    }

    .appointment-details small {
        color: #6b7280;
        display: block;
    }

    .appointment-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        margin-left: 10px;
    }

    .appointment-status.confirmed {
        background-color: #dcfce7;
        color: #166534;
    }

    .appointment-status.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .appointment-status.cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .appointment-status.completed {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .no-appointments-message {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .no-appointments-message svg {
        width: 48px;
        height: 48px;
        margin-bottom: 10px;
        color: #d1d5db;
    }

    .mb-8 {
        margin-bottom: 2rem;
    }

    /* Calendar sections styling */
    #upcomingAppointmentsCalendar,
    /* Calendar List Styles */
    .appointments-list {
        background-color: #f9fafb;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        margin-top: 20px;
    }

    .appointments-list h3 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 15px;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .appointment-item {
        background-color: #fff;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 10px;
        border-left: 4px solid rgb(87, 165, 150);
        display: flex;
        justify-content: space-between;
        align-items: start;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .appointment-details {
        flex: 1;
    }

    .appointment-details strong {
        color: #111827;
        display: block;
        margin-bottom: 4px;
    }

    .appointment-details small {
        color: #6b7280;
        display: block;
        font-size: 0.875rem;
    }

    .appointment-name-link {
        cursor: pointer !important;
        transition: all 0.2s ease;
        display: inline-block;
        width: 100%;
    }

    .appointment-name-link:hover {
        color: #3d8676 !important;
        text-decoration: underline;
    }

    .appointment-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        margin-left: 10px;
    }

    .appointment-status.confirmed {
        background-color: #dcfce7;
        color: #166534;
    }

    .appointment-status.completed {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .appointment-status.cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .appointment-status.unconfirmed, .appointment-status.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    /* Calendar Day Modern Style */
    .calendar-day {
        aspect-ratio: 0.8;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        background-color: #fff;
        transition: all 0.2s;
        position: relative;
        flex-direction: column;
        padding-top: 5px;
    }

    .calendar-day:hover:not(.empty):not(.other-month) {
        border-color: rgb(87, 165, 150);
        box-shadow: 0 0 0 2px rgba(87, 165, 150, 0.1);
    }

    .calendar-day.today {
        border: 2px solid rgb(87, 165, 150);
        background-color: rgba(87, 165, 150, 0.05);
    }

    .calendar-day-number {
        position: absolute;
        top: 5px;
        right: 8px;
        font-size: 12px;
        color: #9CA3AF;
        font-weight: bold;
    }

    /* Appointment Chips as per Patient Dashboard */
    .apt-entry {
        font-size: 10px;
        padding: 2px 4px;
        margin: 1px 2px;
        border-radius: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: calc(100% - 4px);
        text-align: center;
        font-weight: 600;
        cursor: pointer;
        z-index: 10;
        line-height: 1.4;
    }

    .apt-self { background-color: #FFEDD5; color: #9A3412; border: 1px solid #FED7AA; }
    .apt-parent { background-color: #DBEAFE; color: #1E40AF; border: 1px solid #BFDBFE; }
    .apt-sibling { background-color: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
    .apt-child { background-color: #F3E8FF; color: #6B21A8; border: 1px solid #E9D5FF; }
    /* Fallback/Other statuses */
    .apt-default { background-color: #F3F4F6; color: #374151; border: 1px solid #D1D5DB; }
    .apt-checked { background-color: #dcfce7; color: #166534; border: 1px solid #86efac; }

    .calendar-day.has-appointment {
        background-color: #f0fdf4;
        border-color: #86efac;
    }

    .calendar-day.empty, .calendar-day.other-month {
        background-color: #f9fafb;
        cursor: not-allowed;
        color: #d1d5db;
    }
</style>
<div class="dashboard-container" id="dashboardContainer">
    <div class="container-fluid" id="doctorDashboardContent">
        @if(session('success'))
            <div style="background:#ECFDF5; color:#065F46; padding:10px 14px; border-radius:6px; margin-bottom:12px;">{{ session('success') }}</div>
        @endif
        <!-- Page Header Section -->
        <div class="page-header-section">
            <div class="page-header-content">
                <h1>Doctor Dashboard</h1>
                <p>Welcome back, Dr. {{ Auth::user()->name }}</p>
                <p>Organization: ourPhoneMD</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Appointment Cards Grid -->
        <div class="appointment-cards">
            <!-- My Upcoming Appointments -->
            <div class="appointment-card upcoming" onclick="showUpcomingAppointmentsCalendar()" style="cursor: pointer;">
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-title">My Upcoming Appointments</div>
                <div class="card-number">{{ $upcomingCount }}</div>
                <span class="view-details-link">View details</span>
            </div>

            <!-- Finished Appointments -->
            <div class="appointment-card finished" onclick="showFinishedAppointmentsCalendar()" style="cursor: pointer;">
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-title">Finished Appointments</div>
                <div class="card-number">{{ $finishedCount }}</div>
                <span class="view-details-link">View details</span>
            </div>

            <!-- Walk-in Appointments -->
            <div class="appointment-card walk-in" onclick="showWalkInAppointmentsCalendar()" style="cursor: pointer;">
                <div class="card-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="card-title">Walk-in Appointments</div>
                <div class="card-number">{{ $walkInCount }}</div>
                <span class="view-details-link">View details</span>
            </div>

            <!-- Unfinished Appointments -->
            <div class="appointment-card unfinished" onclick="showUnfinishedAppointmentsCalendar()" style="cursor: pointer;">
                <div class="card-icon">
                    <i class="fas fa-hourglass-end"></i>
                </div>
                <div class="card-title">Unfinished Appointments</div>
                <div class="card-number">{{ $unfinishedCount }}</div>
                <span class="view-details-link">View details</span>
            </div>

            <!-- Unconfirmed Appointments -->
            <div class="appointment-card unconfirmed" onclick="showUnconfirmedAppointmentsCalendar()" style="cursor: pointer;">
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-title">Unconfirmed Appointments</div>
                <div class="card-number">{{ $unconfirmedCount }}</div>
                <span class="view-details-link">View details</span>
            </div>

            <!-- Follow-up Appointments -->
            <div class="appointment-card followup" onclick="showFollowUpAppointmentsCalendar()" style="cursor: pointer;">
                <div class="card-icon">
                    <i class="fas fa-redo"></i>
                </div>
                <div class="card-title">Follow-up Appointments</div>
                <div class="card-number">{{ $followUpCount }}</div>
                <span class="view-details-link">View details</span>
            </div>

            <!-- Cancelled Appointments -->
            <div class="appointment-card cancelled" onclick="showCancelledAppointmentsCalendar()" style="cursor: pointer;">
                <div class="card-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="card-title">Cancelled Appointments</div>
                <div class="card-number">{{ $cancelledCount }}</div>
                <span class="view-details-link">View details</span>
            </div>
        </div>

        <!-- Bottom Section: Today's Appointments & Doctor Information -->
        <div class="bottom-section">
            <!-- Doctor Information Section -->
            <div class="doctor-info-card">
                <h5><i class="fas fa-user-md me-2"></i>Doctor Information</h5>
                <div class="doctor-info-row">
                    <div class="doctor-info-label">Name:</div>
                    <div class="doctor-info-value">Dr. {{ Auth::user()->name }}</div>
                </div>
                <div class="doctor-info-row">
                    <div class="doctor-info-label">Email:</div>
                    <div class="doctor-info-value">{{ Auth::user()->email }}</div>
                </div>
                <div class="doctor-info-row">
                    <div class="doctor-info-label">Organization:</div>
                    <div class="doctor-info-value">ourPhoneMD</div>
                </div>
                @isset($doctor)
                    <div class="doctor-info-row">
                        <div class="doctor-info-label">Specialization:</div>
                        <div class="doctor-info-value">{{ $doctor->specialization ?? 'General Practitioner' }}</div>
                    </div>
                    <div class="doctor-info-row">
                        <div class="doctor-info-label">Qualification:</div>
                        <div class="doctor-info-value">{{ $doctor->qualification ?? 'MBBS' }}</div>
                    </div>
                @endisset
            </div>

            <!-- Today's Appointments Card -->
            <div class="today-appointments-card">
                <h5><i class="fas fa-calendar-day me-2"></i>Today's Appointments</h5>
                @if($todayAppointments->count() > 0)
                    @foreach($todayAppointments as $appointment)
                        <div class="appointment-item">
                            <div class="appointment-item-time">
                                <i class="fas fa-clock me-2"></i>{{ $appointment->appointment_time }}
                            </div>
                            <div class="appointment-item-patient">
                                @if($appointment->patient)
                                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                @else
                                    Patient Name N/A
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-appointments">
                        <i class="fas fa-calendar-check fa-2x mb-3" style="color: #ddd;"></i>
                        <p>No appointments scheduled for today</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Calendar Content for Upcoming Appointments -->
    <div id="upcomingAppointmentsCalendar" style="display: none;">
        <div class="container-fluid">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Upcoming Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your scheduled upcoming appointments</p>
                <button onclick="showDoctorDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthDoctorUpcoming()">&larr; Previous</button>
                            <button onclick="todayDoctorUpcoming()">Today</button>
                            <button onclick="nextMonthDoctorUpcoming()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="doctorUpcomingCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="doctorUpcomingCalendarGrid">
                    <!-- Upcoming appointments calendar will be generated here -->
                </div>

                <div class="appointments-list" id="doctorUpcomingAppointmentsList">
                    <!-- Upcoming appointments for selected date will appear here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Content for Finished Appointments -->
    <div id="finishedAppointmentsCalendar" style="display: none;">
        <div class="container-fluid">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Finished Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your completed appointments</p>
                <button onclick="showDoctorDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthDoctorFinished()">&larr; Previous</button>
                            <button onclick="todayDoctorFinished()">Today</button>
                            <button onclick="nextMonthDoctorFinished()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="doctorFinishedCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="doctorFinishedCalendarGrid">
                    <!-- Finished appointments calendar will be generated here -->
                </div>

                <div class="appointments-list" id="doctorFinishedAppointmentsList">
                    <!-- Finished appointments for selected date will appear here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Content for Walk-in Appointments -->
    <div id="walkInAppointmentsCalendar" style="display: none;">
        <div class="container-fluid">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Walk-in Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your walk-in appointments</p>
                <button onclick="showDoctorDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthDoctorWalkIn()">&larr; Previous</button>
                            <button onclick="todayDoctorWalkIn()">Today</button>
                            <button onclick="nextMonthDoctorWalkIn()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="doctorWalkInCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="doctorWalkInCalendarGrid">
                </div>

                <div class="appointments-list" id="doctorWalkInAppointmentsList">
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Content for Unconfirmed Appointments -->
    <div id="unconfirmedAppointmentsCalendar" style="display: none;">
        <div class="container-fluid">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Unconfirmed Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your pending appointments</p>
                <button onclick="showDoctorDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthDoctorUnconfirmed()">&larr; Previous</button>
                            <button onclick="todayDoctorUnconfirmed()">Today</button>
                            <button onclick="nextMonthDoctorUnconfirmed()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="doctorUnconfirmedCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="doctorUnconfirmedCalendarGrid">
                </div>

                <div class="appointments-list" id="doctorUnconfirmedAppointmentsList">
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Content for Follow-up Appointments -->
    <div id="followUpAppointmentsCalendar" style="display: none;">
        <div class="container-fluid">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Follow-up Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your follow-up appointments</p>
                <button onclick="showDoctorDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthDoctorFollowUp()">&larr; Previous</button>
                            <button onclick="todayDoctorFollowUp()">Today</button>
                            <button onclick="nextMonthDoctorFollowUp()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="doctorFollowUpCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="doctorFollowUpCalendarGrid">
                </div>

                <div class="appointments-list" id="doctorFollowUpAppointmentsList">
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Content for Cancelled Appointments -->
    <div id="cancelledAppointmentsCalendar" style="display: none;">
        <div class="container-fluid">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Cancelled Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your cancelled appointments</p>
                <button onclick="showDoctorDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthDoctorCancelled()">&larr; Previous</button>
                            <button onclick="todayDoctorCancelled()">Today</button>
                            <button onclick="nextMonthDoctorCancelled()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="doctorCancelledCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="doctorCancelledCalendarGrid">
                </div>

                <div class="appointments-list" id="doctorCancelledAppointmentsList">
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Content for Unfinished Appointments -->
    <div id="unfinishedAppointmentsCalendar" style="display: none;">
        <div class="container-fluid">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Unfinished Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your unfinished appointments</p>
                <button onclick="showDoctorDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthDoctorUnfinished()">&larr; Previous</button>
                            <button onclick="todayDoctorUnfinished()">Today</button>
                            <button onclick="nextMonthDoctorUnfinished()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="doctorUnfinishedCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="doctorUnfinishedCalendarGrid">
                </div>

                <div class="appointments-list" id="doctorUnfinishedAppointmentsList">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Parse appointments from PHP data
const upcomingAppointments = @json($upcomingAppointments ?? []);
const finishedAppointments = @json($finishedAppointments ?? []);
const walkInAppointments = @json($walkInAppointments ?? []);
const unconfirmedAppointments = @json($unconfirmedAppointments ?? []);
const followUpAppointments = @json($followUpAppointments ?? []);
const cancelledAppointments = @json($cancelledAppointments ?? []);
const unfinishedAppointments = @json($unfinishedAppointments ?? []);

// Build maps of dates to appointments
const upcomingAppointmentsByDate = {};
const finishedAppointmentsByDate = {};
const walkInAppointmentsByDate = {};
const unconfirmedAppointmentsByDate = {};
const followUpAppointmentsByDate = {};
const cancelledAppointmentsByDate = {};
const unfinishedAppointmentsByDate = {};

const chipsContainer = document.createElement('div');

function processAppointments(appointments, map) {
    if (!Array.isArray(appointments)) {
        console.warn('processAppointments: appointments is not an array', appointments);
        return;
    }
    appointments.forEach(apt => {
        const date = apt.appointment_date;
        if (!map[date]) map[date] = [];
        map[date].push(apt);
    });
}

processAppointments(upcomingAppointments, upcomingAppointmentsByDate);
processAppointments(finishedAppointments, finishedAppointmentsByDate);
processAppointments(walkInAppointments, walkInAppointmentsByDate);
processAppointments(unconfirmedAppointments, unconfirmedAppointmentsByDate);
processAppointments(followUpAppointments, followUpAppointmentsByDate);
processAppointments(cancelledAppointments, cancelledAppointmentsByDate);
processAppointments(unfinishedAppointments, unfinishedAppointmentsByDate);

// Date variables for calendars
let doctorUpcomingCurrentDate = new Date();
let doctorFinishedCurrentDate = new Date();
let doctorWalkInCurrentDate = new Date();
let doctorUnconfirmedCurrentDate = new Date();
let doctorFollowUpCurrentDate = new Date();
let doctorCancelledCurrentDate = new Date();
let doctorUnfinishedCurrentDate = new Date();

function renderDoctorCalendar(calendarType, currentDate, appointmentsByDate, titleId, gridId, listId) {
    console.log('renderDoctorCalendar called with:', { calendarType, titleId, gridId, listId });

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    const calendarGrid = document.getElementById(gridId);
    if (!calendarGrid) {
        console.error('Calendar grid element not found:', gridId);
        return;
    }

    calendarGrid.innerHTML = '';

    // Update title
    const monthName = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });
    const titleElement = document.getElementById(titleId);
    if (titleElement) {
        titleElement.textContent = monthName;
    } else {
        console.error('Title element not found:', titleId);
    }

    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    weekdays.forEach(day => {
        const dayHeader = document.createElement('div');
        dayHeader.className = 'weekday-header';
        dayHeader.textContent = day;
        calendarGrid.appendChild(dayHeader);
    });

    for (let i = firstDay - 1; i >= 0; i--) {
        const day = document.createElement('div');
        day.className = 'calendar-day other-month empty';
        day.textContent = daysInPrevMonth - i;
        calendarGrid.appendChild(day);
    }

    const today = new Date();
    for (let i = 1; i <= daysInMonth; i++) {
        const day = document.createElement('div');
        day.className = 'calendar-day';

        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
        const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === i;
        if (isToday) day.classList.add('today');



        // Day number
        const dayNumber = document.createElement('span');
        dayNumber.textContent = i;
        dayNumber.className = 'calendar-day-number';
        day.appendChild(dayNumber);

        const dayAppointments = appointmentsByDate[dateStr] || [];

        if (dayAppointments.length > 0) {
            day.classList.add('has-appointment');

            // Limit to 3-4 chips
            dayAppointments.slice(0, 4).forEach(apt => {
                const chip = document.createElement('div');
                let typeClass = 'apt-self';

                // Logic to match patient dashboard colors
                if (apt.appointment_type === 'family') {
                    const rel = (apt.relationship || '').toLowerCase();
                    if (rel.includes('parent')) typeClass = 'apt-parent';
                    else if (rel.includes('sibling')) typeClass = 'apt-sibling';
                    else if (rel.includes('child')) typeClass = 'apt-child';
                    else typeClass = 'apt-parent'; // fallback
                } else {
                    typeClass = 'apt-self';
                }

                // Optional: override if we want status based colors instead?
                // The user asked for "orange background for Self", which matches the logic above.

                chip.className = `apt-entry ${typeClass}`;
                chip.textContent = apt.patient_name;
                chip.title = `Click to view appointment details`;

                chip.onclick = (e) => {
                    e.stopPropagation(); // prevent day click
                    // Navigate to appointment detail page
                    viewDoctorAppointmentDetail(apt.id);
                };

                day.appendChild(chip);
            });
        }

        day.onclick = () => {
             showDoctorDataForDate(calendarType, dateStr, listId, appointmentsByDate);
             document.getElementById(listId).scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        };
        calendarGrid.appendChild(day);
    }

    const totalCells = calendarGrid.children.length - 7;
    const remainingCells = 42 - totalCells;
    for (let i = 1; i <= remainingCells; i++) {
        const day = document.createElement('div');
        day.className = 'calendar-day other-month empty';
        day.textContent = i;
        calendarGrid.appendChild(day);
    }

    const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
    console.log('Showing data for today:', todayStr);
    showDoctorDataForDate(calendarType, todayStr, listId, appointmentsByDate);
}

function showDoctorDataForDate(calendarType, dateStr, listId, dataByDate) {
    console.log('showDoctorDataForDate called:', { calendarType, dateStr, listId });

    const listElement = document.getElementById(listId);
    if (!listElement) {
        console.error('List element not found:', listId);
        return;
    }

    const data = dataByDate[dateStr] || [];
    console.log('Data for date ' + dateStr + ':', data);

    if (data.length === 0) {
        listElement.innerHTML = `
            <div class="no-appointments-message">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 2v4"></path>
                    <path d="M16 2v4"></path>
                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                    <path d="M3 10h18"></path>
                </svg>
                <p>No appointments on this date</p>
            </div>
        `;
        return;
    }

    const dateObj = new Date(dateStr);
    const formattedDate = dateObj.toLocaleString('default', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

    let html = `<h3>Appointments for ${formattedDate}</h3>`;

    data.forEach(item => {
        html += createDoctorListItem(item);
    });

    listElement.innerHTML = html;

    // Scroll to the list so user knows it updated
    listElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function createDoctorListItem(item) {
    const time = item.appointment_time ? new Date(`2000-01-01 ${item.appointment_time}`).toLocaleString('default', { hour: '2-digit', minute: '2-digit', hour12: true }) : 'N/A';
    const statusClass = item.status.toLowerCase();
    const appointmentId = item.id;

    return `
        <div class="appointment-item" data-appointment-id="${appointmentId}">
            <div class="appointment-details">
                <div style="font-size: 16px; font-weight: 700; color: #51A897; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 2px solid #51A897; cursor: pointer;" class="appointment-name-link" data-id="${appointmentId}">
                    ${item.patient_name}
                </div>
                <small>${time}</small>
                <small>${item.appointment_mode === 'telemedicine' ? '👁️ Virtual Consultation' : '🏥 In-Person Visit'}</small>
            </div>
            <span class="appointment-status ${statusClass}">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span>
        </div>
    `;
}

// Navigation functions for upcoming appointments
// Navigation functions
const makeNavFunctions = (dateVar, renderer) => ({
    next: () => { dateVar.setMonth(dateVar.getMonth() + 1); renderer(); },
    prev: () => { dateVar.setMonth(dateVar.getMonth() - 1); renderer(); },
    today: () => { const now = new Date(); dateVar.setMonth(now.getMonth()); dateVar.setFullYear(now.getFullYear()); renderer(); }
});

const navUpcoming = makeNavFunctions(doctorUpcomingCurrentDate, renderDoctorUpcomingCalendar);
const navFinished = makeNavFunctions(doctorFinishedCurrentDate, renderDoctorFinishedCalendar);
const navWalkIn = makeNavFunctions(doctorWalkInCurrentDate, renderDoctorWalkInCalendar);
const navUnconfirmed = makeNavFunctions(doctorUnconfirmedCurrentDate, renderDoctorUnconfirmedCalendar);
const navFollowUp = makeNavFunctions(doctorFollowUpCurrentDate, renderDoctorFollowUpCalendar);
const navCancelled = makeNavFunctions(doctorCancelledCurrentDate, renderDoctorCancelledCalendar);
const navUnfinished = makeNavFunctions(doctorUnfinishedCurrentDate, renderDoctorUnfinishedCalendar);

// Global nav wrappers
function nextMonthDoctorUpcoming() { navUpcoming.next(); }
function previousMonthDoctorUpcoming() { navUpcoming.prev(); }
function todayDoctorUpcoming() { navUpcoming.today(); }

function nextMonthDoctorFinished() { navFinished.next(); }
function previousMonthDoctorFinished() { navFinished.prev(); }
function todayDoctorFinished() { navFinished.today(); }

function nextMonthDoctorWalkIn() { navWalkIn.next(); }
function previousMonthDoctorWalkIn() { navWalkIn.prev(); }
function todayDoctorWalkIn() { navWalkIn.today(); }

function nextMonthDoctorUnconfirmed() { navUnconfirmed.next(); }
function previousMonthDoctorUnconfirmed() { navUnconfirmed.prev(); }
function todayDoctorUnconfirmed() { navUnconfirmed.today(); }

function nextMonthDoctorFollowUp() { navFollowUp.next(); }
function previousMonthDoctorFollowUp() { navFollowUp.prev(); }
function todayDoctorFollowUp() { navFollowUp.today(); }

function nextMonthDoctorCancelled() { navCancelled.next(); }
function previousMonthDoctorCancelled() { navCancelled.prev(); }
function todayDoctorCancelled() { navCancelled.today(); }

function nextMonthDoctorUnfinished() { navUnfinished.next(); }
function previousMonthDoctorUnfinished() { navUnfinished.prev(); }
function todayDoctorUnfinished() { navUnfinished.today(); }

// Render functions
function renderDoctorUpcomingCalendar() { renderDoctorCalendar('upcoming', doctorUpcomingCurrentDate, upcomingAppointmentsByDate, 'doctorUpcomingCalendarTitle', 'doctorUpcomingCalendarGrid', 'doctorUpcomingAppointmentsList'); }
function renderDoctorFinishedCalendar() { renderDoctorCalendar('finished', doctorFinishedCurrentDate, finishedAppointmentsByDate, 'doctorFinishedCalendarTitle', 'doctorFinishedCalendarGrid', 'doctorFinishedAppointmentsList'); }
function renderDoctorWalkInCalendar() { renderDoctorCalendar('walk-in', doctorWalkInCurrentDate, walkInAppointmentsByDate, 'doctorWalkInCalendarTitle', 'doctorWalkInCalendarGrid', 'doctorWalkInAppointmentsList'); }
function renderDoctorUnconfirmedCalendar() { renderDoctorCalendar('unconfirmed', doctorUnconfirmedCurrentDate, unconfirmedAppointmentsByDate, 'doctorUnconfirmedCalendarTitle', 'doctorUnconfirmedCalendarGrid', 'doctorUnconfirmedAppointmentsList'); }
function renderDoctorFollowUpCalendar() { renderDoctorCalendar('follow-up', doctorFollowUpCurrentDate, followUpAppointmentsByDate, 'doctorFollowUpCalendarTitle', 'doctorFollowUpCalendarGrid', 'doctorFollowUpAppointmentsList'); }
function renderDoctorCancelledCalendar() { renderDoctorCalendar('cancelled', doctorCancelledCurrentDate, cancelledAppointmentsByDate, 'doctorCancelledCalendarTitle', 'doctorCancelledCalendarGrid', 'doctorCancelledAppointmentsList'); }
function renderDoctorUnfinishedCalendar() { renderDoctorCalendar('unfinished', doctorUnfinishedCurrentDate, unfinishedAppointmentsByDate, 'doctorUnfinishedCalendarTitle', 'doctorUnfinishedCalendarGrid', 'doctorUnfinishedAppointmentsList'); }

// Toggle functions
function hideAllCalendars() {
    const dashboard = document.getElementById('doctorDashboardContent');
    if (dashboard) dashboard.style.display = 'none';

    const calendars = [
        'upcomingAppointmentsCalendar', 'finishedAppointmentsCalendar',
        'walkInAppointmentsCalendar', 'unconfirmedAppointmentsCalendar',
        'followUpAppointmentsCalendar', 'cancelledAppointmentsCalendar',
        'unfinishedAppointmentsCalendar'
    ];
    calendars.forEach(id => {
        const el = document.getElementById(id);
        if(el) el.style.display = 'none';
    });
}

function showCalendar(id, renderer) {
    console.log('Showing calendar:', id);
    hideAllCalendars();
    const cal = document.getElementById(id);
    if (cal) {
        cal.style.display = 'block';

        // Ensure parent container is visible if needed
        const dashboardContainer = document.getElementById('dashboardContainer');
        if (dashboardContainer && dashboardContainer.style.display === 'none') {
             dashboardContainer.style.display = 'block';
        }

        try {
            renderer();
        } catch (e) {
            console.error('Error rendering calendar:', e);
        }
    } else {
        console.error('Calendar element not found:', id);
    }
}

function showUpcomingAppointmentsCalendar() { showCalendar('upcomingAppointmentsCalendar', renderDoctorUpcomingCalendar); }
function showFinishedAppointmentsCalendar() { showCalendar('finishedAppointmentsCalendar', renderDoctorFinishedCalendar); }
function showWalkInAppointmentsCalendar() { showCalendar('walkInAppointmentsCalendar', renderDoctorWalkInCalendar); }
function showUnconfirmedAppointmentsCalendar() { showCalendar('unconfirmedAppointmentsCalendar', renderDoctorUnconfirmedCalendar); }
function showFollowUpAppointmentsCalendar() { showCalendar('followUpAppointmentsCalendar', renderDoctorFollowUpCalendar); }
function showCancelledAppointmentsCalendar() { showCalendar('cancelledAppointmentsCalendar', renderDoctorCancelledCalendar); }
function showUnfinishedAppointmentsCalendar() { showCalendar('unfinishedAppointmentsCalendar', renderDoctorUnfinishedCalendar); }

function showDoctorDashboard() {
    hideAllCalendars();
    const dashboard = document.getElementById('doctorDashboardContent');
    if (dashboard) {
        dashboard.style.display = 'block';
    } else {
        console.error('Doctor dashboard content not found!');
        // Fallback: try to show the container if it's hidden
        document.getElementById('dashboardContainer').style.display = 'block';
    }
}

function switchView(view) {
    console.log('Switched to ' + view + ' view');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Dashboard is shown by default
    console.log('Doctor dashboard loaded');

    // Event delegation for appointment name links
    document.addEventListener('click', function(e) {
        const nameLink = e.target.closest('.appointment-name-link');
        if (nameLink) {
            e.preventDefault();
            e.stopPropagation();
            const appointmentId = nameLink.getAttribute('data-id');
            console.log('Appointment name clicked:', appointmentId);
            viewDoctorAppointmentDetail(appointmentId);
        }
    });
});

function viewDoctorAppointmentDetail(appointmentId) {
    console.log('viewDoctorAppointmentDetail called with appointmentId:', appointmentId);
    if (!appointmentId || appointmentId === 'undefined') {
        console.error('Invalid appointmentId:', appointmentId);
        alert('Unable to open appointment details. Invalid appointment ID.');
        return;
    }
    window.location.href = `/doctor/appointment/${appointmentId}`;
}
</script>

<!-- Appointment Wizard Modal (matches reference UI) -->
<div id="appointmentWizardModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:1200;">
    <div style="max-width:900px; margin:40px auto; background:#fff; border-radius:8px; padding:24px; position:relative; max-height:calc(100vh - 80px); overflow-y:auto; box-sizing:border-box;">
        <button id="closeWizardBtn" style="position:absolute; right:16px; top:16px; background:none; border:none; font-size:22px;">&times;</button>
        <h3 style="margin-top:0;">Create New Appointment</h3>

        <!-- Progress bar -->
        <div style="display:flex; align-items:center; gap:12px; margin:18px 0;">
            <div style="display:flex; align-items:center; width:100%;">
                <div id="stepDot1" style="width:36px; height:36px; border-radius:50%; background:#1aa179; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700;">1</div>
                <div id="progressLine1" style="height:4px; background:#1aa179; flex:1; margin:0 8px;"></div>
                <div id="stepDot2" style="width:36px; height:36px; border-radius:50%; background:#1aa179; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700;">2</div>
                <div id="progressLine2" style="height:4px; background:#e6eef5; flex:1; margin:0 8px;"></div>
                <div id="stepDot3" style="width:36px; height:36px; border-radius:50%; background:#e6eef5; color:#666; display:flex; align-items:center; justify-content:center; font-weight:700;">3</div>
            </div>
        </div>

        <div style="display:flex; gap:24px;">
            <div style="flex:1;">
                <!-- Step 1 -->
                <div id="modalStep1">
                    <h4 style="margin-top:0;">Step 1 — Select Patient(s)</h4>
                    <p style="color:#666;">Search patients by name or email</p>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <input id="patientSearchInput" placeholder="Search patients by name or email..." style="flex:1; padding:12px; border-radius:6px; border:1px solid #e6eef5;" />
                        <button id="patientSearchBtn" style="background:#1aa179; border-color:#1aa179; color:#fff; padding:10px 14px; border-radius:6px;">Search</button>
                    </div>
                    <div id="patientSearchResults" style="margin-top:12px; max-height:240px; overflow:auto; border-radius:6px; padding:8px; border:1px solid #f1f5f7;"></div>
                </div>

                <!-- Step 2 -->
                <div id="modalStep2" style="display:none;">
                    <h4 style="margin-top:0;">Step 2 — Appointment Details</h4>
                    <p style="color:#666;">Configuring appointment for: <strong id="selectedPatientName"></strong></p>
                        <div style="background:#f8fafb; padding:16px; border-radius:6px; display:flex; flex-direction:column; gap:14px;">
                        <div style="margin-bottom:8px;"><label>Patient: <select id="patientSelect" style="width:100%; padding:10px; border-radius:6px;"></select></label></div>
                        <div style="display:flex; gap:12px;">
                            <div style="flex:1;"><label>Appointment Mode<select id="appointmentMode" style="width:100%; padding:10px; border-radius:6px;"><option value="in-person">Scheduled</option><option value="walk-in">Walk-in</option></select></label></div>
                            <div style="flex:1;"><label>Visit Type<div style="display:flex; gap:8px; margin-top:6px;"><label><input type="radio" name="visitType" value="adhd" /> ADHD/Anxiety</label><label><input type="radio" name="visitType" value="followup" /> Follow-up</label><label><input type="radio" name="visitType" value="sick" checked /> Sick Visit</label></div></label>
                                <div style="margin-top:10px;"><button id="videoCallBtn" style="background:#1aa179; border-color:#1aa179; color:#fff; padding:8px 12px; border-radius:6px;">Video</button></div>
                                <div style="margin-top:8px; color:#c53030; font-size:13px;">* In case of video call missed, the Patient will receive a phone call on the mentioned number.</div>
                            </div>
                        </div>
                        <div style="display:flex; gap:12px;">
                            <div style="flex:1;"><label>Doctor<select id="doctorSelect" style="width:100%; padding:10px; border-radius:6px;"><option value="{{ Auth::user()->id }}">Dr. {{ Auth::user()->name }}</option></select></label></div>
                        </div>
                        {{-- <div style="display:flex; gap:12px;">
                            <div style="flex:1;"><label>Date<input type="date" id="appointmentDate" style="width:100%; padding:10px; border-radius:6px;" /></label></div>
                            <div style="flex:1;"><label>Time<select id="appointmentTime" style="width:100%; padding:10px; border-radius:6px;"></select></label></div>
                        </div> --}}
                        <div style="display:flex; gap:12px;">
                            <div style="flex:1;">
                                <div id="dateWrapper">
                                    <label>Date<input type="date" id="appointmentDate" style="width:100%; padding:10px; border-radius:6px;" /></label>
                                    <div id="dateError" style="color:#c53030; font-size:13px; margin-top:6px; display:none;">Date is required</div>
                                </div>
                            </div>
                            <div style="flex:1;">
                                <div id="timeWrapper">
                                    <label>Time<select id="appointmentTime" style="width:100%; padding:10px; border-radius:6px;"></select></label>
                                    <div id="timeError" style="color:#c53030; font-size:13px; margin-top:6px; display:none;">Time is required</div>
                                </div>
                            </div>
                        </div>
                        <div id="reasonWrapper" style="margin-top:8px;"><label>Reason for Visit<textarea id="reason" style="width:100%; min-height:80px; padding:10px; border-radius:6px;"></textarea></label>
                            <div id="reasonError" style="color:#c53030; font-size:13px; margin-top:6px; display:none;">Reason for visit is required</div>
                        </div>
                        <div><label>Symptoms (Optional)<textarea id="symptoms" style="width:100%; min-height:60px; padding:10px; border-radius:6px;"></textarea></label></div>
                        <div><label>Current Medications (Optional)<textarea id="medications" style="width:100%; min-height:60px; padding:10px; border-radius:6px;"></textarea></label></div>
                        <div style="display:flex; gap:12px;"><div style="flex:1;"><label>Allergies (Optional)<input id="allergies" style="width:100%; padding:10px; border-radius:6px;" /></label></div><div style="flex:1;"><label>Alt Phone (Optional)<input id="altPhone" style="width:100%; padding:10px; border-radius:6px;" /></label></div></div>
                        <div style="display:flex; gap:12px; align-items:center;"><div><label>Medical History</label><div style="margin-top:6px;"><label><input type="radio" name="medicalHistory" value="yes" /> Yes</label> <label style="margin-left:8px;"><input type="radio" name="medicalHistory" value="no" checked /> No</label></div></div>
                        <div style="margin-left:12px;"><label>Require Work/School Note</label><div style="margin-top:6px;"><label><input type="radio" name="workNote" value="yes" /> Yes</label> <label style="margin-left:8px;"><input type="radio" name="workNote" value="no" checked /> No</label></div></div></div>
                        <div><label>Additional Notes (Optional)<textarea id="additionalNotes" style="width:100%; min-height:60px; padding:10px; border-radius:6px;"></textarea></label></div>
                    </div>
                    <div id="step2Error" style="color:red; margin-top:8px;"></div>
                </div>

                <!-- Step 3 -->
                <div id="modalStep3" style="display:none; text-align:center;">
                    <h4 style="margin-top:0;">Step 3 — Payment Method</h4>
                    <p style="color:#666;">Appointment amount: <strong>$100.00</strong></p>
                    <button id="paymentOpenBtn" style="background:#1aa179; border-color:#1aa179; color:#fff; padding:12px 18px; border-radius:8px; font-weight:700;">Payment</button>
                    <div id="paymentMessage" style="margin-top:12px;"></div>
                </div>
            </div>

            <!-- Right column with actions -->
            <div style="width:220px;">
                <div style="background:#f8fafb; padding:12px; border-radius:6px;">
                    <div style="font-weight:700;">Summary</div>
                    <div style="margin-top:8px;" id="summaryPatient">Patient: —</div>
                    <div id="summaryDoctor">Doctor: Dr. {{ Auth::user()->name }}</div>
                    <div id="summaryDate">Date: —</div>
                    <div id="summaryTime">Time: —</div>
                    <div style="margin-top:12px;">Amount: <strong>$100.00</strong></div>
                </div>

                <div style="margin-top:20px; display:flex; gap:8px;">
                    <button id="prevBtn" class="btn btn-light" style="flex:1;">Previous</button>
                    <button id="nextBtn" class="btn" style="flex:1; background:#1aa179; border-color:#1aa179; color:#fff;">Next</button>
                </div>
                <div style="margin-top:12px;">
                    <small style="color:#999;">Payment processed via Stripe (test mode)</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const csrf = '{{ csrf_token() }}';
    const doctorId = {{ Auth::user()->id }};
    let selectedPatient = null;
    let currentStep = 1; // 1..3

    function showModal() { document.getElementById('appointmentWizardModal').style.display = 'block'; }
    function hideModal() { document.getElementById('appointmentWizardModal').style.display = 'none'; }

    document.getElementById('doctorBookBtn')?.addEventListener('click', function(e){ e.preventDefault(); showModal(); });
    document.getElementById('closeWizardBtn').addEventListener('click', function(){ hideModal(); resetWizard(); });

    const stepSections = {1: 'modalStep1', 2: 'modalStep2', 3: 'modalStep3'};
    function goToStep(n){ currentStep = n; for(let i=1;i<=3;i++){ document.getElementById(stepSections[i]).style.display = (i===n)?'block':'none'; }
        // progress visuals
        document.getElementById('stepDot1').style.background = (n>=1)?'#1aa179':'#e6eef5';
        document.getElementById('stepDot2').style.background = (n>=2)?'#1aa179':'#e6eef5';
        document.getElementById('stepDot3').style.background = (n>=3)?'#1aa179':'#e6eef5';
        document.getElementById('progressLine1').style.background = (n>=2)?'#1aa179':'#e6eef5';
        document.getElementById('progressLine2').style.background = (n>=3)?'#1aa179':'#e6eef5';
        // update next/prev button labels
        document.getElementById('prevBtn').style.display = (n===1)?'none':'inline-block';
        document.getElementById('nextBtn').textContent = (n===3)?'Complete Payment':'Next';
    }

    document.getElementById('prevBtn').addEventListener('click', function(){ if(currentStep>1) goToStep(currentStep-1); });
    document.getElementById('nextBtn').addEventListener('click', function(){
        if(currentStep===1){
            if(!selectedPatient) { alert('Please select a patient.'); return; }
            goToStep(2);
        } else if(currentStep===2){
            // validate date, time and reason individually
            const dateEl = document.getElementById('appointmentDate');
            const timeEl = document.getElementById('appointmentTime');
            const reasonEl = document.getElementById('reason');
            const date = dateEl.value;
            const time = timeEl.value;
            const reason = reasonEl.value;

            // clear previous visuals
            document.getElementById('dateError').style.display = 'none';
            document.getElementById('timeError').style.display = 'none';
            document.getElementById('reasonError').style.display = 'none';
            dateEl.style.borderColor=''; timeEl.style.borderColor=''; reasonEl.style.borderColor='';

            let hasError = false;
            if(!date){ document.getElementById('dateError').style.display = 'block'; dateEl.style.borderColor = '#ef4444'; hasError = true; }
            if(!time){ document.getElementById('timeError').style.display = 'block'; timeEl.style.borderColor = '#ef4444'; hasError = true; }
            if(!reason || reason.trim()===''){ document.getElementById('reasonError').style.display = 'block'; reasonEl.style.borderColor = '#ef4444'; hasError = true; }

            if(hasError){ return; }

            // availability check
            fetch('/api/doctor/check-availability', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf}, body: JSON.stringify({doctor_id:doctorId, appointment_date:date, appointment_time:time})})
            .then(r=>r.json()).then(json=>{
                if(json.available){
                    document.getElementById('summaryDate').textContent = 'Date: '+date; document.getElementById('summaryTime').textContent = 'Time: '+time; goToStep(3);
                } else {
                    document.getElementById('timeError').textContent = 'Selected time is not available. Choose another time.';
                    document.getElementById('timeError').style.display = 'block';
                    timeEl.style.borderColor = '#ef4444';
                }
            });
        } else { // step 3: submit payment
            submitPayment();
        }
    });

    // Search patients
    document.getElementById('patientSearchBtn').addEventListener('click', function(){ const q = document.getElementById('patientSearchInput').value.trim(); if(!q) return; fetch('/api/doctor/patient-search', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf}, body: JSON.stringify({q:q})}).then(r=>r.json()).then(data=>{
        const results = data.data || []; const container = document.getElementById('patientSearchResults'); container.innerHTML=''; if(results.length===0){ container.innerHTML='<div style="color:#666;">No patients found</div>'; return; }
        const select = document.getElementById('patientSelect'); select.innerHTML = '';
        results.forEach(p=>{
            // result list
            const row = document.createElement('div'); row.style.padding='8px'; row.style.borderBottom='1px solid #f1f5f7'; row.style.cursor='pointer'; row.textContent = p.name + ' — ' + (p.email||'');
            row.addEventListener('click', function(){ selectedPatient = p; document.getElementById('selectedPatientName').textContent = p.name; document.getElementById('summaryPatient').textContent = 'Patient: '+p.name; // populate select
                select.innerHTML = '';
                const opt = document.createElement('option'); opt.value = p.id; opt.textContent = p.name; select.appendChild(opt);
            });
            container.appendChild(row);
            // also populate dropdown options
            const opt = document.createElement('option'); opt.value = p.id; opt.textContent = p.name; select.appendChild(opt);
        });
    }); });

    // keep patientSelect synced
    document.getElementById('patientSelect').addEventListener('change', function(){ const id = this.value; if(!id) return; const sel = document.querySelector('#patientSelect option:checked'); if(sel) { document.getElementById('selectedPatientName').textContent = sel.textContent; selectedPatient = {id: id, name: sel.textContent}; document.getElementById('summaryPatient').textContent = 'Patient: '+sel.textContent; } });

    // populate times helper
    function populateTimes(){ const sel = document.getElementById('appointmentTime'); sel.innerHTML=''; const placeholder = document.createElement('option'); placeholder.value=''; placeholder.textContent='Select time'; placeholder.disabled = false; placeholder.selected = true; sel.appendChild(placeholder); const times = ['09:00','09:30','10:00','10:30','11:00','11:30','13:00','13:30','14:00','14:30','15:00']; times.forEach(t=>{ const o = document.createElement('option'); o.value=t; o.textContent=t; sel.appendChild(o); }); }
    populateTimes();
    // Clear date/time validation on input
    function clearDateTimeValidation(){
        const dtErr = document.getElementById('dateTimeError'); if(dtErr){ dtErr.style.display='none'; dtErr.textContent=''; }
        const ad = document.getElementById('appointmentDate'); const at = document.getElementById('appointmentTime'); if(ad) ad.style.borderColor=''; if(at) at.style.borderColor='';
    }
    document.getElementById('appointmentDate').addEventListener('input', clearDateTimeValidation);
    document.getElementById('appointmentTime').addEventListener('change', clearDateTimeValidation);
    document.getElementById('reason').addEventListener('input', clearDateTimeValidation);

    function submitPayment(){
        const cardName = document.getElementById('cardName').value; const cardNumber = document.getElementById('cardNumber').value; const cardExpMonth = document.getElementById('cardExpMonth').value; const cardExpYear = document.getElementById('cardExpYear').value; const cardCVC = document.getElementById('cardCVC').value;
        if(!cardName||!cardNumber||!cardExpMonth||!cardExpYear||!cardCVC){ alert('Please enter card details'); return; }
        if(!selectedPatient){ alert('No patient selected'); return; }
        const date = document.getElementById('appointmentDate').value; const time = document.getElementById('appointmentTime').value;
        document.getElementById('paymentMessage').textContent = 'Processing...';
        const payload = { patient_id: selectedPatient.id, doctor_id: doctorId, appointment_date: date, appointment_time: time, cardName, cardNumber, cardExpMonth, cardExpYear, cardCVC };
        fetch('/doctor/appointments/pay', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf}, body: JSON.stringify(payload)})
        .then(r=>r.json()).then(json=>{
            if(json.success){ document.getElementById('paymentMessage').innerHTML = '<div style="color:green; font-weight:700;">Payment Successful</div>'; setTimeout(()=>{ hideModal(); resetWizard(); location.reload(); },900); }
            else { document.getElementById('paymentMessage').innerHTML = '<div style="color:red">Error: '+(json.error||'Payment failed')+'</div>'; }
        }).catch(err=>{ document.getElementById('paymentMessage').innerHTML = '<div style="color:red">Payment failed</div>'; });
    }

    function resetWizard(){ selectedPatient = null; currentStep = 1; document.getElementById('patientSearchInput').value=''; document.getElementById('patientSearchResults').innerHTML=''; document.getElementById('selectedPatientName').textContent=''; document.getElementById('summaryPatient').textContent='Patient: —'; document.getElementById('summaryDate').textContent='Date: —'; document.getElementById('summaryTime').textContent='Time: —'; document.getElementById('paymentMessage').innerHTML=''; goToStep(1); }

    // Initialize modal step
    resetWizard();
    // Payment popup markup and handlers
    const paymentPopupHtml = `
    <div id="paymentPopup" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1300;">
        <div style="max-width:480px; margin:80px auto; background:#fff; border-radius:8px; padding:18px; position:relative;">
            <button id="paymentPopupClose" style="position:absolute; right:12px; top:8px; background:none; border:none; font-size:18px;">&times;</button>
            <h4 style="margin-top:0;">Card Payment</h4>
            <div style="margin-top:8px;"><input id="popupCardName" placeholder="Card Holder Name" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;"/></div>
            <div style="margin-top:8px;"><input id="popupCardNumber" placeholder="1234 5678 9012 3456" maxlength="19" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;"/></div>
            <div style="display:flex; gap:8px; margin-top:8px;">
                <input id="popupExpMonth" placeholder="MM" maxlength="2" style="flex:1; padding:10px; border-radius:6px; border:1px solid #e6eef5;"/>
                <input id="popupExpYear" placeholder="YY" maxlength="2" style="flex:1; padding:10px; border-radius:6px; border:1px solid #e6eef5;"/>
            </div>
            <div style="margin-top:8px;"><input id="popupCVC" placeholder="CVV" maxlength="4" style="width:40%; padding:10px; border-radius:6px; border:1px solid #e6eef5;"/></div>
            <div style="margin-top:14px; display:flex; gap:8px;"><button id="paymentPopupCancel" class="btn btn-light" style="flex:1;">Cancel</button><button id="paymentPopupPay" style="flex:1; background:#1aa179; border-color:#1aa179; color:#fff; padding:10px 12px; border-radius:6px;">Pay</button></div>
            <div id="paymentPopupMessage" style="margin-top:10px;"></div>
        </div>
    </div>`;
    document.body.insertAdjacentHTML('beforeend', paymentPopupHtml);

    const paymentPopup = document.getElementById('paymentPopup');
    document.getElementById('paymentOpenBtn')?.addEventListener('click', function(){ document.getElementById('paymentPopupMessage').innerHTML=''; paymentPopup.style.display='block'; });
    document.getElementById('paymentPopupClose').addEventListener('click', function(){ paymentPopup.style.display='none'; });
    document.getElementById('paymentPopupCancel').addEventListener('click', function(){ paymentPopup.style.display='none'; });

    // Format card number: groups of 4, max 16 digits
    const popupCardNumber = document.getElementById('popupCardNumber');
    popupCardNumber.placeholder = '4242 4242 4242 4242';
    popupCardNumber.addEventListener('input', function(e){
        let digits = this.value.replace(/\D/g,'').slice(0,16);
        let groups = digits.match(/.{1,4}/g);
        this.value = groups ? groups.join(' ') : '';
    });

    // Ensure month is 2 digits and within 01-12
    const popupExpMonth = document.getElementById('popupExpMonth');
    popupExpMonth.addEventListener('input', function(){ this.value = this.value.replace(/\D/g,'').slice(0,2); if(this.value.length===1 && this.value>'1') this.value = '0'+this.value; });

    // Ensure year is 2 digits
    const popupExpYear = document.getElementById('popupExpYear');
    popupExpYear.addEventListener('input', function(){ this.value = this.value.replace(/\D/g,'').slice(0,2); });

    // ensure CVV doesn't overflow and is inside modal: set maxlength and numeric only
    const popupCVC = document.getElementById('popupCVC');
    popupCVC.addEventListener('input', function(){ this.value = this.value.replace(/\D/g,'').slice(0,4); });

    // Pay click handler (popup)
    document.getElementById('paymentPopupPay').addEventListener('click', function(){
        const cardName = document.getElementById('popupCardName').value.trim();
        const cardNumberFormatted = document.getElementById('popupCardNumber').value.trim();
        const cardNumber = cardNumberFormatted.replace(/\s/g,'');
        const cardExpMonth = document.getElementById('popupExpMonth').value.trim();
        const cardExpYear = document.getElementById('popupExpYear').value.trim();
        const cardCVC = document.getElementById('popupCVC').value.trim();

        if(!cardName || cardNumber.length!==16 || !cardExpMonth || !cardExpYear || (cardCVC.length<3)){
            document.getElementById('paymentPopupMessage').innerHTML = '<div style="color:red">Please complete valid card details (16-digit card, MM, YY, CVV)</div>';
            return;
        }

        // Use same payload as submitPayment - take selectedPatient and appointment info from form
        if(!selectedPatient){ document.getElementById('paymentPopupMessage').innerHTML = '<div style="color:red">No patient selected</div>'; return; }
        const date = document.getElementById('appointmentDate').value; const time = document.getElementById('appointmentTime').value;
        if(!date || !time){ document.getElementById('paymentPopupMessage').innerHTML = '<div style="color:red">Date and time required</div>'; return; }

        document.getElementById('paymentPopupMessage').innerHTML = 'Processing...';

        const payload = { patient_id: selectedPatient.id, doctor_id: doctorId, appointment_date: date, appointment_time: time, cardName, cardNumber, cardExpMonth, cardExpYear, cardCVC };
        fetch('/doctor/appointments/pay', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf}, body: JSON.stringify(payload)})
        .then(r=>r.json()).then(json=>{
            if(json.success){
                document.getElementById('paymentPopupMessage').innerHTML = '<div style="color:green; font-weight:700">Payment Successful</div>';
                document.getElementById('paymentMessage').innerHTML = '<div style="color:green; font-weight:700">Payment Successful</div>';
                setTimeout(()=>{ paymentPopup.style.display='none'; hideModal(); resetWizard(); location.reload(); },800);
            } else {
                document.getElementById('paymentPopupMessage').innerHTML = '<div style="color:red">Payment failed: '+(json.error||'unknown')+'</div>';
            }
        }).catch(err=>{ document.getElementById('paymentPopupMessage').innerHTML = '<div style="color:red">Payment failed</div>'; });
    });
});
</script>

@endsection

