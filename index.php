<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mt Everest Hotel</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://kit.fontawesome.com/e4c074505f.js" crossorigin="anonymous"></script>

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
<?php
require_once 'includes/db_connect.php';
define("BASE_URL", "/mteverest2");

// Fetch 2 executive rooms
$execQuery = "SELECT * FROM rooms WHERE roomType = 'Executive' LIMIT 2";
$execResult = mysqli_query($conn, $execQuery);

// Fetch 2 standard rooms
$stdQuery = "SELECT * FROM rooms WHERE roomType = 'Standard' LIMIT 2";
$stdResult = mysqli_query($conn, $stdQuery);

function renderRoomCard($room)
{
    global $conn;

    // Get up to 4 images for this room
    $roomId = intval($room['id']);
    $imgQuery = "SELECT imagePath FROM roomImages WHERE roomId = $roomId LIMIT 4";
    $imgResult = mysqli_query($conn, $imgQuery);

    $slides = '';
    if ($imgResult && mysqli_num_rows($imgResult) > 0) {
        while ($img = mysqli_fetch_assoc($imgResult)) {
            $slides .= '
                <div class="swiper-slide">
                    <img src="' . BASE_URL . htmlspecialchars($img['imagePath']) . '" alt="Room Image">
                </div>';
        }
    } else {
        // Fallback default image
        $slides = '
            <div class="swiper-slide">
                <img src="assets/default-room.jpg" alt="Default Room">
            </div>';
    }

    return '

    <div class="room-card">
    <a href="room.php?id=' . urlencode($room['id']) . '" class="room-link">
        <div class="room-image">
            <!-- Swiper -->
            <div class="swiper room-swiper">
                <div class="swiper-wrapper">
                    ' . $slides . '
                </div>
                <!-- Swiper navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="room-badge ' . strtolower(htmlspecialchars($room['roomType'])) . '">'
                . htmlspecialchars($room['roomType']) . '
            </div>
            <i class="fa-regular fa-heart"></i>
        </div>
        <div class="room-content">
            <div class="room-price">
                <span class="price">Ksh ' . number_format((float)$room['roomPrice'], 0, '.', ',') . '</span>
                <span class="period">/night</span>
            </div>
            <p>' . htmlspecialchars($room['roomBriefDescription']) . '</p>
            <div class="room-amenities">' . htmlspecialchars($room['roomAmenities']) . '</div>
            <div class="room-icons">' . htmlspecialchars($room['amenitiesEmojies']) . '</div>
            <button class="book-btn">Book Now</button>
        </div>
        </a>
    </div>';

}
?>

<!-- Featured Rooms -->
<section class="featured-rooms">
    <div class="container">
        <div class="section-header">
            <h2>Featured Rooms</h2>
            <p>Discover comfort and luxury in every room</p>
        </div>

        <div class="rooms-grid">
            <?php 
            if ($execResult) {
                while ($row = mysqli_fetch_assoc($execResult)) {
                    echo renderRoomCard($row);
                }
            }
            if ($stdResult) {
                while ($row = mysqli_fetch_assoc($stdResult)) {
                    echo renderRoomCard($row);
                }
            }
            ?>
        </div>

        <div class="view-all">
            <a href="rooms.php"><button class="view-all-btn">View All Rooms</button></a>
        </div>
    </div>
</section>

<!-- Swiper JS (make sure to include Swiper library in your page) -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const swipers = document.querySelectorAll('.room-swiper');
    swipers.forEach(swiperEl => {
        new Swiper(swiperEl, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: swiperEl.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: swiperEl.querySelector('.swiper-button-next'),
                prevEl: swiperEl.querySelector('.swiper-button-prev'),
            },
        });
    });
});
</script>



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

    
<?php include 'includes/footer.php' ?>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>