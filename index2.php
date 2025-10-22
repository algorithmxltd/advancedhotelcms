<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mt Everest Hotel - Experience Luxury at the Peak</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>
<body>
    <!-- Navigation -->
    <?php include 'includes/navbar.php' ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-grid">
                <!-- Text Content -->
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title">
                            Experience the
                            <span class="text-blue">Peak</span> of
                            <span class="text-cyan">Luxury</span>
                        </h1>
                        <p class="hero-description">
                            Stay at Mt Everest Hotel and enjoy breathtaking mountain views, world-class amenities, and unforgettable hospitality at the roof of the world.
                        </p>
                    </div>

                    <!-- Booking Widget -->
                    <div class="booking-widget">
                        <div class="booking-grid">
                            <div class="booking-field">
                                <label>Check-in</label>
                                <div class="booking-input">
                                    <span class="calendar-icon">📅</span>
                                    <span>Select date</span>
                                </div>
                            </div>
                            <div class="booking-field">
                                <label>Check-out</label>
                                <div class="booking-input">
                                    <span class="calendar-icon">📅</span>
                                    <span>Select date</span>
                                </div>
                            </div>
                            <div class="booking-field">
                                <label>Guests</label>
                                <div class="booking-input">
                                    <span class="users-icon">👥</span>
                                    <span>2 guests</span>
                                </div>
                            </div>
                        </div>
                        <button class="search-btn">
                            <span class="search-icon">🔍</span>
                            Search Rooms
                        </button>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="hero-image">
                    <div class="image-container">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mt Everest Hotel Exterior" class="hero-img">
                        <div class="image-overlay"></div>
                    </div>
                    <!-- Floating Stats -->
                    <div class="floating-stats">
                        <div class="stats-content">
                            <div class="rating-score">4.9</div>
                            <div class="rating-stars">★★★★★</div>
                            <div class="rating-count">1,200+ reviews</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Rooms -->
