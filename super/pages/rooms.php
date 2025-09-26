<?php
require_once 'includes/db_connect.php';

$query = "SELECT * FROM rooms";
$result = mysqli_query($conn, $query);

function renderRoomCard($room) {
    global $conn;
    $imgQuery = "SELECT imagePath FROM roomImages WHERE roomId = " . intval($room['id']) . " LIMIT 4";
    $imgResult = mysqli_query($conn, $imgQuery);

    $slides = '';
    if ($imgResult && mysqli_num_rows($imgResult) > 0) {
        while ($img = mysqli_fetch_assoc($imgResult)) {
            $slides .= '<div class="swiper-slide">
                <img src="http://localhost/mteverest2' . htmlspecialchars($img['imagePath']) . '" alt="Room Image">
            </div>';
        }
    } else {
        $slides = '<div class="swiper-slide">
            <img src="assets/default-room.jpg" alt="Default Room">
        </div>';
    }

    return '
    <div class="room-card" data-type="' . htmlspecialchars($room['roomType']) . '">
        <a href="room.php?id=' . urlencode($room['id']) . '" class="room-link">
            <div class="room-image">
                <div class="swiper room-swiper">
                    <div class="swiper-wrapper">' . $slides . '</div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="room-badge ' . strtolower(htmlspecialchars($room['roomType'])) . '">' . htmlspecialchars($room['roomType']) . '</div>
                <div><i class="fa-regular fa-heart"></i></div>
            </div>
            <div class="room-content">
                <div class="room-price">
                    <span class="price">Ksh ' . number_format((float)$room['roomPrice'], 0, '.', ',') . '</span>
                    <span class="period">/night</span>
                </div>
                <p>' . htmlspecialchars($room['roomBriefDescription']) . '</p>
                <div class="room-amenities">' . $room['roomAmenities'] . '</div>
                <div class="room-icons">' . $room['amenitiesEmojies'] . '</div>
                <button class="book-btn">Manage Room</button>
            </div>
        </a>
    </div>';
}
?>

<!-- Rooms Section -->
<div class="section hidden" id="rooms-section">
  <div class="section-header">
    <h2>Room Management</h2>
    <button class="nav-item" data-section="addRoom">
      <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      Add Room Type
    </button>
  </div>

  <div id="rooms-grid" class="rooms-grid">
    <?php 
    while ($row = mysqli_fetch_assoc($result)) {
        echo renderRoomCard($row);
    }
    ?>
  </div>
</div>

<!-- Swiper JS -->



<script>
document.addEventListener("DOMContentLoaded", function () {
    // Init Swipers
    document.querySelectorAll('.room-swiper').forEach(swiperEl => {
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
