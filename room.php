<?php
include './includes/db_connect.php';

$roomId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch room details
$roomQuery = "SELECT * FROM rooms WHERE id = $roomId";
$roomResult = mysqli_query($conn, $roomQuery);
$room = mysqli_fetch_assoc($roomResult);

// Fetch images
$imageQuery = "SELECT * FROM roomImages WHERE roomId = $roomId";
$imageResult = mysqli_query($conn, $imageQuery);
$images = [];
while ($img = mysqli_fetch_assoc($imageResult)) {
    $images[] = $img['imagePath'];
}

// Amenities split into array
$amenities = [];
if (!empty($room['roomAmenities'])) {
    $amenities = array_map('trim', explode(',', $room['roomAmenities']));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mt Everest Hotel - Room <?php echo htmlspecialchars($room['roomNumber']); ?></title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/room2.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>
    <!-- Navigation -->
    <?php include 'includes/navbar.php' ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="booking-layout">
                <!-- Left Column - Room Details -->
                <div class="room-details">
                    <div class="breadcrumb">
                        <a href="rooms.php" class="breadcrumb-link">Rooms</a>
                        <span class="breadcrumb-separator">/</span>
                        <span>Room <?php echo htmlspecialchars($room['roomNumber']); ?></span>
                    </div>

                    <h1 class="room-title">Mt Everest Hotel</h1>
                    <div class="room-subtitle">
                        <span class="rating">
                            <span class="star">★</span>
                            <span class="rating-number">4.9</span>
                        </span>
                        <span class="separator">·</span>
                        <span class="reviews">127 reviews</span>
                        <span class="separator">·</span>
                        <span class="location">Kisii Town</span>
                    </div>

                    <!-- Room Images -->
                    <div class="room-images">
                        <?php if (!empty($images)) : ?>
                            <div class="main-image">
                                <img src="http://localhost/mteverest2/<?php echo htmlspecialchars($images[0]); ?>" alt="Room Image" />
                            </div>
                            <div class="image-grid">
                                <?php for ($i = 1; $i < min(5, count($images)); $i++): ?>
                                    <img src="http://localhost/mteverest2/<?php echo htmlspecialchars($images[$i]); ?>" alt="Room Image <?php echo $i; ?>" />
                                <?php endfor; ?>
                                <div class="show-all-photos-overlay">
                                    <button class="show-all-photos-btn" id="show-all-photos">
                                        <i data-lucide="images"></i>
                                        Show all photos
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Room Info -->
                    <div class="room-info">
                        <div class="room-type">
                            <h2><?php echo htmlspecialchars($room['roomType']); ?></h2>
                            <p class="room-specs"><?php echo htmlspecialchars($room['roomBriefDescription']); ?></p>
                        </div>

                        <div class="amenities">
                            <h3>What this place offers</h3>
                            <div class="amenities-grid">
                                <?php foreach ($amenities as $amenity): ?>
                                    <div class="amenity-item">
                                        <i data-lucide="check-circle"></i>
                                        <span><?php echo htmlspecialchars($amenity); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="additional-description">
                            <h3>More about this room</h3>
                            <p><?php echo nl2br(htmlspecialchars($room['additionalDescription'])); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Booking Card -->
                <!-- Right Column - Booking Card -->
<div class="booking-sidebar">
    <div class="booking-card">
        <div class="pricing-header">
            <div class="price">
                <span class="price-amount">Ksh <?= number_format((float)$room['roomPrice'], 0, '.', ','); ?></span>
                <span class="price-period">/night</span>
            </div>
            <div class="rating-small">
                <span class="star">★</span>
                <span>4.9</span>
                <span class="reviews-count">(127)</span>
            </div>
        </div>

        <form id="booking-form" class="booking-form">
            <div class="date-guests-grid">
                <!-- Dates -->
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

                <!-- Guests -->
                <div class="input-wrapper">
                    <label>GUESTS</label>
                    <div class="guests-selector" id="guests-selector">
                        <span id="guests-display">1 guest</span>
                        <i data-lucide="chevron-down" class="dropdown-icon"></i>
                    </div>
                    <div class="guests-dropdown" id="guests-dropdown">
                        <!-- Adults -->
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

                        <!-- Children -->
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

            <!-- Reserve -->
            <button type="submit" class="reserve-btn" id="reserve-btn">
                Reserve
            </button>

            <p class="no-charge-text">You won't be charged yet</p>

            <!-- Price breakdown -->
            <div class="price-breakdown" id="price-breakdown" style="display: none;">
                <div class="price-row">
                    <span id="nights-text">Ksh <?= number_format((float)$room['roomPrice'], 0, '.', ','); ?> x 1 night</span>
                    <span id="subtotal">Ksh <?= number_format((float)$room['roomPrice'], 0, '.', ','); ?></span>
                </div>
                <div class="price-row">
                    <span>Cleaning fee</span>
                    <span>Ksh 1,000</span>
                </div>
                <div class="price-row">
                    <span>Service fee</span>
                    <span>Ksh 800</span>
                </div>
                <div class="price-divider"></div>
                <div class="price-row total">
                    <span>Total</span>
                    <span id="total-amount">Ksh <?= number_format((float)$room['roomPrice'] + 1800, 0, '.', ','); ?></span>
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
                <h3>Room <?php echo htmlspecialchars($room['roomNumber']); ?> Photos</h3>
                <button class="close-modal-btn" id="close-modal">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="photo-grid">
                    <?php foreach ($images as $index => $imgPath): ?>
                        <div class="photo-item">
                            <img src="http://localhost/mteverest2/<?php echo htmlspecialchars($imgPath); ?>" alt="Room Photo <?php echo $index+1; ?>" />
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php' ?>
    <script src="js/room.js"></script>
    <script>lucide.createIcons();</script>
</body>
</html>
