// Room Detail Page JavaScript

// Mock room data - In a real application, this would come from a database
const roomData = {
    roomNumber: '201',
    roomType: 'Deluxe Suite',
    price: 250,
    status: 'occupied', // available, occupied, maintenance
    capacity: '2 Adults, 1 Child',
    floor: '2nd Floor',
    amenities: ['WiFi', 'Air Conditioning', 'Mini Bar', 'Ocean View', 'King Bed', 'Smart TV'],
    currentOccupant: {
        guestName: 'John Smith',
        checkIn: '2025-01-15',
        checkOut: '2025-01-20',
        bookingSource: 'Direct Booking',
        email: 'john.smith@email.com',
        phone: '+1 (555) 123-4567'
    },
    bookingHistory: [
        {
            id: 1,
            guest: 'Emily Wilson',
            checkIn: '2025-01-10',
            checkOut: '2025-01-14',
            status: 'Completed',
            revenue: '$1,000'
        },
        {
            id: 2,
            guest: 'Michael Brown',
            checkIn: '2025-01-05',
            checkOut: '2025-01-09',
            status: 'Completed',
            revenue: '$1,000'
        },
        {
            id: 3,
            guest: 'Sarah Davis',
            checkIn: '2024-12-28',
            checkOut: '2025-01-02',
            status: 'Completed',
            revenue: '$1,250'
        }
    ],
    maintenanceLogs: [
        {
            id: 1,
            date: '2025-01-12',
            type: 'Routine Cleaning',
            description: 'Deep cleaning and sanitization',
            performedBy: 'Housekeeping Team A',
            status: 'Completed'
        },
        {
            id: 2,
            date: '2025-01-08',
            type: 'Repair',
            description: 'Fixed air conditioning unit',
            performedBy: 'Maintenance Staff',
            status: 'Completed'
        }
    ],
    notes: [
        {
            id: 1,
            author: 'Manager',
            date: '2025-01-16 10:30 AM',
            content: 'Guest requested extra pillows. Request fulfilled.'
        },
        {
            id: 2,
            author: 'Front Desk',
            date: '2025-01-15 2:00 PM',
            content: 'Check-in completed. Guest arrived early, room was ready.'
        }
    ]
};

// Calendar data - booked dates for this room
const bookedDates = [
    '2025-01-15', '2025-01-16', '2025-01-17', '2025-01-18', '2025-01-19', '2025-01-20',
    '2025-01-25', '2025-01-26', '2025-01-27',
    '2025-02-05', '2025-02-06', '2025-02-07', '2025-02-08'
];

let currentMonth = new Date();

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
    renderCalendar();
});

function initializePage() {
    // Update header
    document.getElementById('roomNumber').textContent = `Room ${roomData.roomNumber}`;
    document.getElementById('roomType').textContent = roomData.roomType;
    updateRoomStatus(roomData.status);
    
    // Update details
    document.getElementById('detailRoomNumber').textContent = roomData.roomNumber;
    document.getElementById('detailRoomType').textContent = roomData.roomType;
    document.getElementById('detailPrice').textContent = `$${roomData.price}`;
    document.getElementById('detailStatus').textContent = capitalizeFirst(roomData.status);
    document.getElementById('detailCapacity').textContent = roomData.capacity;
    document.getElementById('detailFloor').textContent = roomData.floor;
    
    // Render amenities
    renderAmenities();
    
    // Render occupancy
    renderOccupancy();
    
    // Render booking history
    renderBookingHistory();
    
    // Render maintenance logs
    renderMaintenanceLogs();
    
    // Render notes
    renderNotes();
}

function updateRoomStatus(status) {
    const statusBadge = document.getElementById('roomStatus');
    statusBadge.className = `status-badge status-${status}`;
    statusBadge.textContent = capitalizeFirst(status);
}

function renderAmenities() {
    const amenitiesList = document.getElementById('amenitiesList');
    amenitiesList.innerHTML = roomData.amenities
        .map(amenity => `<span class="amenity-tag">${amenity}</span>`)
        .join('');
}

