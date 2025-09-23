<div class="section hidden" id="addroom-section">
  <div class="section-header">
    <h2>Add a Room</h2>
  </div>
  <!-- Response Box -->
<div id="responseBox" class="response-container" style="display:none;">
  <p id="responseMessage"></p>
  <button id="closeResponseBtn" class="response-close">Close</button>
</div>

  
  <form id="addRoomForm" enctype="multipart/form-data">
    <!-- Room Photos -->
    <div class="form-group">
      <label>Room Photos</label>
      <div class="upload-area" id="dropZone">
        <i class="fas fa-cloud-upload-alt"></i>
        <p>Drag & drop Room photos here or 'select photo' below</p>
        <input type="file" id="roomPhotos" name="roomPhotos[]" accept="image/*" multiple hidden>
        <button type="button" class="btn-primary" id="browseBtn">Select Photo</button>
      </div>
      <div class="preview-container" id="previewContainer"></div>
    </div>

    <div class="form-group">
      <label for="roomPrice">Room Price / Night</label>
      <input id="roomPrice" name="roomPrice" type="number" placeholder="Price per night in Ksh" required>
    </div>

    <div class="form-group">
      <label for="roomNumber">Room Number</label>
      <input id="roomNumber" name="roomNumber" type="text" placeholder="e.g. 101" required>
    </div>

    <div class="form-group">
      <label for="roomType">Room Type</label>
      <select id="roomType" name="roomType" required>
        <option value="">Select Room Type</option>
        <option value="Executive">Executive</option>
        <option value="Standard">Standard</option>
      </select>
    </div>

    <div class="form-group">
      <label for="roomBriefDescription">Room brief description</label>
      <input id="roomBriefDescription" name="roomBriefDescription" type="text" placeholder="Brief room description.">
    </div>

    <div class="form-group">
      <label for="roomAmenities">Room Amenities</label>
      <input id="roomAmenities" name="roomAmenities" type="text" placeholder="Bathroom, wifi, TV, Workspace...">
    </div>

    <div class="form-group">
      <label for="amenitiesEmojies">Amenities Emojis</label>
      <input id="amenitiesEmojies" name="amenitiesEmojies" type="text" placeholder="🛁 📶 ☕ 🚗">
    </div>

    <div class="form-group">
      <label for="additionalDescription">Additional description</label>
      <textarea id="additionalDescription" name="additionalDescription" placeholder="Extra details about the room..."></textarea>
    </div>

    <div class="form-group">
      <button type="button" class="submit-btn btn-primary" id="submitRoomBtn">Submit</button>
    </div>
  </form>
</div>

<script src="js/addRoom.js"></script>
