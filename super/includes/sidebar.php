<div class="sidebar">
  <div class="sidebar-header">
    <h1 class="sidebar-title">Mt.Everest Hotel</h1>
    <p class="sidebar-subtitle">Hotel Management</p>
  </div>

  <nav class="sidebar-nav" id="sidebar-nav">
    <a href="index.php" class="nav-item sidebar-link">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="20" x2="12" y2="10"></line>
        <line x1="18" y1="20" x2="18" y2="4"></line>
        <line x1="6" y1="20" x2="6" y2="16"></line>
      </svg>
      <span>Overview</span>
    </a>

    <a href="rooms.php" class="nav-item sidebar-link">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M2 4v16"></path>
        <path d="M2 8h18a2 2 0 0 1 2 2v10"></path>
        <path d="M2 17h20"></path>
        <path d="M6 8v9"></path>
      </svg>
      <span>Rooms</span>
    </a>

    <a href="addRoom.php" class="nav-item sidebar-link">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      <span>Add Room</span>
    </a>

    <a href="bookings.php" class="nav-item sidebar-link">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
      </svg>
      <span>Bookings</span>
    </a>

    <a href="content.php" class="nav-item sidebar-link">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
        <polyline points="14,2 14,8 20,8"></polyline>
        <line x1="16" y1="13" x2="8" y2="13"></line>
        <line x1="16" y1="17" x2="8" y2="17"></line>
      </svg>
      <span>Content</span>
    </a>

    <a href="reviews.php" class="nav-item sidebar-link">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
      </svg>
      <span>Reviews</span>
    </a>

    <a href="analytics.php" class="nav-item sidebar-link">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="22,12 18,12 15,21 9,3 6,12 2,12"></polyline>
      </svg>
      <span>Analytics</span>
    </a>

    <!-- User Dropdown Section -->
    <div class="user-dropdown">
      <div class="nav-item sidebar-link user-toggle" id="userToggle">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="7" r="4"></circle>
          <path d="M4 21v-1a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v1"></path>
        </svg>
        <span id="userText"><span id="userName">Loading...</span></span>
        <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
      </div>
      
      <div class="user-dropdown-content" id="userDropdown">
        <a href="currentUser.php" class="user-menu-link">
          <div class="user-info">
            <div class="manage-user">
              <svg class="manage-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
              </svg>
              <span>Manage User</span>
            </div>
          </div>
        </a>
        <div class="user-info">
          <div class="user-role">Role: <span id="userRole">Loading...</span></div>
        </div>
        <button class="logout-btn" id="logoutBtn">
          <svg class="logout-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16,17 21,12 16,7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          Logout
        </button>
      </div>
    </div>
  </nav>
</div>

<style>
.user-dropdown {
  position: relative;
  margin-top: auto;
}

.user-toggle {
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: all 0.3s ease;
}

.dropdown-arrow {
  width: 16px;
  height: 16px;
  transition: transform 0.3s ease;
  margin-left: auto;
}

.user-dropdown.open .dropdown-arrow {
  transform: rotate(180deg);
}

.user-dropdown-content {
  display: none;
  position: absolute;
  bottom: 100%;
  left: 0;
  right: 0;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  padding: 12px;
  margin-bottom: 8px;
  z-index: 1000;
}

.user-dropdown.open .user-dropdown-content {
  display: block;
}

.user-menu-link {
  text-decoration: none;
  color: inherit;
  display: block;
}

.user-menu-link:hover .manage-user {
  background: #f8fafc;
}

.manage-user {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px;
  border-radius: 6px;
  transition: background-color 0.2s ease;
  font-size: 14px;
}

.manage-icon {
  width: 16px;
  height: 16px;
}

.user-info {
  padding: 8px 0;
  border-bottom: 1px solid #f3f4f6;
  margin-bottom: 8px;
}

.user-role {
  font-size: 14px;
  color: #6b7280;
}

.logout-btn {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  background: #ef4444;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.2s ease;
}

.logout-btn:hover {
  background: #dc2626;
}

.logout-icon {
  width: 16px;
  height: 16px;
}

/* Logout Modal Styles */
#logoutModal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  animation: fadeIn 0.3s ease;
}

.logout-modal {
  background: white;
  border-radius: 12px;
  padding: 0;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  animation: slideUp 0.3s ease;
  min-width: 300px;
  max-width: 400px;
  overflow: hidden;
}

.logout-modal-content {
  padding: 2rem;
  text-align: center;
}

.logout-spinner {
  margin-bottom: 1rem;
}

.logout-spinner i {
  font-size: 2rem;
  color: #3b82f6;
}

.logout-modal h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
}

