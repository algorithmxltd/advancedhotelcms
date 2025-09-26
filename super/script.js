// Mock data for hotel management
const hotelData = {
  stats: {
    totalBookings: 342,
    totalRooms: 45,
    occupancyRate: 87,
    monthlyRevenue: 125600
  },

  recentActivities: [
    { id: 1, type: 'booking', message: 'New booking for Deluxe Suite', time: '15 minutes ago' },
    { id: 2, type: 'content', message: 'Homepage banner updated', time: '2 hours ago' },
    { id: 3, type: 'review', message: 'New 5-star review received', time: '4 hours ago' },
    { id: 4, type: 'room', message: 'Ocean View room photos updated', time: '6 hours ago' }
  ],

  todaysCheckIns: [
    { id: 1, guest: 'John Smith', room: 'Deluxe Suite 201', time: '3:00 PM', nights: 3 },
    { id: 2, guest: 'Sarah Johnson', room: 'Ocean View 305', time: '4:00 PM', nights: 2 },
    { id: 3, guest: 'Mike Davis', room: 'Standard Room 101', time: '5:00 PM', nights: 1 },
    { id: 4, guest: 'Emily Wilson', room: 'Presidential Suite', time: '6:00 PM', nights: 5 }
  ],


  bookings: [
    { id: 1, guest: 'Alice Thompson', email: 'alice@email.com', room: 'Deluxe Suite', checkin: '2025-07-28', checkout: '2025-07-31', status: 'Confirmed' },
    { id: 2, guest: 'Bob Wilson', email: 'bob@email.com', room: 'Ocean View', checkin: '2025-07-29', checkout: '2025-08-02', status: 'Confirmed' },
    { id: 3, guest: 'Carol Martinez', email: 'carol@email.com', room: 'Standard Room', checkin: '2025-07-30', checkout: '2025-08-01', status: 'Pending' },
    { id: 4, guest: 'David Brown', email: 'david@email.com', room: 'Presidential Suite', checkin: '2025-08-01', checkout: '2025-08-05', status: 'Confirmed' }
  ],

  contentPages: [
    { id: 1, title: 'Homepage', type: 'Landing Page', lastUpdated: '2 hours ago', status: 'Published', views: 1250 },
    { id: 2, title: 'About Us', type: 'Static Page', lastUpdated: '1 day ago', status: 'Published', views: 340 },
    { id: 3, title: 'Amenities', type: 'Feature Page', lastUpdated: '3 days ago', status: 'Published', views: 890 },
    { id: 4, title: 'Contact', type: 'Contact Page', lastUpdated: '1 week ago', status: 'Published', views: 180 }
  ],

  reviews: [
    { id: 1, guest: 'Jennifer Lee', rating: 5, review: 'Amazing stay! The ocean view was breathtaking.', room: 'Ocean View', date: '2025-07-25', status: 'Published' },
    { id: 2, guest: 'Mark Johnson', rating: 4, review: 'Great service and comfortable rooms.', room: 'Deluxe Suite', date: '2025-07-24', status: 'Published' },
    { id: 3, guest: 'Lisa Chen', rating: 5, review: 'Perfect for our anniversary celebration.', room: 'Presidential Suite', date: '2025-07-23', status: 'Published' },
    { id: 4, guest: 'Tom Anderson', rating: 3, review: 'Good location but room could be cleaner.', room: 'Standard Room', date: '2025-07-22', status: 'Pending' }
  ]
};

// State management
let currentSection = 'overview';
let searchTerm = '';

// DOM elements
const sidebarNav = document.getElementById('sidebar-nav');
const sections = {
  overview: document.getElementById('overview-section'),
  rooms: document.getElementById('rooms-section'),
  addRoom: document.getElementById('addroom-section'),
  bookings: document.getElementById('bookings-section'),
  content: document.getElementById('content-section'),
  reviews: document.getElementById('reviews-section'),
  analytics: document.getElementById('analytics-section')
};

// Utility functions
function getInitials(name) {
  return name.split(' ').map(n => n[0]).join('');
}

function createStarRating(rating) {
  const stars = [];
  for (let i = 1; i <= 5; i++) {
    stars.push(`
      <svg class="review-star ${i <= rating ? 'filled' : 'empty'}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
      </svg>
    `);
  }
  return stars.join('');
}

function getActivityIcon(type) {
  const icons = {
    booking: '<svg class="activity-icon booking" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
    content: '<svg class="activity-icon content" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14,2 14,8 20,8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>',
    review: '<svg class="activity-icon review" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon></svg>',
    room: '<svg class="activity-icon room" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>'
  };
  return icons[type] || '';
}

// Navigation functions
function setActiveSection(sectionId) {
  // Update navigation
  const navItems = sidebarNav.querySelectorAll('.nav-item');
  navItems.forEach(item => {
    item.classList.remove('active');
    if (item.dataset.section === sectionId) {
      item.classList.add('active');
    }
  });

  // Update sections
  Object.keys(sections).forEach(key => {
    if (key === sectionId) {
      sections[key].classList.remove('hidden');
    } else {
      sections[key].classList.add('hidden');
    }
  });

  currentSection = sectionId;
}

