<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details - Mt. Everest Hotel</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles/room.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-container" id="content-container">
                <div class="page-container">

                    <?php
                    // Include DB connection
                    $dbFile = __DIR__ . '/includes/db_connect.php';
                    if (file_exists($dbFile)) {
                        require_once $dbFile;
                    } else {
                        echo "<p style='color:red;text-align:center;'>Database connection file not found.</p>";
                        exit;
                    }

                    $conn->set_charset("utf8mb4");

                    // Get room ID from query parameter
                    $roomId = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    // Fetch room details
                    $sql = "SELECT id, roomPrice, roomNumber, roomType, roomBriefDescription, roomAmenities, amenitiesEmojies, additionalDescription 
                            FROM rooms WHERE id = $roomId LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $room = $result->fetch_assoc();
                    } else {
                        echo "<p style='text-align:center;'>Room not found.</p>";
                        $conn->close();
                        exit;
                    }

                    // Hardcoded room status
                    $roomStatus = ($room['id'] % 2 === 0) ? "Available" : "Occupied"; 
                    $statusClass = strtolower($roomStatus);

                    // Process amenities (comma-separated)
                    $amenitiesList = !empty($room['roomAmenities']) ? explode(',', $room['roomAmenities']) : [];
                    $emojis = !empty($room['amenitiesEmojies']) ? explode(',', $room['amenitiesEmojies']) : [];
                    ?>

                    <!-- Header -->
                    <header class="page-header">
                        <div class="header-info">
                            <div class="room-title">
                                <h1 id="roomNumber">Room <?= htmlspecialchars($room['roomNumber']); ?></h1>
                                <div class="room-meta">
                                    <span class="room-type-badge"><?= htmlspecialchars($room['roomType']); ?></span>
                                    <span class="status-badge status-<?= $statusClass; ?>"><?= htmlspecialchars($roomStatus); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="header-actions">
                            <button class="btn btn-secondary" onclick="window.location.href='rooms.php'">← Back</button>
                            <a href='editRoom.php?id=<?= htmlspecialchars($room['id']); ?>'><button class="btn btn-primary">Edit</button></a>
                            
                        </div>
                    </header>

                    <!-- Main Info Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Room Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="details-grid">
                                <div class="detail-item">
                                    <span class="detail-label">Room Number</span>
                                    <span class="detail-value"><?= htmlspecialchars($room['roomNumber']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Room Type</span>
                                    <span class="detail-value"><?= htmlspecialchars($room['roomType']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Price per Night</span>
                                    <span class="detail-value">Ksh <?= number_format($room['roomPrice'], 2); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Status</span>
                                    <span class="detail-value"><?= htmlspecialchars($roomStatus); ?></span>
                                </div>
                            </div>

                            <?php if (!empty($room['roomBriefDescription'])): ?>
                                <div class="room-desc">
                                    <h3>Brief Description</h3>
                                    <p><?= nl2br(htmlspecialchars($room['roomBriefDescription'])); ?></p>
                                </div>
                            <?php endif; ?>

                
                        </div>
                    </div>

                    <!-- Occupancy Section -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Current Occupancy</h2>
                        </div>
                        <div class="card-body">
                            <?php if ($roomStatus === "Occupied"): ?>
                                <p><strong>Client:</strong> John Doe</p>
                                <p><strong>Check-in:</strong> 2025-10-10</p>
                                <p><strong>Check-out:</strong> 2025-10-15</p>
                            <?php else: ?>
                                <p style="color: var(--muted-foreground);">This room is currently available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php $conn->close(); ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
