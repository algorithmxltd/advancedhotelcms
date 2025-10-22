// js/room2.js
document.addEventListener('DOMContentLoaded', function () {
  // Initialize Lucide icons
  if (window.lucide && typeof lucide.createIcons === 'function') {
    lucide.createIcons();
  }

  // ---- Booking / guests / pricing logic (kept as-is, defensive) ----
  const checkinInput = document.getElementById('checkin');
  const checkoutInput = document.getElementById('checkout');
  const guestsSelector = document.getElementById('guests-selector');
  const guestsDropdown = document.getElementById('guests-dropdown');
  const guestsDisplay = document.getElementById('guests-display');
  const reserveBtn = document.getElementById('reserve-btn');
  const priceBreakdown = document.getElementById('price-breakdown');
  const bookingForm = document.getElementById('booking-form');

  const adultsCount = document.getElementById('adults-count');
  const childrenCount = document.getElementById('children-count');
  const counters = document.querySelectorAll('.counter-btn');

  const nightsText = document.getElementById('nights-text');
  const subtotal = document.getElementById('subtotal');
  const totalAmount = document.getElementById('total-amount');

  // simple guard for required booking elements
  const bookingAvailable = !!bookingForm && !!checkinInput && !!checkoutInput && !!reserveBtn;

  // Guest state
  let guests = { adults: 1, children: 0 };

  // Pricing defaults (you can replace roomPrice programmatically if needed)
  let roomPrice = 299;
  const cleaningFee = 50;
  const serviceFee = 42;

  // If PHP injects a data-room-price attribute on the booking-card, use it
  const bookingCard = document.querySelector('.booking-card');
  if (bookingCard && bookingCard.dataset && bookingCard.dataset.roomPrice) {
    const p = parseFloat(bookingCard.dataset.roomPrice);
    if (!Number.isNaN(p)) roomPrice = p;
  }

  // Set minimum dates
  const today = new Date().toISOString().split('T')[0];
  if (checkinInput) checkinInput.setAttribute('min', today);
  if (checkoutInput) checkoutInput.setAttribute('min', today);

  // Guests dropdown handlers (defensive)
  if (guestsSelector && guestsDropdown) {
    guestsSelector.addEventListener('click', function (e) {
      e.stopPropagation();
      toggleGuestsDropdown();
    });

    document.addEventListener('click', function (e) {
      if (!guestsSelector.contains(e.target) && !guestsDropdown.contains(e.target)) {
        closeGuestsDropdown();
      }
    });
  }

  function toggleGuestsDropdown() {
    if (!guestsDropdown || !guestsSelector) return;
    const isActive = guestsDropdown.classList.contains('active');
    if (isActive) closeGuestsDropdown(); else openGuestsDropdown();
  }
  function openGuestsDropdown() {
    guestsDropdown.classList.add('active');
    guestsSelector.classList.add('active');
  }
  function closeGuestsDropdown() {
    guestsDropdown.classList.remove('active');
    guestsSelector.classList.remove('active');
  }

  // Counter buttons
  if (counters.length) {
    counters.forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        const action = this.getAttribute('data-action');
        const type = this.getAttribute('data-type');
        if (action === 'increase') increaseGuest(type);
        else if (action === 'decrease') decreaseGuest(type);
      });
    });
  }

  function increaseGuest(type) {
    if (type === 'adults') {
      if (guests.adults < 8) guests.adults++;
    } else if (type === 'children') {
      if (guests.children < 5) guests.children++;
    }
    updateGuestDisplay();
    updateCounterButtons();
  }
  function decreaseGuest(type) {
    if (type === 'adults') {
      if (guests.adults > 1) guests.adults--;
    } else if (type === 'children') {
      if (guests.children > 0) guests.children--;
    }
    updateGuestDisplay();
    updateCounterButtons();
  }
  function updateGuestDisplay() {
    if (adultsCount) adultsCount.textContent = guests.adults;
    if (childrenCount) childrenCount.textContent = guests.children;

    const totalGuests = guests.adults + guests.children;
    let displayText = totalGuests === 1 ? '1 guest' : `${totalGuests} guests`;
    if (guests.children > 0) {
      displayText += ` (${guests.children} ${guests.children === 1 ? 'child' : 'children'})`;
    }
    if (guestsDisplay) guestsDisplay.textContent = displayText;
  }
  function updateCounterButtons() {
    const decreaseAdultsBtn = document.querySelector('[data-action="decrease"][data-type="adults"]');
    const increaseAdultsBtn = document.querySelector('[data-action="increase"][data-type="adults"]');
    const decreaseChildrenBtn = document.querySelector('[data-action="decrease"][data-type="children"]');
    const increaseChildrenBtn = document.querySelector('[data-action="increase"][data-type="children"]');

    if (decreaseAdultsBtn) decreaseAdultsBtn.disabled = guests.adults <= 1;
    if (increaseAdultsBtn) increaseAdultsBtn.disabled = guests.adults >= 8;
    if (decreaseChildrenBtn) decreaseChildrenBtn.disabled = guests.children <= 0;
    if (increaseChildrenBtn) increaseChildrenBtn.disabled = guests.children >= 5;
  }

  // Date validation & pricing
  if (checkinInput) {
    checkinInput.addEventListener('change', function () {
      const checkinDate = new Date(this.value);
      if (checkoutInput) {
        const nextDay = new Date(checkinDate);
        nextDay.setDate(nextDay.getDate() + 1);
        checkoutInput.setAttribute('min', nextDay.toISOString().split('T')[0]);

        const checkoutDate = checkoutInput.value ? new Date(checkoutInput.value) : null;
        if (checkoutDate && checkoutDate <= checkinDate) checkoutInput.value = '';
      }
      updatePricing();
    });
  }
  if (checkoutInput) {
    checkoutInput.addEventListener('change', updatePricing);
  }

  function updatePricing() {
    if (!checkinInput || !checkoutInput) return hidePricing();
    if (checkinInput.value && checkoutInput.value) {
      const checkinDate = new Date(checkinInput.value);
      const checkoutDate = new Date(checkoutInput.value);
      const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
      const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
      if (nights > 0) {
        const roomTotal = roomPrice * nights;
        const total = roomTotal + cleaningFee + serviceFee;
        if (nightsText) nightsText.textContent = `Ksh ${roomPrice} x ${nights} ${nights === 1 ? 'night' : 'nights'}`;
        if (subtotal) subtotal.textContent = `Ksh ${roomTotal.toLocaleString()}`;
        if (totalAmount) totalAmount.textContent = `Ksh ${total.toLocaleString()}`;
        if (priceBreakdown) priceBreakdown.style.display = 'block';
        if (reserveBtn) { reserveBtn.disabled = false; reserveBtn.textContent = 'Reserve'; }
        return;
      }
    }
    hidePricing();
  }
  function hidePricing() {
    if (priceBreakdown) priceBreakdown.style.display = 'none';
    if (reserveBtn) { reserveBtn.disabled = true; reserveBtn.textContent = 'Check availability'; }
  }

  // Booking form submit (demo)
  if (bookingForm) {
    bookingForm.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!validateForm()) return;
      if (reserveBtn) {
        reserveBtn.disabled = true;
        reserveBtn.textContent = 'Processing...';
        reserveBtn.classList.add('loading');
      }
      setTimeout(() => showBookingSuccess(), 1200);
    });
  }

  function validateForm() {
    // Basic validation: ensure dates and guests selected
    let isValid = true;
    if (!checkinInput || !checkinInput.value) {
      showError(checkinInput || document.body, 'Please select a check-in date');
      isValid = false;
    }
    if (!checkoutInput || !checkoutInput.value) {
      showError(checkoutInput || document.body, 'Please select a check-out date');
      isValid = false;
    }
    const totalGuests = guests.adults + guests.children;
    if (totalGuests <= 0) {
      showError(guestsSelector || document.body, 'Please select at least one guest');
      isValid = false;
    }
    return isValid;
  }

  function showError(element, message) {
    if (!element) return;
    let errorElement = element.parentNode ? element.parentNode.querySelector('.error-message') : null;
    if (!errorElement) {
      errorElement = document.createElement('div');
      errorElement.className = 'error-message';
      if (element.parentNode) element.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
    errorElement.classList.add('show');
    if (element.style) element.style.borderColor = '#dc2626';
    const removeError = () => {
      if (element.style) element.style.borderColor = '';
      errorElement.classList.remove('show');
      element.removeEventListener('focus', removeError);
      element.removeEventListener('change', removeError);
    };
    element.addEventListener('focus', removeError);
    element.addEventListener('change', removeError);
  }

  function showBookingSuccess() {
    const modal = document.createElement('div');
    modal.innerHTML = `
      <div style="position: fixed; inset:0; background: rgba(0,0,0,0.5); display:flex;align-items:center;justify-content:center; z-index:12000;">
        <div style="background:#fff;padding:2rem;border-radius:.75rem;max-width:420px;text-align:center;">
          <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;color:#fff;font-size:1.25rem;">✓</div>
          <h3 style="margin:0 0 .5rem">Booking Confirmed!</h3>
          <p style="color:#6b7280;margin-bottom:1rem;">Your reservation has been submitted. You will receive a confirmation shortly.</p>
          <button onclick="location.reload()" style="background:linear-gradient(135deg,#2563eb,#0891b2);color:#fff;border:none;padding:.75rem 1.25rem;border-radius:.5rem;font-weight:600;cursor:pointer;">Book Another Room</button>
        </div>
      </div>
    `;
    document.body.appendChild(modal);
  }

  // Initialize counters
  updateCounterButtons();

  // Accessibility niceties
  if (window.innerWidth <= 768 && reserveBtn) {
    reserveBtn.addEventListener('click', function () {
      if (this.disabled && checkinInput) checkinInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
  }
  setTimeout(() => { if (checkinInput && !checkinInput.value) checkinInput.focus(); }, 500);

  // ---- Photo modal & fullscreen viewer ----
  const showAllPhotosBtn = document.getElementById('show-all-photos');
  const photoGalleryModal = document.getElementById('photo-gallery-modal');
  const modalOverlay = document.getElementById('modal-overlay');
  const closeModalBtn = document.getElementById('close-modal');

  // Defensive helper to get modal images (the modal should already be rendered by PHP)
  function getModalImages() {
    return Array.from(document.querySelectorAll('.photo-item img'));
  }

  // Open/close modal
  function openPhotoModal() {
    if (!photoGalleryModal) return;
    photoGalleryModal.classList.add('active');
    document.body.style.overflow = 'hidden';
    // refresh icons inside modal
    if (window.lucide && typeof lucide.createIcons === 'function') {
      setTimeout(() => lucide.createIcons(), 50);
    }
  }
  function closePhotoModal() {
    if (!photoGalleryModal) return;
    photoGalleryModal.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (showAllPhotosBtn) showAllPhotosBtn.addEventListener('click', openPhotoModal);
  if (closeModalBtn) closeModalBtn.addEventListener('click', closePhotoModal);
  if (modalOverlay) modalOverlay.addEventListener('click', closePhotoModal);

  // ESC key closes modal(s)
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closePhotoModal();
      closeFullscreenImage();
    }
  });

  // Fullscreen viewer: create on demand
  let currentImageIndex = 0;
  function createFullscreenModal() {
    if (document.getElementById('fullscreen-image-modal')) return;
    const fullscreenModal = document.createElement('div');
    fullscreenModal.id = 'fullscreen-image-modal';
    fullscreenModal.className = 'fullscreen-image-modal';
    fullscreenModal.innerHTML = `
      <div class="fullscreen-content">
        <button class="fullscreen-nav prev" id="prev-image"><i data-lucide="chevron-left"></i></button>
        <img class="fullscreen-image" id="fullscreen-image" src="" alt="">
        <button class="fullscreen-nav next" id="next-image"><i data-lucide="chevron-right"></i></button>
        <button class="fullscreen-close" id="fullscreen-close"><i data-lucide="x"></i></button>
      </div>
    `;
    document.body.appendChild(fullscreenModal);

    const prev = document.getElementById('prev-image');
    const next = document.getElementById('next-image');
    const closeBtn = document.getElementById('fullscreen-close');

    if (prev) prev.addEventListener('click', showPreviousImage);
    if (next) next.addEventListener('click', showNextImage);
    if (closeBtn) closeBtn.addEventListener('click', closeFullscreenImage);

    fullscreenModal.addEventListener('click', function (e) {
      if (e.target === fullscreenModal) closeFullscreenImage();
    });

    // build icons
    if (window.lucide && typeof lucide.createIcons === 'function') lucide.createIcons();
  }

  // Open fullscreen image by index (index relative to modal images order)
  function openFullscreenImage(index) {
    const modalImgs = getModalImages();
    if (!modalImgs.length) return;
    if (index < 0) index = 0;
    if (index >= modalImgs.length) index = modalImgs.length - 1;

    createFullscreenModal();
    currentImageIndex = index;

    const fullscreenModal = document.getElementById('fullscreen-image-modal');
    const fullscreenImage = document.getElementById('fullscreen-image');

    fullscreenImage.src = modalImgs[currentImageIndex].src;
    fullscreenImage.alt = modalImgs[currentImageIndex].alt || `Photo ${currentImageIndex + 1}`;

    fullscreenModal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeFullscreenImage() {
    const fullscreenModal = document.getElementById('fullscreen-image-modal');
    if (!fullscreenModal) return;
    fullscreenModal.classList.remove('active');
    document.body.style.overflow = '';
  }

  function showPreviousImage() {
    const modalImgs = getModalImages();
    if (!modalImgs.length) return;
    currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : modalImgs.length - 1;
    const fullscreenImage = document.getElementById('fullscreen-image');
    if (fullscreenImage) {
      fullscreenImage.src = modalImgs[currentImageIndex].src;
      fullscreenImage.alt = modalImgs[currentImageIndex].alt || `Photo ${currentImageIndex + 1}`;
    }
  }

  function showNextImage() {
    const modalImgs = getModalImages();
    if (!modalImgs.length) return;
    currentImageIndex = currentImageIndex < modalImgs.length - 1 ? currentImageIndex + 1 : 0;
    const fullscreenImage = document.getElementById('fullscreen-image');
    if (fullscreenImage) {
      fullscreenImage.src = modalImgs[currentImageIndex].src;
      fullscreenImage.alt = modalImgs[currentImageIndex].alt || `Photo ${currentImageIndex + 1}`;
    }
  }

  // Click handlers:
  // - clicking any image inside the modal -> open fullscreen at that modal index
  // - clicking thumbnails/main images -> find that image in modal images by src and open fullscreen at that index
  document.addEventListener('click', function (e) {
    const target = e.target;

    // Photo grid inside modal
    if (target.matches('.photo-item img')) {
      e.preventDefault();
      const modalImgs = getModalImages();
      const idx = modalImgs.indexOf(target);
      if (idx >= 0) openFullscreenImage(idx);
      return;
    }

    // Main room images (thumbnails and main image)
    if (target.matches('.room-images img')) {
      e.preventDefault();
      const src = target.src;
      const modalImgs = getModalImages();
      // find by absolute src match
      const idx = modalImgs.findIndex(img => img.src === src);
      if (idx >= 0) {
        openFullscreenImage(idx);
      } else {
        // if not found in modal (unlikely), try to open modal and then fullscreen first image
        openPhotoModal();
        setTimeout(() => {
          const refreshed = getModalImages();
          const idx2 = refreshed.findIndex(img => img.src === src);
          if (idx2 >= 0) openFullscreenImage(idx2);
          else openFullscreenImage(0);
        }, 120);
      }
      return;
    }
  });

  // Keyboard navigation for fullscreen
  document.addEventListener('keydown', function (e) {
    const fullscreenModal = document.getElementById('fullscreen-image-modal');
    if (fullscreenModal && fullscreenModal.classList.contains('active')) {
      if (e.key === 'ArrowLeft') { e.preventDefault(); showPreviousImage(); }
      else if (e.key === 'ArrowRight') { e.preventDefault(); showNextImage(); }
    }
  });

  // Optional parallax effect on hero images (kept, but safe)
  let ticking = false;
  function updateParallax() {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.room-images img');
    parallaxElements.forEach(el => {
      const speed = 0.1;
      el.style.transform = `translateY(${-(scrolled * speed)}px)`;
    });
    ticking = false;
  }
  function requestTick() {
    if (!ticking) { requestAnimationFrame(updateParallax); ticking = true; }
  }
  window.addEventListener('scroll', requestTick);
});
