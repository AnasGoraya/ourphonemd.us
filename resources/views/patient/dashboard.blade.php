@extends('layouts.patient')

@section('page_title', 'Dashboard')

@section('content')
    <div class="dashboard-container" style="padding: 32px 0;">
        <div class="dashboard-header" style="margin-bottom: 0;">
        </div>
<h2 style="font-weight: bold; color: #51A897;">
    Patient Dashboard
</h2>

        <!-- Calendar Content for Previous Appointments -->
        <div id="pastAppointmentsCalendar" style="display: none;">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Previous Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your past appointment history</p>
                <button onclick="showDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthPast()">&larr; Previous</button>
                            <button onclick="todayPast()">Today</button>
                            <button onclick="nextMonthPast()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="pastCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="pastCalendarGrid">
                    <!-- Past appointments calendar will be generated here -->
                </div>

                <div class="appointments-list" id="pastAppointmentsList">
                    <!-- Past appointments for selected date will appear here -->
                </div>
            </div>
        </div>

        <!-- Calendar Content for Upcoming Appointments -->
        <div id="upcomingAppointmentsCalendar" style="display: none;">
            <div class="mb-8">
                <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">Upcoming Appointments</h1>
                <p class="text-muted" style="font-size: 1.05rem;">View your scheduled upcoming appointments</p>
                <button onclick="showDashboard()" style="background-color: rgb(87, 165, 150); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; margin-top: 10px;">Back to Dashboard</button>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthUpcoming()">&larr; Previous</button>
                            <button onclick="todayUpcoming()">Today</button>
                            <button onclick="nextMonthUpcoming()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="upcomingCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="upcomingCalendarGrid">
                    <!-- Upcoming appointments calendar will be generated here -->
                </div>

                <div class="appointments-list" id="upcomingAppointmentsList">
                    <!-- Upcoming appointments for selected date will appear here -->
                </div>
            </div>
        </div>

        <!-- Calendar Content for Completed Visits -->
        <div id="completedVisitsCalendar" style="display: none;">
            <div class="mb-8">
            <h1 class="dashboard-title" style="color: #3EA293; font-size: 2.1rem; font-weight: 500; margin-bottom: 8px;">Previous Visits</h1>

            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthCompleted()">&larr; Previous</button>
                            <button onclick="todayCompleted()">Today</button>
                            <button onclick="nextMonthCompleted()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="completedCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="completedCalendarGrid">
                    <!-- Completed visits calendar will be generated here -->
                </div>

                <div class="appointments-list" id="completedVisitsList">
                    <!-- Completed visits for selected date will appear here -->
                </div>
            </div>
        </div>

        <!-- Calendar Content for Walk-in Appointments -->
        <div id="walkinAppointmentsCalendar" style="display: none;">
            <div class="mb-8">
            <h1 class="dashboard-title" style="color: #3EA293; font-size: 2.1rem; font-weight: 700; margin-bottom: 8px;">Walk in Appointment</h1>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthWalkin()">&larr; Previous</button>
                            <button onclick="todayWalkin()">Today</button>
                            <button onclick="nextMonthWalkin()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="walkinCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="walkinCalendarGrid">
                    <!-- Walk-in appointments calendar will be generated here -->
                </div>

                <div class="appointments-list" id="walkinAppointmentsList">
                    <!-- Walk-in appointments for selected date will appear here -->
                </div>
            </div>
        </div>

        <!-- Calendar Content for Work/School Notes -->
        <div id="notesCalendar" style="display: none;">
            <div class="mb-8">
            <h1 class="dashboard-title" style="color: #3EA293; font-size: 2.1rem; font-weight: 700; margin-bottom: 8px;">Work/School Notes</h1>
            </div>
            <div class="calendar-full-page">
                <div class="calendar-header mb-4">
                    <div>
                        <div class="calendar-nav">
                            <button onclick="previousMonthNotes()">&larr; Previous</button>
                            <button onclick="todayNotes()">Today</button>
                            <button onclick="nextMonthNotes()">Next &rarr;</button>
                        </div>
                    </div>
                    <h2 class="calendar-title" id="notesCalendarTitle">November 2025</h2>
                    <div class="calendar-view-toggles">
                        <button class="view-btn active" onclick="switchView('month')">Month</button>
                    </div>
                </div>

                <div class="calendar-grid" id="notesCalendarGrid">
                    <!-- Notes calendar will be generated here -->
                </div>

                <div class="appointments-list" id="notesList">
                    <!-- Notes for selected date will appear here -->
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <!-- Upcoming Appointments -->
            <a href="{{ route('patient.appointment.dashboard') }}" class="stat-card">
                <div class="stat-icon appointments">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-label" style="color: #000000;">Upcoming Appointments</div>
                <div class="stat-footer">
                    <div class="stat-number" style="color: #1a2e35;">{{ $upcomingAppointmentsCount ?? 0 }}</div>
                    <div class="stat-link" style="color: #3EA293;">View details</div>
                </div>
            </a>
            <!-- Family Members -->
            <a href="/patient/family-member" class="stat-card">
                <div class="stat-icon family">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label" style="color: #000000;">My Family</div>
                <div class="stat-footer">
                    <div class="stat-number" style="color: #1a2e35;">{{ $familyMembersCount ?? 0 }}</div>
                    <div class="stat-link" style="color: #3EA293;">View details</div>
                </div>
            </a>
            <!-- Previous/Completed Visits -->
            <a href="javascript:void(0)" onclick="showCompletedVisitsCalendar()" class="stat-card">
                <div class="stat-icon visits">
                    <i class="fas fa-file-medical-alt"></i>
                </div>
                <div class="stat-label" style="color: #000000;">Previous/Completed Visits</div>
                <div class="stat-footer">
                    <div class="stat-number" style="color: #1a2e35;">{{ $completedVisitsCount ?? 0 }}</div>
                    <div class="stat-link" style="color: #3EA293;">View details</div>
                </div>
            </a>
            <!-- Walk-in Appointments -->
            <a href="javascript:void(0)" onclick="showWalkinAppointmentsCalendar()" class="stat-card">
                <div class="stat-icon walkin">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-label" style="color: #000000;">Walk-in Appointments</div>
                <div class="stat-footer">
                    <div class="stat-number" style="color: #1a2e35;">{{ $walkinAppointmentsCount ?? 0 }}</div>
                    <div class="stat-link" style="color: #3EA293;">View details</div>
                </div>
            </a>
            <!-- Work/School Notes -->
            <a href="{{ route('patient.notes') }}" class="stat-card">
                <div class="stat-icon notes">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-label" style="color: #000000;">Work/School Notes</div>
                <div class="stat-footer">
                    <div class="stat-number" style="color: #1a2e35;">{{ $notesCount ?? 0 }}</div>
                    <div class="stat-link" style="color: #3EA293;">View details</div>
                </div>
            </a>
            <!-- Support Card -->
            <div class="support-card">
                <h3 class="support-title">Need assistance?</h3>
                <p class="support-subtitle">Our support team is available 24/7</p>
                <a href="/patient/contact-us" class="support-btn">Contact Support</a>
            </div>
        </div>
    </div>

