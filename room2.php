<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Stay - Mt Everest Hotel</title>
    <link rel="stylesheet" href="styles/globals.css">
    <link rel="stylesheet" href="styles/room2.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-content">
                <div class="nav-logo">
                    <h1>Mt Everest Hotel</h1>
                </div>
                <div class="nav-links">
                    <a href="#" class="nav-link">Rooms</a>
                    <a href="#" class="nav-link">
                        <i data-lucide="heart"></i>
                        Favourites
                    </a>
                    <a href="#" class="nav-link">About Us</a>
                    <a href="#" class="nav-link">Contacts</a>
                </div>
                <div class="nav-auth">
                    <button class="login-btn">
                        <i data-lucide="user"></i>
                        Login
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="booking-layout">
                <!-- Left Column - Room Details -->
                <div class="room-details">
                    <div class="breadcrumb">
                        <a href="#" class="breadcrumb-link">Rooms</a>
                        <span class="breadcrumb-separator">/</span>
                        <span>Executive Mountain Suite</span>
                    </div>

                    <h1 class="room-title">Executive Mountain Suite</h1>
                    <div class="room-subtitle">
                        <span class="rating">
                            <span class="star">★</span>
                            <span class="rating-number">4.9</span>
                        </span>
                        <span class="separator">·</span>
                        <span class="reviews">127 reviews</span>
                        <span class="separator">·</span>
                        <span class="location">Namche Bazaar, Nepal</span>
                    </div>

                    <!-- Room Images -->
                    <div class="room-images">
                        <div class="main-image">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Executive Mountain Suite" />
                        </div>
                        <div class="image-grid">
                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Room view 2" />
                            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Room view 3" />
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Room view 4" />
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Room view 5" />
                            <div class="show-all-photos-overlay">
                                <button class="show-all-photos-btn" id="show-all-photos">
                                    <i data-lucide="images"></i>
                                    Show all photos
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Room Info -->
                    <div class="room-info">
                        <div class="room-type">
                            <h2>Entire suite hosted by Mt Everest Hotel</h2>
                            <p class="room-specs">2 guests · 1 bedroom · 1 bed · 1 bathroom</p>
                        </div>

                        <div class="amenities">
                            <h3>What this place offers</h3>
                            <div class="amenities-grid">
                                <div class="amenity-item">
                                    <i data-lucide="mountain"></i>
                                    <span>Mountain view</span>
                                </div>
                                <div class="amenity-item">
                                    <i data-lucide="wifi"></i>
                                    <span>Free WiFi</span>
                                </div>
                                <div class="amenity-item">
                                    <i data-lucide="coffee"></i>
                                    <span>Coffee maker</span>
                                </div>
                                <div class="amenity-item">
                                    <i data-lucide="tv"></i>
                                    <span>TV with streaming</span>
                                </div>
                                <div class="amenity-item">
                                    <i data-lucide="bath"></i>
                                    <span>Premium bathroom</span>
                                </div>
                                <div class="amenity-item">
                                    <i data-lucide="car"></i>
                                    <span>Free parking</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Booking Card -->
                <div class="booking-sidebar">
                    <div class="booking-card">
                        <div class="pricing-header">
                            <div class="price">
                                <span class="price-amount">$299</span>
                                <span class="price-period">night</span>
                            </div>
                            <div class="rating-small">
                                <span class="star">★</span>
                                <span>4.9</span>
                                <span class="reviews-count">(127)</span>
                            </div>
                        </div>

                        <form id="booking-form" class="booking-form">
                            <div class="date-guests-grid">
                                <div class="date-input-group">
                                    <div class="input-wrapper half-width">
                                        <label>CHECK-IN</label>
                                        <input type="date" id="checkin" name="checkin" required>
                                    </div>
                                    <div class="input-wrapper half-width">
                                        <label>CHECK-OUT</label>
                                        <input type="date" id="checkout" name="checkout" required>
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <label>GUESTS</label>
                                    <div class="guests-selector" id="guests-selector">
                                        <span id="guests-display">1 guest</span>
                                        <i data-lucide="chevron-down" class="dropdown-icon"></i>
                                    </div>
                                    <div class="guests-dropdown" id="guests-dropdown">
                                        <div class="guest-type">
                                            <div class="guest-info">
                                                <span class="guest-label">Adults</span>
                                                <span class="guest-sublabel">Age 13+</span>
                                            </div>
                                            <div class="counter">
                                                <button type="button" class="counter-btn" data-action="decrease" data-type="adults">−</button>
                                                <span class="count" id="adults-count">1</span>
                                                <button type="button" class="counter-btn" data-action="increase" data-type="adults">+</button>
                                            </div>
                                        </div>
                                        <div class="guest-type">
                                            <div class="guest-info">
                                                <span class="guest-label">Children</span>
                                                <span class="guest-sublabel">Ages 2-12</span>
                                            </div>
                                            <div class="counter">
                                                <button type="button" class="counter-btn" data-action="decrease" data-type="children">−</button>
                                                <span class="count" id="children-count">0</span>
                                                <button type="button" class="counter-btn" data-action="increase" data-type="children">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="reserve-btn" id="reserve-btn">
                                Reserve
                            </button>

                            <p class="no-charge-text">You won't be charged yet</p>

                            <div class="price-breakdown" id="price-breakdown" style="display: none;">
                                <div class="price-row">
                                    <span id="nights-text">$299 x 1 night</span>
                                    <span id="subtotal">$299</span>
                                </div>
                                <div class="price-row">
                                    <span>Cleaning fee</span>
                                    <span>$50</span>
                                </div>
                                <div class="price-row">
                                    <span>Service fee</span>
                                    <span>$42</span>
                                </div>
                                <div class="price-divider"></div>
                                <div class="price-row total">
                                    <span>Total</span>
                                    <span id="total-amount">$391</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Photo Gallery Modal -->
    <div class="photo-gallery-modal" id="photo-gallery-modal">
        <div class="modal-overlay" id="modal-overlay"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3>Executive Mountain Suite Photos</h3>
                <button class="close-modal-btn" id="close-modal">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="photo-grid">
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Mountain Suite Main View" />
                        <div class="photo-caption">Mountain Suite Main View</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bedroom Overview" />
                        <div class="photo-caption">Bedroom Overview</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Living Area" />
                        <div class="photo-caption">Living Area</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bathroom" />
                        <div class="photo-caption">Bathroom</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Hotel Exterior" />
                        <div class="photo-caption">Hotel Exterior</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Mountain View from Room" />
                        <div class="photo-caption">Mountain View from Room</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1578645510447-e20b4311e3ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Balcony View" />
                        <div class="photo-caption">Balcony View</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Workspace Area" />
                        <div class="photo-caption">Workspace Area</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1595576508898-0ad5c879a061?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Hotel Lobby" />
                        <div class="photo-caption">Hotel Lobby</div>
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Dining Area" />
                        <div class="photo-caption">Dining Area</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/room2.js"></script>
</body>
</html>