function renderOccupancy() {
    const occupancyContent = document.getElementById('occupancyContent');
    
    if (roomData.status === 'occupied' && roomData.currentOccupant) {
        occupancyContent.innerHTML = `
            <div class="occupancy-info">
                <div class="occupancy-item">
                    <span class="occupancy-label">Guest Name</span>
                    <span class="occupancy-value">${roomData.currentOccupant.guestName}</span>
                </div>
                <div class="occupancy-item">
                    <span class="occupancy-label">Check-in Date</span>
                    <span class="occupancy-value">${formatDate(roomData.currentOccupant.checkIn)}</span>
                </div>
                <div class="occupancy-item">
                    <span class="occupancy-label">Check-out Date</span>
                    <span class="occupancy-value">${formatDate(roomData.currentOccupant.checkOut)}</span>
                </div>
                <div class="occupancy-item">
                    <span class="occupancy-label">Booking Source</span>
                    <span class="occupancy-value">${roomData.currentOccupant.bookingSource}</span>
                </div>
                <div class="occupancy-item">
                    <span class="occupancy-label">Email</span>
                    <span class="occupancy-value">${roomData.currentOccupant.email}</span>
                </div>
                <div class="occupancy-item">
                    <span class="occupancy-label">Phone</span>
                    <span class="occupancy-value">${roomData.currentOccupant.phone}</span>
                </div>
            </div>
        `;
    } else {
        occupancyContent.innerHTML = `
            <div class="assign-guest-section">
                <p>This room is currently available</p>
                <button class="btn btn-primary btn-large" id="assignGuestBtn">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Assign Guest / Book Room
                </button>
            </div>
        `;
        
        // Add event listener for assign guest button
        setTimeout(() => {
            const assignBtn = document.getElementById('assignGuestBtn');
            if (assignBtn) {
                assignBtn.addEventListener('click', () => {
                    alert('Opening booking form... (This would navigate to booking page in full application)');
                });
            }
        }, 0);
    }
}

function renderBookingHistory() {
    const historyList = document.getElementById('bookingHistoryList');
    
    if (roomData.bookingHistory.length === 0) {
        historyList.innerHTML = '<div class="empty-state">No booking history available</div>';
        return;
    }
    
    historyList.innerHTML = roomData.bookingHistory
        .map(booking => `
            <div class="history-item">
                <div class="history-field">
                    <span class="field-label">Guest Name</span>
                    <span class="field-value">${booking.guest}</span>
                </div>
                <div class="history-field">
                    <span class="field-label">Check-in</span>
                    <span class="field-value">${formatDate(booking.checkIn)}</span>
                </div>
                <div class="history-field">
                    <span class="field-label">Check-out</span>
                    <span class="field-value">${formatDate(booking.checkOut)}</span>
                </div>
                <div class="history-field">
                    <span class="field-label">Status</span>
                    <span class="field-value">${booking.status}</span>
                </div>
                <div class="history-field">
                    <span class="field-label">Revenue</span>
                    <span class="field-value">${booking.revenue}</span>
                </div>
            </div>
        `)
        .join('');
}

function renderMaintenanceLogs() {
    const maintenanceList = document.getElementById('maintenanceList');
    
    if (roomData.maintenanceLogs.length === 0) {
        maintenanceList.innerHTML = '<div class="empty-state">No maintenance logs available</div>';
        return;
    }
    
    maintenanceList.innerHTML = roomData.maintenanceLogs
        .map(log => `
            <div class="maintenance-item">
                <div class="maintenance-field">
                    <span class="field-label">Date</span>
                    <span class="field-value">${formatDate(log.date)}</span>
                </div>
                <div class="maintenance-field">
                    <span class="field-label">Type</span>
                    <span class="field-value">${log.type}</span>
                </div>
                <div class="maintenance-field">
                    <span class="field-label">Description</span>
                    <span class="field-value">${log.description}</span>
                </div>
                <div class="maintenance-field">
                    <span class="field-label">Performed By</span>
                    <span class="field-value">${log.performedBy}</span>
                </div>
                <div class="maintenance-field">
                    <span class="field-label">Status</span>
                    <span class="field-value">${log.status}</span>
                </div>
            </div>
        `)
        .join('');
}

function renderNotes() {
    const notesList = document.getElementById('notesList');
    
    if (roomData.notes.length === 0) {
        notesList.innerHTML = '<div class="empty-state">No notes or comments</div>';
        return;
    }
    
    notesList.innerHTML = roomData.notes
        .map(note => `
            <div class="note-item">
                <div class="note-header">
                    <span class="note-author">${note.author}</span>
                    <span class="note-date">${note.date}</span>
                </div>
                <div class="note-content">${note.content}</div>
            </div>
        `)
        .join('');
}