<style>
/* Your existing CSS styles remain the same */
.dashboard-container {
    padding: 20px;
}
.dashboard-header {
    margin-bottom: 30px;
}
.dashboard-title {
    color: #2c3e50;
    margin-bottom: 10px;
}
.quick-actions {
    margin-bottom: 30px;
}
.action-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: rgb(87, 165, 150);
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
    font-weight: 700;
    padding: 10px 15px;
}
.action-btn.secondary {
    background-color: rgb(87, 165, 150);
}
.action-btn:hover {
    background-color: rgb(70, 140, 127);
    color: white;
}
.action-btn.secondary:hover {
    background-color: #545b62;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}
.stat-card {
    background: #F6FBFA;
    padding: 12px 25px; /* Decreased top and bottom padding to reduce height */
    border-radius: 10px;
    /* Undo border solid */
    border: none;
    /* Removed box-shadow as requested */
    box-shadow: none;
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s;
    cursor: pointer;
}
.stat-card:hover {
    transform: translateY(-5px);
    color: inherit;
}

/* Updated icon styles - White border with darker background */
.stat-icon {
    width: 50px;
    height: 50px;a
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    /* White border effect */
    -webkit-text-stroke: 0.5px #ffffff !important;
    paint-order: stroke fill;
    color: white !important;
    text-shadow: none !important;
}

/* Darker background colors for icons */
.stat-icon.appointments {
    background-color: #51A897 !important; /* Darker blue */
    color: #ffffff !important;
}
.stat-icon.family {
    background-color: #3B82F6 !important; /* Darker purple */
    color: #ffffff !important;
}
.stat-icon.visits {
    background-color: #A855F7 !important; /* Darker green */
    color: #ffffff !important;
}
.stat-icon.walkin {
    background-color: #F59E0B !important; /* Darker orange */
    color: #ffffff !important;
}
.stat-icon.notes {
    background-color: #10B981 !important; /* Darker pink */
    color: #ffffff !important;
}
.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0;
    line-height: 1.2;
}
.stat-label {
    color: #666;
    margin-bottom: 10px;
}
.stat-link {
    color: #28a745;
    font-size: 0.9rem;
    margin-top: 0;
    line-height: 1.2;
    display: flex;
    align-items: center;
    padding-left: 130px;
}
.stat-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.support-card {
    background: linear-gradient(120deg, ##52A8A0 50%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 10px;
    display: flex;
    justify-content: between;
    align-items: center;
}
.support-title {
    margin-bottom: 5px;
}
.support-subtitle {
    opacity: 0.9;
    margin-bottom: 0;
}
.support-btn {
    background: white;
    color: #667eea;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
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
</style>

<script>
// Parse appointments from PHP data
const pastAppointments = @json($pastAppointments ?? []);
const upcomingAppointments = @json($upcomingAppointments ?? []);
const completedVisits = @json($completedVisits ?? []);
const walkinAppointments = @json($walkinAppointments ?? []);
const notes = @json($notes ?? []);

// ...existing code...
console.log('Past Appointments:', pastAppointments);
console.log('First Upcoming:', upcomingAppointments[0]);
console.log('Completed Visits:', completedVisits);
console.log('Walk-in Appointments:', walkinAppointments);

// ...existing code...
// ...existing code...
// Build maps of dates to appointments
const pastAppointmentsByDate = {};
const upcomingAppointmentsByDate = {};
const completedVisitsByDate = {};
const walkinAppointmentsByDate = {};
const notesByDate = {};

pastAppointments.forEach(apt => {
    const date = apt.appointment_date;
    if (!pastAppointmentsByDate[date]) pastAppointmentsByDate[date] = [];
    pastAppointmentsByDate[date].push(apt);
});

upcomingAppointments.forEach(apt => {
    const date = apt.appointment_date;
    if (!upcomingAppointmentsByDate[date]) upcomingAppointmentsByDate[date] = [];
    upcomingAppointmentsByDate[date].push(apt);
});

completedVisits.forEach(apt => {
    const date = apt.appointment_date;
    if (!completedVisitsByDate[date]) completedVisitsByDate[date] = [];
    completedVisitsByDate[date].push(apt);
});

walkinAppointments.forEach(apt => {
    const date = apt.appointment_date;
    if (!walkinAppointmentsByDate[date]) walkinAppointmentsByDate[date] = [];
    walkinAppointmentsByDate[date].push(apt);
});

notes.forEach(note => {
    // Determine date from created_at
    let date = '2025-01-01'; // Fallback
    if(note.created_at) {
        date = note.created_at.substring(0, 10); // YYYY-MM-DD
    }
    if (!notesByDate[date]) notesByDate[date] = [];
    notesByDate[date].push(note);
});

// Date variables for calendars
let pastCurrentDate = new Date();
let upcomingCurrentDate = new Date();
let completedCurrentDate = new Date();
let walkinCurrentDate = new Date();
let notesCurrentDate = new Date();

function renderCalendar(calendarType, currentDate, appointmentsByDate, containerId, titleId, gridId, listId) {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();


    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    const calendarGrid = document.getElementById(gridId);
    calendarGrid.innerHTML = '';

    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    weekdays.forEach(day => {
        const dayHeader = document.createElement('div');
        dayHeader.className = 'weekday-header';
        dayHeader.textContent = day;
        calendarGrid.appendChild(dayHeader);
    });

    for (let i = firstDay - 1; i >= 0; i--) {
        const day = document.createElement('div');
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
        if (hasData) day.classList.add('has-appointment');

        day.textContent = i;
        day.onclick = () => showDataForDate(calendarType, dateStr, listId, appointmentsByDate);
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
    showDataForDate(calendarType, todayStr, listId, appointmentsByDate);
}

function showDataForDate(calendarType, dateStr, listId, dataByDate) {
    const listElement = document.getElementById(listId);
    const data = dataByDate[dateStr] || [];

    if (data.length === 0) {
        listElement.innerHTML = `
            <div class="no-appointments-message">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 2v4"></path>
                    <path d="M16 2v4"></path>
                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                    <path d="M3 10h18"></path>
                </svg>
                <p>No ${getCalendarTypeLabel(calendarType)} on this date</p>
            </div>
        `;
        return;
    }

    const dateObj = new Date(dateStr);
    const formattedDate = dateObj.toLocaleString('default', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

    let html = `<h3>${getCalendarTypeLabel(calendarType)} for ${formattedDate}</h3>`;

    data.forEach(item => {
        html += createListItem(calendarType, item);
    });

    listElement.innerHTML = html;
}

function getCalendarTypeLabel(calendarType) {
    const labels = {
        'past': 'Past Appointments',
        'upcoming': 'Upcoming Appointments',
        'completed': 'Completed Visits',
        'walkin': 'Walk-in Appointments',
        'notes': 'Work/School Notes'
    };
    return labels[calendarType] || 'Items';
}

function createListItem(calendarType, item) {
    switch(calendarType) {
        case 'past':
        case 'upcoming':
            const time = item.appointment_time ? new Date(`2000-01-01 ${item.appointment_time}`).toLocaleString('default', { hour: '2-digit', minute: '2-digit', hour12: true }) : 'N/A';
            const statusClass = item.status.toLowerCase();

            // Show who this appointment is for
            let patientName = item.member_name && item.relationship ? `${item.relationship.charAt(0).toUpperCase() + item.relationship.slice(1)}: ${item.member_name}` : (item.patient_name || 'Patient');
            let nameColor = item.member_name && item.relationship ? '#51A897' : '#333';

            return `
                <div class="appointment-item">
                    <div class="appointment-details">
                        <div style="font-size: 16px; font-weight: 700; color: ${nameColor}; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 2px solid ${nameColor};">
                            ${patientName}
                        </div>
                        <strong>Dr. ${item.doctor_name || item.doctor?.name || 'N/A'}</strong>

                        <small>${time}</small>
                        <small>${item.appointment_mode === 'telemedicine' ? '👁️ Virtual Consultation' : '🏥 In-Person Visit'}</small>
                    </div>
                    <span class="appointment-status ${statusClass}">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span>
                </div>
            `;

        case 'completed':
            // Show who this visit is for
            let completedPatientName = item.member_name && item.relationship ? `${item.relationship.charAt(0).toUpperCase() + item.relationship.slice(1)}: ${item.member_name}` : (item.patient_name || 'Patient');
            let completedNameColor = item.member_name && item.relationship ? '#51A897' : '#333';

            return `
                <div class="appointment-item">
                    <div class="appointment-details">
                        <div style="font-size: 16px; font-weight: 700; color: ${completedNameColor}; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 2px solid ${completedNameColor};">
                            ${completedPatientName}
                        </div>
                        <strong>${item.doctor_name || 'Doctor'}</strong>
                        <small>Visit Date: ${item.visit_date || 'N/A'}</small>
                        <small>Diagnosis: ${item.diagnosis || 'Not specified'}</small>
                    <span class="appointment-status completed">Completed</span>
                </div>
            `;

        case 'walkin':
            const walkinTime = item.appointment_time ? new Date(`2000-01-01 ${item.appointment_time}`).toLocaleString('default', { hour: '2-digit', minute: '2-digit', hour12: true }) : 'N/A';
            
            // Show who this walk-in is for
            let walkinPatientName = item.member_name && item.relationship ? `${item.relationship.charAt(0).toUpperCase() + item.relationship.slice(1)}: ${item.member_name}` : (item.patient_name || 'Patient');
            let walkinNameColor = item.member_name && item.relationship ? '#51A897' : '#333';
            
            return `
                <div class="appointment-item">
                    <div class="appointment-details">
                        <div style="font-size: 16px; font-weight: 700; color: ${walkinNameColor}; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 2px solid ${walkinNameColor};">
                            ${walkinPatientName}
                        </div>
                        <strong>Walk-in Appointment</strong>
                        <small>${walkinTime}</small>
                    </div>
                    <span class="appointment-status confirmed">Walk-in</span>
                </div>
            `;

        case 'notes':
            const noteDate = item.created_at ? new Date(item.created_at).toLocaleDateString() : 'N/A';
            return `
                <div class="appointment-item">
                    <div class="appointment-details">
                        <strong>${item.type ? (item.type.charAt(0).toUpperCase() + item.type.slice(1) + ' Note') : 'Note'}</strong>
                        <small>Date: ${noteDate}</small>
                        <small>Doctor: ${item.doctor ? item.doctor.name : 'Unknown'}</small>
                        <div style="margin-top:4px; font-size:13px; color:#555;">${item.content || ''}</div>
                    </div>
                    <span class="appointment-status completed">View</span>
                </div>
            `;

        default:
            return `<div class="appointment-item">Unknown item type</div>`;
    }
}

// Navigation functions for all calendars
function nextMonthPast() {
    pastCurrentDate.setMonth(pastCurrentDate.getMonth() + 1);
}

function previousMonthPast() {
    pastCurrentDate.setMonth(pastCurrentDate.getMonth() - 1);
    renderPastCalendar();
}

function todayPast() {
    pastCurrentDate = new Date();
    renderPastCalendar();

function nextMonthUpcoming() {
    upcomingCurrentDate.setMonth(upcomingCurrentDate.getMonth() + 1);
}

function previousMonthUpcoming() {
    upcomingCurrentDate.setMonth(upcomingCurrentDate.getMonth() - 1);
    renderUpcomingCalendar();
}

function todayUpcoming() {
    upcomingCurrentDate = new Date();
    renderUpcomingCalendar();
}

function nextMonthCompleted() {
    completedCurrentDate.setMonth(completedCurrentDate.getMonth() + 1);
    renderCompletedCalendar();
}

function previousMonthCompleted() {
    completedCurrentDate.setMonth(completedCurrentDate.getMonth() - 1);
    renderCompletedCalendar();
}

function todayCompleted() {
    completedCurrentDate = new Date();
    renderCompletedCalendar();
}

function nextMonthWalkin() {
    walkinCurrentDate.setMonth(walkinCurrentDate.getMonth() + 1);
    renderWalkinCalendar();
}

function previousMonthWalkin() {
    walkinCurrentDate.setMonth(walkinCurrentDate.getMonth() - 1);
    renderWalkinCalendar();
}

function todayWalkin() {
    walkinCurrentDate = new Date();
    renderWalkinCalendar();
}

function nextMonthNotes() {
    notesCurrentDate.setMonth(notesCurrentDate.getMonth() + 1);
    renderNotesCalendar();
}

function previousMonthNotes() {
    notesCurrentDate.setMonth(notesCurrentDate.getMonth() - 1);
    renderNotesCalendar();
}

function todayNotes() {
    notesCurrentDate = new Date();
    renderNotesCalendar();
}

// Calendar rendering functions for each type
function renderPastCalendar() {
    renderCalendar('past', pastCurrentDate, pastAppointmentsByDate, 'pastAppointmentsCalendar', 'pastCalendarTitle', 'pastCalendarGrid', 'pastAppointmentsList');
}

function renderUpcomingCalendar() {
    renderCalendar('upcoming', upcomingCurrentDate, upcomingAppointmentsByDate, 'upcomingAppointmentsCalendar', 'upcomingCalendarTitle', 'upcomingCalendarGrid', 'upcomingAppointmentsList');
}

function renderCompletedCalendar() {
    renderCalendar('completed', completedCurrentDate, completedVisitsByDate, 'completedVisitsCalendar', 'completedCalendarTitle', 'completedCalendarGrid', 'completedVisitsList');
}

function renderWalkinCalendar() {
    renderCalendar('walkin', walkinCurrentDate, walkinAppointmentsByDate, 'walkinAppointmentsCalendar', 'walkinCalendarTitle', 'walkinCalendarGrid', 'walkinAppointmentsList');
}

function renderNotesCalendar() {
    renderCalendar('notes', notesCurrentDate, notesByDate, 'notesCalendar', 'notesCalendarTitle', 'notesCalendarGrid', 'notesList');
}



// View switching functions
function showPastAppointmentsCalendar() {
    hideAllCalendars();
    document.getElementById('pastAppointmentsCalendar').style.display = 'block';
    renderPastCalendar();
}

function showUpcomingAppointmentsCalendar() {
    hideAllCalendars();
    document.getElementById('upcomingAppointmentsCalendar').style.display = 'block';
    renderUpcomingCalendar();
}

function showCompletedVisitsCalendar() {
    hideAllCalendars();
    document.getElementById('completedVisitsCalendar').style.display = 'block';
    renderCompletedCalendar();
}

function showWalkinAppointmentsCalendar() {
    hideAllCalendars();
    document.getElementById('walkinAppointmentsCalendar').style.display = 'block';
    renderWalkinCalendar();
}

function showNotesCalendar() {
    hideAllCalendars();
    document.getElementById('notesCalendar').style.display = 'block';
    renderNotesCalendar();
}

function showDashboard() {
    hideAllCalendars();
    document.querySelector('.stats-grid').style.display = 'grid';
}

function hideAllCalendars() {
    document.querySelector('.stats-grid').style.display = 'none';
    document.getElementById('pastAppointmentsCalendar').style.display = 'none';
    document.getElementById('upcomingAppointmentsCalendar').style.display = 'none';
    document.getElementById('completedVisitsCalendar').style.display = 'none';
    document.getElementById('walkinAppointmentsCalendar').style.display = 'none';
    document.getElementById('notesCalendar').style.display = 'none';
}

function switchView(view) {
    console.log('Switched to ' + view + ' view');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Dashboard is shown by default
});
</script>

@endsection
