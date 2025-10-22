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
  </nav>
</div>

<!-- Highlight Active Nav -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const navItems = document.querySelectorAll(".nav-item");
    const currentPage = window.location.pathname.split("/").pop().trim();

    // If URL ends with just `/super/` or no page file, don't activate any link
    if (currentPage === "" || currentPage === "super" || currentPage === "super/") {
      return;
    }

    navItems.forEach(item => {
      const href = item.getAttribute("href");
      if (href && href.includes(currentPage)) {
        item.classList.add("active");
      } else {
        item.classList.remove("active");
      }
    });
  });
</script>

