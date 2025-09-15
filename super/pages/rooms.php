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
      <!-- Example rendered rooms (replace with your data) -->
      <div class="room-card">
        <div class="room-header">
          <div class="room-info">
            <h3>Deluxe Suite</h3>
            <div class="room-type">Suite</div>
          </div>
          <div class="room-status">Available</div>
        </div>
        <div class="room-details">
          <div class="room-detail">
            <span>Price per night:</span>
            <span class="room-detail-value">$250</span>
          </div>
          <div class="room-detail">
            <span>Available:</span>
            <span class="room-detail-value">3/5</span>
          </div>
          <div class="room-detail">
            <span>Rating:</span>
            <div class="rating">
              <svg class="star-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
              </svg>
              <span class="room-detail-value">4.5</span>
            </div>
          </div>
          <div class="progress-bar">
            <div class="progress-fill" style="width: 40%"></div>
          </div>
          <button class="btn-outline">Manage Room</button>
        </div>
      </div>

      <div class="room-card">
        <div class="room-header">
          <div class="room-info">
            <h3>Standard Room</h3>
            <div class="room-type">Double</div>
          </div>
          <div class="room-status">Occupied</div>
        </div>
        <div class="room-details">
          <div class="room-detail">
            <span>Price per night:</span>
            <span class="room-detail-value">$120</span>
          </div>
          <div class="room-detail">
            <span>Available:</span>
            <span class="room-detail-value">0/10</span>
          </div>
          <div class="room-detail">
            <span>Rating:</span>
            <div class="rating">
              <svg class="star-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
              </svg>
              <span class="room-detail-value">4.0</span>
            </div>
          </div>
          <div class="progress-bar">
            <div class="progress-fill" style="width: 100%"></div>
          </div>
          <button class="btn-outline">Manage Room</button>
        </div>
      </div>
    </div>
  </div>

