<?php
include 'includes/db_connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
  die('Room ID not provided.');
}

$roomId = intval($_GET['id']);

// Fetch room details
$roomQuery = mysqli_query($conn, "SELECT * FROM rooms WHERE id = $roomId");
if (mysqli_num_rows($roomQuery) == 0) {
  die('Room not found.');
}
$room = mysqli_fetch_assoc($roomQuery);

// Fetch room images
$imageQuery = mysqli_query($conn, "SELECT * FROM roomImages WHERE roomId = $roomId");
$roomImages = [];
while ($img = mysqli_fetch_assoc($imageQuery)) {
  $roomImages[] = $img['imagePath'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Room <?php echo $room['roomNumber']; ?></title>
   <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="../styles/styles.css"> 
  <link rel="stylesheet" href="styles/addRoom.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="app-container">
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
      <div class="content-container" id="content-container">
        <div class="section-header">
          <h2>Edit Room <?php echo $room['roomNumber']; ?> </h2>
        </div>
        <!-- Response Box -->
                <div id="responseBox" class="response-container" style="display:none;">
                    <p id="responseMessage"></p>
                    <button id="closeResponseBtn" class="response-close">Close</button>
                </div>

        <form id="editRoomForm" enctype="multipart/form-data">
          <input type="hidden" name="roomId" value="<?php echo $roomId; ?>">

          <!-- Room Photos -->
          <div class="form-group">
            <label>Current Room Photos</label>
            <div class="preview-container" id="previewContainer">
              <?php foreach ($roomImages as $image): ?>
                <div class="image-item">
                  <img src="../<?php echo htmlspecialchars($image); ?>" alt="Room Image">
                  <button type="button" class="delete-image" id='delete-image-btn' data-path="<?php echo htmlspecialchars($image); ?>">
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
              <?php endforeach; ?>
            </div>
            <label>Upload New Photos</label>
            <div class="upload-area" id="dropZone">
              <i class="fas fa-cloud-upload-alt"></i>
              <p>Drag & drop new photos or select below</p>
              <input type="file" id="roomPhotos" name="roomPhotos[]" accept="image/*" multiple hidden>
              <button type="button" class="btn-primary" id="browseBtn">Select Photo</button>
            </div>
          </div>

          <!-- Room Details -->
          <div class="form-group">
            <label>Room Price / Night</label>
            <input id="roomPrice" name="roomPrice" type="number" value="<?php echo $room['roomPrice']; ?>" required>
          </div>

          <div class="form-group">
            <label>Room Number</label>
            <input id="roomNumber" name="roomNumber" type="text" value="<?php echo $room['roomNumber']; ?>" required>
          </div>

          <div class="form-group">
            <label>Room Type</label>
            <select id="roomType" name="roomType" required>
              <option value="Executive" <?php echo ($room['roomType'] == 'Executive') ? 'selected' : ''; ?>>Executive</option>
              <option value="Standard" <?php echo ($room['roomType'] == 'Standard') ? 'selected' : ''; ?>>Standard</option>
            </select>
          </div>

          <div class="form-group">
            <label>Brief Description</label>
            <input id="roomBriefDescription" name="roomBriefDescription" type="text" value="<?php echo htmlspecialchars($room['roomBriefDescription']); ?>">
          </div>

          <div class="form-group">
            <label>Room Amenities</label>
            <input id="roomAmenities" name="roomAmenities" type="text" value="<?php echo htmlspecialchars($room['roomAmenities']); ?>">
          </div>

          <div class="form-group">
            <label>Amenities Emojis</label>
            <input id="amenitiesEmojies" name="amenitiesEmojies" type="text" value="<?php echo htmlspecialchars($room['amenitiesEmojies']); ?>">
          </div>

          <div class="form-group">
            <label>Additional Description</label>
            <textarea id="additionalDescription" name="additionalDescription"><?php echo htmlspecialchars($room['additionalDescription']); ?></textarea>
          </div>

          <div class="form-group">
            <button type="button" class="submit-btn btn-primary" id="updateRoomBtn">Save Changes</button>
          </div>
          <div class="form-group more-actions">
                <H3>MORE ACTIONS</H3>
                <button type="button" class="delete-room-btn submit-btn btn-primary" id="delete-room-btn">Delete Room</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="js/editRoom.js"></script>
</body>
</html>