.logout-modal p {
  margin: 0;
  color: #6b7280;
  font-size: 0.875rem;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideUp {
  from { 
    opacity: 0;
    transform: translateY(20px) scale(0.95);
  }
  to { 
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.logout-error {
  background: #fef2f2;
  border: 1px solid #fecaca;
}

.logout-error .logout-spinner i {
  color: #ef4444;
}

.logout-error h3 {
  color: #dc2626;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // User dropdown functionality
  const userToggle = document.getElementById('userToggle');
  const userDropdown = document.getElementById('userDropdown');
  const userName = document.getElementById('userName');
  const userRole = document.getElementById('userRole');
  const logoutBtn = document.getElementById('logoutBtn');

  // Fetch user data from sessionStorage
  function fetchUserData() {
    const userNameData = sessionStorage.getItem('userName') || 'User Name';
    const userRoleData = sessionStorage.getItem('userRole') || 'Role';
    
    userName.textContent = userNameData;
    userRole.textContent = userRoleData;
  }

  // Toggle dropdown
  userToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    userToggle.parentElement.classList.toggle('open');
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', (e) => {
    if (!userToggle.contains(e.target) && !userDropdown.contains(e.target)) {
      userToggle.parentElement.classList.remove('open');
    }
  });

  // Enhanced Logout functionality
  logoutBtn.addEventListener('click', () => {
    showLogoutModal();
  });

  // Highlight active nav
  const navItems = document.querySelectorAll(".nav-item");
  const currentPage = window.location.pathname.split("/").pop().trim();

  if (currentPage && currentPage !== "super" && currentPage !== "super/") {
    navItems.forEach(item => {
      const href = item.getAttribute("href");
      if (href && href.includes(currentPage)) {
        item.classList.add("active");
      } else {
        item.classList.remove("active");
      }
    });
  }

  // Initialize user data
  fetchUserData();
});

// Logout Modal Functions
function showLogoutModal() {
  // Remove existing modal if any
  const existingModal = document.getElementById('logoutModal');
  if (existingModal) existingModal.remove();

  // Create modal overlay
  const modalOverlay = document.createElement('div');
  modalOverlay.id = 'logoutModal';
  modalOverlay.innerHTML = `
    <div class="logout-modal">
      <div class="logout-modal-content">
        <div class="logout-spinner">
          <i class="fas fa-spinner fa-spin"></i>
        </div>
        <h3>Logging you out</h3>
        <p>Please wait while we securely log you out...</p>
      </div>
    </div>
  `;

  document.body.appendChild(modalOverlay);
  performLogout();
}

function performLogout() {
  const userId = sessionStorage.getItem('userId');
  const sessionToken = sessionStorage.getItem('sessionToken');
  
  const logoutData = new FormData();
  if (userId) logoutData.append('userId', userId);
  if (sessionToken) logoutData.append('session_token', sessionToken);
  logoutData.append('action', 'logout');

  fetch('processing/logout', {
    method: 'POST',
    body: logoutData
  })
  .then(res => {
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.text().then(text => {
      try { return JSON.parse(text); } 
      catch { return { success: true, message: 'Logout successful' }; }
    });
  })
  .then(data => {
    if (data.success) {
      clearUserSession();
      setTimeout(() => {
        updateModalToSuccess();
        setTimeout(() => window.location.href = 'login.php', 1000);
      }, 500);
    } else {
      throw new Error(data.message || 'Logout failed');
    }
  })
  .catch(error => {
    console.error('Logout error:', error);
    updateModalToError(error.message);
    setTimeout(() => {
      clearUserSession();
      window.location.href = 'login.php';
    }, 3000);
  });
}

function updateModalToSuccess() {
  const modalContent = document.querySelector('.logout-modal-content');
  if (!modalContent) return;
  
  modalContent.innerHTML = `
    <div class="logout-spinner">
      <i class="fas fa-check" style="color: #10b981;"></i>
    </div>
    <h3>Logged out successfully</h3>
    <p>Redirecting to login page...</p>
  `;
}

function updateModalToError(errorMessage) {
  const modalContent = document.querySelector('.logout-modal-content');
  const modal = document.querySelector('.logout-modal');
  
  if (!modalContent) return;
  
  modal.classList.add('logout-error');
  modalContent.innerHTML = `
    <div class="logout-spinner">
      <i class="fas fa-exclamation-triangle"></i>
    </div>
    <h3>Failed to log you out</h3>
    <p>${errorMessage || 'Network error'}</p>
    <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #9ca3af;">
      Redirecting to login page...
    </p>
  `;
}

function clearUserSession() {
  sessionStorage.removeItem('userName');
  sessionStorage.removeItem('userRole');
  sessionStorage.removeItem('userId');
  sessionStorage.removeItem('sessionToken');
  sessionStorage.removeItem('isLoggedIn');
  document.cookie = "admin_session_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
</script>