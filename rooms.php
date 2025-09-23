<?php
require_once 'includes/db_connect.php';

// Get filter from URL if exists
$defaultType = isset($_GET['type']) ? $_GET['type'] : '';

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
                <button class="book-btn">Book Now</button>
            </div>
        </a>
    </div>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rooms</title>
  <link rel="stylesheet" href="styles/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://kit.fontawesome.com/e4c074505f.js" crossorigin="anonymous"></script>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <section class="all-rooms">
    <div class="container">
      <div class="section-header rooms-section-header">
        <h2>All Rooms</h2>
        <p>Browse and filter through our available rooms</p>
      </div>

      <!-- Filter -->
      <div class="form-group">
        <div class="filter-container">
  <label for="roomType" class="filter-label">Filter by Room Type</label>
  <select id="roomType" name="roomType" class="filter-select">
    <option value="" <?= $defaultType === '' ? 'selected' : '' ?>>All</option>
    <option value="Executive" <?= $defaultType === 'Executive' ? 'selected' : '' ?>>Executive</option>
    <option value="Standard" <?= $defaultType === 'Standard' ? 'selected' : '' ?>>Standard</option>
  </select>
</div>

      </div>

      <div class="rooms-grid" id="roomsGrid">
        <?php 
        while ($row = mysqli_fetch_assoc($result)) {
            echo renderRoomCard($row);
        }
        ?>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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

      // Filtering
      const filterSelect = document.getElementById('roomType');
      const roomCards = document.querySelectorAll('.room-card');

      function applyFilter() {
          const filterValue = filterSelect.value;
          roomCards.forEach(card => {
              if (!filterValue || card.getAttribute('data-type') === filterValue) {
                  card.style.display = 'block';
              } else {
                  card.style.display = 'none';
              }
          });
      }

      // Run on load (apply default filter from PHP)
      applyFilter();

      // Run when filter changes
      filterSelect.addEventListener('change', applyFilter);
  });
  </script>
  <?php include 'includes/footer.php' ?>
</body>
</html>