// Render functions
function renderCheckIns() {
  const container = document.getElementById('checkins-list');
  const html = hotelData.todaysCheckIns.map(checkin => `
    <div class="checkin-item">
      <div class="checkin-guest">
        <div class="checkin-name">${checkin.guest}</div>
        <div class="checkin-room">${checkin.room} • ${checkin.nights} nights</div>
      </div>
      <div class="checkin-time">
        <div class="checkin-time-text">${checkin.time}</div>
        <div class="checkin-status">Expected</div>
      </div>
    </div>
  `).join('');
  container.innerHTML = html;
}

function renderActivities() {
  const container = document.getElementById('activities-list');
  const html = hotelData.recentActivities.map(activity => `
    <div class="activity-item">
      ${getActivityIcon(activity.type)}
      <div class="activity-content">
        <div class="activity-message">${activity.message}</div>
        <div class="activity-time">${activity.time}</div>
      </div>
    </div>
  `).join('');
  container.innerHTML = html;
}



function renderBookings() {
  const container = document.getElementById('bookings-table-body');
  const filteredBookings = hotelData.bookings.filter(booking => 
    booking.guest.toLowerCase().includes(searchTerm.toLowerCase()) ||
    booking.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
    booking.room.toLowerCase().includes(searchTerm.toLowerCase())
  );
  
  const html = filteredBookings.map(booking => `
    <tr>
      <td>
        <div class="guest-info">
          <div class="avatar">${getInitials(booking.guest)}</div>
          <div class="guest-details">
            <div class="guest-name">${booking.guest}</div>
            <div class="guest-email">${booking.email}</div>
          </div>
        </div>
      </td>
      <td>${booking.room}</td>
      <td>${booking.checkin}</td>
      <td>${booking.checkout}</td>
      <td>
        <span class="status-badge ${booking.status.toLowerCase()}">${booking.status}</span>
      </td>
      <td>
        <button class="btn-ghost">View</button>
      </td>
    </tr>
  `).join('');
  container.innerHTML = html;
}

function renderContent() {
  const container = document.getElementById('content-grid');
  const html = hotelData.contentPages.map(page => `
    <div class="content-card">
      <div class="content-header">
        <div class="content-info">
          <h3>${page.title}</h3>
          <div class="content-type">${page.type}</div>
        </div>
        <div class="content-status">${page.status}</div>
      </div>
      <div class="content-details">
        <div class="content-detail">
          <span>Last Updated:</span>
          <span class="room-detail-value">${page.lastUpdated}</span>
        </div>
        <div class="content-detail">
          <span>Page Views:</span>
          <div class="views-info">
            <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
            <span class="room-detail-value">${page.views}</span>
          </div>
        </div>
        <div class="content-actions">
          <button class="btn-outline flex-1">Edit</button>
          <button class="btn-icon-only">
            <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </button>
        </div>
      </div>
    </div>
  `).join('');
  container.innerHTML = html;
}

function renderReviews() {
  const container = document.getElementById('reviews-list');
  const html = hotelData.reviews.map(review => `
    <div class="review-card">
      <div class="review-content">
        <div class="review-main">
          <div class="review-avatar">${getInitials(review.guest)}</div>
          <div class="review-details">
            <div class="review-header">
              <div class="review-guest-name">${review.guest}</div>
              <div class="review-rating">
                ${createStarRating(review.rating)}
              </div>
            </div>
            <div class="review-text">"${review.review}"</div>
            <div class="review-meta">
              <span>${review.room}</span>
              <span>${review.date}</span>
            </div>
          </div>
        </div>
        <div class="review-actions">
          <div class="review-status ${review.status.toLowerCase()}">${review.status}</div>
          <button class="btn-ghost">
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  `).join('');
  container.innerHTML = html;
}

// Event listeners
function initializeEventListeners() {
  // Navigation
  sidebarNav.addEventListener('click', (e) => {
    const navItem = e.target.closest('.nav-item');
    if (navItem && navItem.dataset.section) {
      setActiveSection(navItem.dataset.section);
      
      // Render section-specific content
      if (navItem.dataset.section === 'rooms') {
        
      } else if (navItem.dataset.section === 'bookings') {
        renderBookings();
      } else if (navItem.dataset.section === 'content') {
        renderContent();
      } else if (navItem.dataset.section === 'reviews') {
        renderReviews();
      }
    }
  });

  // Search functionality
  const searchInput = document.getElementById('booking-search');
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      searchTerm = e.target.value;
      renderBookings();
    });
  }

  // Button interactions (placeholder functionality)
  document.addEventListener('click', (e) => {
    if (e.target.closest('.action-button, .btn-primary, .btn-outline, .btn-ghost')) {
      console.log('Button clicked:', e.target.closest('button').textContent.trim());
    }
  });
}

// Initialize the application
function init() {
  // Render initial content for overview section
  renderCheckIns();
  renderActivities();
  
  // Initialize event listeners
  initializeEventListeners();
  
  // Set initial section
  setActiveSection('overview');
  
  console.log('Hotel CMS Dashboard initialized');
}

// Start the application when DOM is loaded
document.addEventListener('DOMContentLoaded', init);