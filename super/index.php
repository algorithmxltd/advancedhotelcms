<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mt.Everest Hotel</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="styles/addRoom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-container">
                
                <!-- Overview Section -->
                <div class="section" id="overview-section">
                    <!-- Stats Cards -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-header">
                                <h3 class="stat-title">Total Bookings</h3>
                                <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">342</div>
                                <p class="stat-description">+18% from last month</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <h3 class="stat-title">Available Rooms</h3>
                                <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 4v16"></path>
                                    <path d="M2 8h18a2 2 0 0 1 2 2v10"></path>
                                    <path d="M2 17h20"></path>
                                    <path d="M6 8v9"></path>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">45</div>
                                <p class="stat-description">Across 4 room types</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <h3 class="stat-title">Occupancy Rate</h3>
                                <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 16c0-2.5-1.5-4-4-4s-4 1.5-4 4v4h8v-4z"></path>
                                    <rect x="8" y="6" width="8" height="14"></rect>
                                    <path d="M12 2L8 6h8l-4-4z"></path>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">87%</div>
                                <p class="stat-description">+5% from last week</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <h3 class="stat-title">Monthly Revenue</h3>
                                <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">$125,600</div>
                                <p class="stat-description">+12% from last month</p>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Check-ins and Recent Activities -->
                    <div class="overview-grid">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Today's Check-ins</h3>
                                <p class="card-description">Guests arriving today</p>
                            </div>
                            <div class="card-content">
                                <div id="checkins-list" class="checkins-list">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Activities</h3>
                                <p class="card-description">Latest website updates</p>
                            </div>
                            <div class="card-content">
                                <div id="activities-list" class="activities-list">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                            <p class="card-description">Common management tasks</p>
                        </div>
                        <div class="card-content">
                            <div class="quick-actions-grid">
                                <button class="action-button primary">
                                    <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    <span>Add Booking</span>
                                </button>
                                <button class="action-button">
                                    <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M2 4v16"></path>
                                        <path d="M2 8h18a2 2 0 0 1 2 2v10"></path>
                                        <path d="M2 17h20"></path>
                                        <path d="M6 8v9"></path>
                                    </svg>
                                    <span>Manage Rooms</span>
                                </button>
                                <button class="action-button">
                                    <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14,2 14,8 20,8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                    <span>Update Content</span>
                                </button>
                                <button class="action-button">
                                    <svg class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                    </svg>
                                    <span>Website Preview</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rooms Section -->
                 <?php include 'pages/rooms.php' ?>
                <!-- Add Rooms Section -->
                <?php include 'pages/addRoom.php' ?>

                <!-- Bookings Section -->
                <?php include 'pages/bookings.php' ?>

                <!-- Content Section -->
                <?php include 'pages/content.php' ?>

                <!-- Reviews Section -->
                <div class="section hidden" id="reviews-section">
                    <div class="section-header">
                        <h2>Guest Reviews & Testimonials</h2>
                        <button class="btn-primary">
                            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Add Testimonial
                        </button>
                    </div>
                    <div id="reviews-list" class="reviews-list">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Analytics Section -->
                <div class="section hidden" id="analytics-section">
                    <h2>Website Analytics</h2>
                    <div class="card">
                        <div class="analytics-content">
                            <svg class="analytics-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="20" x2="12" y2="10"></line>
                                <line x1="18" y1="20" x2="18" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="16"></line>
                            </svg>
                            <h3>Analytics Dashboard</h3>
                            <p class="analytics-description">Track website performance and user engagement</p>
                            <div class="analytics-stats">
                                <div class="analytics-stat">
                                    <h4>Monthly Visitors</h4>
                                    <p class="analytics-value">12,453</p>
                                </div>
                                <div class="analytics-stat">
                                    <h4>Conversion Rate</h4>
                                    <p class="analytics-value">3.2%</p>
                                </div>
                                <div class="analytics-stat">
                                    <h4>Bounce Rate</h4>
                                    <p class="analytics-value">24%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>