function setupEventListeners() {
    // Back button
    document.getElementById('backBtn').addEventListener('click', () => {
        // In a real app, this would navigate back
        alert('Navigating back to rooms list...');
    });
    
    // Edit button
    document.getElementById('editBtn').addEventListener('click', () => {
        alert('Opening edit form... (This would open an edit modal in full application)');
    });
    
    // Delete button
    document.getElementById('deleteBtn').addEventListener('click', () => {
        document.getElementById('deleteModal').classList.add('active');
    });
    
    // Close delete modal
    document.getElementById('closeDeleteModal').addEventListener('click', () => {
        document.getElementById('deleteModal').classList.remove('active');
    });
    
    document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
        document.getElementById('deleteModal').classList.remove('active');
    });
    
    // Confirm delete
    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        alert('Room deleted successfully!');
        document.getElementById('deleteModal').classList.remove('active');
        // In a real app, this would make an API call and redirect
    });
    
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.getAttribute('data-tab');
            switchTab(tabId);
        });
    });
    
    // Add note
    document.getElementById('addNoteBtn').addEventListener('click', () => {
        const noteInput = document.getElementById('newNote');
        const noteText = noteInput.value.trim();
        
        if (noteText) {
            const newNote = {
                id: roomData.notes.length + 1,
                author: 'Current User',
                date: new Date().toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                }),
                content: noteText
            };
            
            roomData.notes.unshift(newNote);
            renderNotes();
            noteInput.value = '';
        }
    });
    
    // Action buttons
    document.getElementById('changeStatusBtn').addEventListener('click', () => {
        document.getElementById('statusModal').classList.add('active');
    });
    
    document.getElementById('closeStatusModal').addEventListener('click', () => {
        document.getElementById('statusModal').classList.remove('active');
    });
    
    // Status options
    const statusOptions = document.querySelectorAll('.status-option');
    statusOptions.forEach(option => {
        option.addEventListener('click', () => {
            const newStatus = option.getAttribute('data-status');
            changeRoomStatus(newStatus);
        });
    });
    
    document.getElementById('markCleanedBtn').addEventListener('click', () => {
        alert('Room marked as cleaned!');
        // Add to maintenance log
        const cleaningLog = {
            id: roomData.maintenanceLogs.length + 1,
            date: new Date().toISOString().split('T')[0],
            type: 'Cleaning',
            description: 'Room cleaned and sanitized',
            performedBy: 'Housekeeping',
            status: 'Completed'
        };
        roomData.maintenanceLogs.unshift(cleaningLog);
        renderMaintenanceLogs();
    });
    
    document.getElementById('generateReportBtn').addEventListener('click', () => {
        alert('Generating room report... (This would generate a PDF in full application)');
    });
    
    document.getElementById('printSummaryBtn').addEventListener('click', () => {
        window.print();
    });
    
    // Calendar navigation
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() - 1);
        renderCalendar();
    });
    
    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() + 1);
        renderCalendar();
    });
    
    // Auto toggle
    document.getElementById('autoAvailableToggle').addEventListener('change', (e) => {
        if (e.target.checked) {
            console.log('Auto mark available: Enabled');
        } else {
            console.log('Auto mark available: Disabled');
        }
    });
    
    // Close modals on outside click
    document.getElementById('statusModal').addEventListener('click', (e) => {
        if (e.target.id === 'statusModal') {
            document.getElementById('statusModal').classList.remove('active');
        }
    });
    
    document.getElementById('deleteModal').addEventListener('click', (e) => {
        if (e.target.id === 'deleteModal') {
            document.getElementById('deleteModal').classList.remove('active');
        }
    });
}

function switchTab(tabId) {
    // Remove active class from all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelectorAll('.tab-panel').forEach(panel => {
        panel.classList.remove('active');
    });
    
    // Add active class to selected tab
    document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
    document.getElementById(tabId).classList.add('active');
}

function changeRoomStatus(newStatus) {
    roomData.status = newStatus;
    updateRoomStatus(newStatus);
    renderOccupancy();
    document.getElementById('statusModal').classList.remove('active');
    alert(`Room status changed to: ${capitalizeFirst(newStatus)}`);
}

function renderCalendar() {
    const calendar = document.getElementById('miniCalendar');
    const monthDisplay = document.getElementById('currentMonth');
    
    const year = currentMonth.getFullYear();
    const month = currentMonth.getMonth();
    
    // Update month display
    monthDisplay.textContent = currentMonth.toLocaleDateString('en-US', { 
        month: 'long', 
        year: 'numeric' 
    });
    
    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    const today = new Date();
    const todayStr = formatDateForComparison(today);
    
    let calendarHTML = '';
    
    // Add day headers
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    dayNames.forEach(day => {
        calendarHTML += `<div class="calendar-day header">${day}</div>`;
    });
    
    // Add previous month's trailing days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        calendarHTML += `<div class="calendar-day date other-month">${day}</div>`;
    }
    
    // Add current month's days
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = formatDateForComparison(new Date(year, month, day));
        let classes = 'calendar-day date';
        
        if (dateStr === todayStr) {
            classes += ' today';
        } else if (bookedDates.includes(dateStr)) {
            classes += ' booked';
        } else {
            classes += ' available';
        }
        
        calendarHTML += `<div class="${classes}">${day}</div>`;
    }
    
    // Add next month's leading days
    const totalCells = calendarHTML.match(/calendar-day/g).length - 7; // Subtract header row
    const remainingCells = (Math.ceil(totalCells / 7) * 7) - totalCells;
    for (let day = 1; day <= remainingCells; day++) {
        calendarHTML += `<div class="calendar-day date other-month">${day}</div>`;
    }
    
    calendar.innerHTML = calendarHTML;
}

// Utility functions
function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function formatDateForComparison(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}