now replace this data with data from the db using php. i want 2 executive rooms and 2 standard rooms only '<!-- Featured Rooms -->
    <section class="featured-rooms">
        <div class="container">
            <div class="section-header">
                <h2>Featured Rooms</h2>
                <p>Discover comfort and luxury in every room</p>
            </div>

            <div class="rooms-grid">
                <!-- Room 1 -->
                <div class="room-card">
                    <div class="room-image">
                        <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Executive Mountain Suite">
                        <div class="room-badge executive">Executive</div>
                        <div class="room-price">
                            <span class="price">$299</span>
                            <span class="period">/night</span>
                        </div>
                    </div>
                    <div class="room-content">
                        <h3>Executive Mountain Suite</h3>
                        <p>Luxurious suite with panoramic mountain views and premium amenities.</p>
                        <div class="room-amenities">
                            <span class="amenity">Mountain View</span>
                            <span class="amenity">King Bed</span>
                            <span class="amenity">Balcony</span>
                            <span class="amenity">Mini Bar</span>
                        </div>
                        <div class="room-icons">
                            <span class="icon">🏔️</span>
                            <span class="icon">📶</span>
                            <span class="icon">☕</span>
                            <span class="icon">📺</span>
                        </div>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- Room 2 -->
                <div class="room-card">
                    <div class="room-image">
                        <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Executive Valley View">
                        <div class="room-badge executive">Executive</div>
                        <div class="room-price">
                            <span class="price">$249</span>
                            <span class="period">/night</span>
                        </div>
                    </div>
                    <div class="room-content">
                        <h3>Executive Valley View</h3>
                        <p>Elegant room perfect for business travelers with stunning valley views.</p>
                        <div class="room-amenities">
                            <span class="amenity">Valley View</span>
                            <span class="amenity">Queen Bed</span>
                            <span class="amenity">Workspace</span>
                            <span class="amenity">Premium Bath</span>
                        </div>
                        <div class="room-icons">
                            <span class="icon">🛁</span>
                            <span class="icon">📶</span>
                            <span class="icon">☕</span>
                            <span class="icon">🚗</span>
                        </div>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- Room 3 -->
                <div class="room-card">
                    <div class="room-image">
                        <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Standard Garden Room">
                        <div class="room-badge standard">Standard</div>
                        <div class="room-price">
                            <span class="price">$149</span>
                            <span class="period">/night</span>
                        </div>
                    </div>
                    <div class="room-content">
                        <h3>Standard Garden Room</h3>
                        <p>Comfortable and cozy room with beautiful garden views.</p>
                        <div class="room-amenities">
                            <span class="amenity">Garden View</span>
                            <span class="amenity">Double Bed</span>
                            <span class="amenity">Ensuite Bath</span>
                            <span class="amenity">Free WiFi</span>
                        </div>
                        <div class="room-icons">
                            <span class="icon">📶</span>
                            <span class="icon">📺</span>
                            <span class="icon">☕</span>
                            <span class="icon">🛁</span>
                        </div>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- Room 4 -->
                <div class="room-card">
                    <div class="room-image">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Standard Twin Room">
                        <div class="room-badge standard">Standard</div>
                        <div class="room-price">
                            <span class="price">$129</span>
                            <span class="period">/night</span>
                        </div>
                    </div>
                    <div class="room-content">
                        <h3>Standard Twin Room</h3>
                        <p>Perfect for friends or colleagues traveling together.</p>
                        <div class="room-amenities">
                            <span class="amenity">Twin Beds</span>
                            <span class="amenity">City View</span>
                            <span class="amenity">Shared Bath</span>
                            <span class="amenity">Basic Amenities</span>
                        </div>
                        <div class="room-icons">
                            <span class="icon">📶</span>
                            <span class="icon">📺</span>
                            <span class="icon">☕</span>
                            <span class="icon">🚗</span>
                        </div>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>
            </div>

            <div class="view-all">
                <button class="view-all-btn">View All Rooms</button>
            </div>
        </div>
    </section>'



    <!-- Marketing Content -->
    <section class="marketing-content">
        <div class="container">
            <!-- Main Feature Section -->
            <div class="feature-grid">
                <div class="feature-content">
                    <div class="feature-text">
                        <div class="award-badge">
                            <span class="award-icon">🏆</span>
                            <span>Award Winning</span>
                        </div>
                        <h2>Where Luxury Meets <span class="text-blue">Adventure</span></h2>
                        <p>Experience the perfect blend of comfort and excitement at Mt Everest Hotel. Our world-class amenities and stunning location make us the premier destination for discerning travelers.</p>
                    </div>
                    
                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon">🛡️</div>
                            <div>
                                <h4>24/7 Security</h4>
                                <p>Round-the-clock security for your peace of mind</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🕒</div>
                            <div>
                                <h4>Concierge Service</h4>
                                <p>Personalized assistance for all your travel needs</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">👥</div>
                            <div>
                                <h4>Event Spaces</h4>
                                <p>Perfect venues for meetings, weddings, and celebrations</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="feature-image">
                    <div class="image-container">
                        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hotel Lobby">
                    </div>
                    <div class="luxury-badge">
                        <span class="sparkles-icon">✨</span>
                        <span>5-Star Luxury</span>
                    </div>
                </div>
            </div>

            <!-- Amenities Grid -->
            <div class="amenities-section">
                <div class="section-header">
                    <h3>Premium Amenities</h3>
                    <p>Everything you need for a perfect stay</p>
                </div>

                <div class="amenities-grid">
                    <div class="amenity-card">
                        <div class="amenity-icon">🏔️</div>
                        <h4>Mountain Views</h4>
                        <p>Breathtaking panoramic views of the Himalayas from every room</p>
                    </div>
                    <div class="amenity-card">
                        <div class="amenity-icon">🍽️</div>
                        <h4>Fine Dining</h4>
                        <p>World-class restaurants serving local and international cuisine</p>
                    </div>
                    <div class="amenity-card">
                        <div class="amenity-icon">🏋️</div>
                        <h4>Fitness Center</h4>
                        <p>State-of-the-art gym with modern equipment and personal trainers</p>
                    </div>
                    <div class="amenity-card">
                        <div class="amenity-icon">🌊</div>
                        <h4>Spa & Wellness</h4>
                        <p>Rejuvenating spa treatments with traditional healing methods</p>
                    </div>
                    <div class="amenity-card">
                        <div class="amenity-icon">📶</div>
                        <h4>Free Wi-Fi</h4>
                        <p>High-speed internet access throughout the property</p>
                    </div>
                    <div class="amenity-card">
                        <div class="amenity-icon">🚗</div>
                        <h4>Free Parking</h4>
                        <p>Complimentary valet parking and charging stations</p>
                    </div>
                </div>
            </div>

            <!-- Location Highlight -->
            <div class="location-highlight">
                <div class="location-icon">📍</div>
                <h3>Prime Location</h3>
                <p>Located in the heart of the Himalayas, Mt Everest Hotel offers unparalleled access to the world's most spectacular mountain views and outdoor adventures.</p>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section class="feedback-section">
        <div class="container">
            <div class="section-header">
                <h2>What Our Guests Say</h2>
                <p>Hear from travelers who've experienced our hospitality</p>
                
                <!-- Overall Rating -->
                <div class="overall-rating">
                    <div class="rating-stars">★★★★★</div>
                    <div class="rating-score">4.9</div>
                    <div class="rating-text">Based on 1,200+ reviews</div>
                </div>
            </div>

            <div class="testimonials-grid">
                <!-- Testimonial 1 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <span class="quote-icon">❝</span>
                        <div class="testimonial-rating">★★★★★</div>
                    </div>
                    <p>An absolutely breathtaking experience! The views from our room were incredible and the service was impeccable. Mt Everest Hotel exceeded all our expectations.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">SJ</div>
                        <div class="author-info">
                            <div class="author-name">Sarah Johnson</div>
                            <div class="author-location">New York, USA</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <span class="quote-icon">❝</span>
                        <div class="testimonial-rating">★★★★★</div>
                    </div>
                    <p>The perfect blend of luxury and adventure. The staff went above and beyond to make our stay memorable. The mountain views are simply unforgettable.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">DC</div>
                        <div class="author-info">
                            <div class="author-name">David Chen</div>
                            <div class="author-location">Singapore</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <span class="quote-icon">❝</span>
                        <div class="testimonial-rating">★★★★★</div>
                    </div>
                    <p>Outstanding hospitality and world-class amenities. The spa was divine and the dining options were exceptional. Can't wait to return!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">ET</div>
                        <div class="author-info">
                            <div class="author-name">Emma Thompson</div>
                            <div class="author-location">London, UK</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <span class="quote-icon">❝</span>
                        <div class="testimonial-rating">★★★★★</div>
                    </div>
                    <p>A once-in-a-lifetime experience. The hotel's location is unmatched and the room was perfectly appointed. Highly recommend for anyone seeking luxury in nature.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">MR</div>
                        <div class="author-info">
                            <div class="author-name">Michael Rodriguez</div>
                            <div class="author-location">Barcelona, Spain</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 5 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <span class="quote-icon">❝</span>
                        <div class="testimonial-rating">★★★★★</div>
                    </div>
                    <p>Exceptional service and stunning views. The cultural experiences offered were authentic and enriching. Mt Everest Hotel is truly special.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">YT</div>
                        <div class="author-info">
                            <div class="author-name">Yuki Tanaka</div>
                            <div class="author-location">Tokyo, Japan</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 6 -->
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <span class="quote-icon">❝</span>
                        <div class="testimonial-rating">★★★★★</div>
                    </div>
                    <p>The attention to detail is remarkable. Every aspect of our stay was carefully curated. The mountain hiking excursions were perfectly organized.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">LM</div>
                        <div class="author-info">
                            <div class="author-name">Lucas Müller</div>
                            <div class="author-location">Berlin, Germany</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="cta-section">
                <div class="cta-card">
                    <h3>Ready to Create Your Own Story?</h3>
                    <p>Join thousands of satisfied guests who've experienced the magic of Mt Everest Hotel</p>
                    <div class="stats-row">
                        <div class="stat-item">
                            <div class="stat-number">1,200+</div>
                            <div class="stat-label">Happy Guests</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-number">98%</div>
                            <div class="stat-label">Satisfaction Rate</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Guest Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Maps Section -->
    <section class="maps-section">
        <div class="container">
            <div class="section-header">
                <h2>Find Us</h2>
                <p>Located in the heart of the Himalayas</p>
            </div>

            <div class="maps-grid">
                <!-- Map -->
                <div class="map-container">
                    <div class="mock-map">
                        <div class="map-content">
                            <div class="map-pin">📍</div>
                            <h3>Mt Everest Hotel</h3>
                            <p>Interactive map loading...</p>
                            <div class="map-info">
                                <p>
                                    Everest Base Camp Region<br>
                                    Solukhumbu District, Nepal<br>
                                    Altitude: 3,440m (11,286 ft)
                                </p>
                            </div>
                        </div>
                        
                        <!-- Map Controls -->
                        <div class="map-controls">
                            <button class="map-control">+</button>
                            <button class="map-control">-</button>
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="location-info">
                    <div class="info-card address-card">
                        <h3>
                            <span class="pin-icon">📍</span>
                            Address
                        </h3>
                        <p>
                            Mt Everest Hotel<br>
                            Everest Base Camp Region<br>
                            Solukhumbu District<br>
                            Province No. 1, Nepal<br>
                            Postal Code: 56000
                        </p>
                    </div>

                    <div class="info-card contact-card">
                        <h3>
                            <span class="phone-icon">📞</span>
                            Contact
                        </h3>
                        <div class="contact-info">
                            <p>Phone: +977-1-234-5678</p>
                            <p>Email: info@mteveresthotel.com</p>
                            <p>WhatsApp: +977-98-765-4321</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transportation Options -->
            <div class="transportation-section">
                <h3>How to Reach Us</h3>
                <div class="transport-grid">
                    <div class="transport-card">
                        <div class="transport-icon air">✈️</div>
                        <h4>By Air</h4>
                        <p>Fly to Tribhuvan International Airport (KTM) in Kathmandu, then take a domestic flight to Lukla Airport (LUA).</p>
                        <div class="transport-time">
                            <span class="clock-icon">🕒</span>
                            45 min flight to Lukla
                        </div>
                    </div>

                    <div class="transport-card">
                        <div class="transport-icon trekking">🏔️</div>
                        <h4>Trekking</h4>
                        <p>Embark on a scenic trek from Lukla to our hotel. Professional guides and porters available.</p>
                        <div class="transport-time">
                            <span class="clock-icon">🕒</span>
                            2-3 days trek
                        </div>
                    </div>

                    <div class="transport-card">
                        <div class="transport-icon helicopter">🚁</div>
                        <h4>Helicopter</h4>
                        <p>Luxury helicopter transfers available from Kathmandu directly to our hotel helipad.</p>
                        <div class="transport-time">
                            <span class="clock-icon">🕒</span>
                            1.5 hour flight
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <!-- Feedback Form Section -->
        <div class="feedback-form-section">
            <div class="container">
                <div class="feedback-grid">
                    <div class="feedback-content">
                        <div class="feedback-text">
                            <h2>Share Your Experience</h2>
                            <p>Your feedback helps us create unforgettable experiences for all our guests. Let us know how we can serve you better.</p>
                        </div>
                        
                        <div class="feedback-rating">
                            <div class="rating-stars">★★★★★</div>
                            <span>4.9 out of 5 stars</span>
                        </div>
                    </div>

                    <div class="feedback-form-card">
                        <h3>Send Us Your Feedback</h3>
                        <form class="feedback-form">
                            <div class="form-row">
                                <div class="form-field">
                                    <label>Name</label>
                                    <input type="text" placeholder="Your name">
                                </div>
                                <div class="form-field">
                                    <label>Email</label>
                                    <input type="email" placeholder="your@email.com">
                                </div>
                            </div>
                            
                            <div class="form-field">
                                <label>Rating</label>
                                <div class="rating-input">
                                    <span class="star" data-rating="1">☆</span>
                                    <span class="star" data-rating="2">☆</span>
                                    <span class="star" data-rating="3">☆</span>
                                    <span class="star" data-rating="4">☆</span>
                                    <span class="star" data-rating="5">☆</span>
                                </div>
                            </div>
                            
                            <div class="form-field">
                                <label>Your Feedback</label>
                                <textarea placeholder="Tell us about your experience..." rows="4"></textarea>
                            </div>
                            
                            <button type="submit" class="submit-btn">
                                <span class="send-icon">📤</span>
                                Submit Feedback
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <div class="main-footer">
            <div class="container">
                <div class="footer-grid">
                    <!-- Hotel Info -->
                    <div class="footer-section">
                        <div class="footer-logo">
                            <span class="mountain-icon">🏔️</span>
                            <h3>Mt Everest Hotel</h3>
                        </div>
                        <p>Experience luxury and adventure at the roof of the world. Where every stay is an unforgettable journey.</p>
                        <div class="social-links">
                            <a href="#" class="social-link facebook">📘</a>
                            <a href="#" class="social-link instagram">📷</a>
                            <a href="#" class="social-link twitter">🐦</a>
                            <a href="#" class="social-link youtube">📺</a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-section">
                        <h4>Quick Links</h4>
                        <div class="footer-links">
                            <a href="#">Executive Rooms</a>
                            <a href="#">Standard Rooms</a>
                            <a href="#">Amenities</a>
                            <a href="#">Dining</a>
                            <a href="#">Spa & Wellness</a>
                            <a href="#">Activities</a>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="footer-section">
                        <h4>Services</h4>
                        <div class="footer-links">
                            <a href="#">Room Service</a>
                            <a href="#">Concierge</a>
                            <a href="#">Airport Transfer</a>
                            <a href="#">Tour Packages</a>
                            <a href="#">Equipment Rental</a>
                            <a href="#">Medical Assistance</a>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="footer-section">
                        <h4>Contact Us</h4>
                        <div class="contact-info">
                            <div class="contact-item">
                                <span class="contact-icon">📍</span>
                                <div>
                                    <p>Everest Base Camp Region</p>
                                    <p>Solukhumbu District, Nepal</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <span class="contact-icon">📞</span>
                                <span>+977-1-234-5678</span>
                            </div>
                            <div class="contact-item">
                                <span class="contact-icon">✉️</span>
                                <span>info@mteveresthotel.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div class="container">
                <div class="bottom-content">
                    <p>&copy; 2025 Mt Everest Hotel. All rights reserved.</p>
                    <div class="legal-links">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                        <a href="#">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>