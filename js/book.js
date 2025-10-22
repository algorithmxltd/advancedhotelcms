// Hotel Booking JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();

    // Form elements
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    const guestsSelector = document.getElementById('guests-selector');
    const guestsDropdown = document.getElementById('guests-dropdown');
    const guestsDisplay = document.getElementById('guests-display');
    const reserveBtn = document.getElementById('reserve-btn');
    const priceBreakdown = document.getElementById('price-breakdown');
    const bookingForm = document.getElementById('booking-form');

    // Counter elements
    const adultsCount = document.getElementById('adults-count');
    const childrenCount = document.getElementById('children-count');
    const counters = document.querySelectorAll('.counter-btn');

    // Price elements
    const nightsText = document.getElementById('nights-text');
    const subtotal = document.getElementById('subtotal');
    const totalAmount = document.getElementById('total-amount');

    // Guest counts
    let guests = {
        adults: 1,
        children: 0
    };

    // Room pricing
    const roomPrice = 299;
    const cleaningFee = 50;
    const serviceFee = 42;

    // Set minimum dates
    const today = new Date().toISOString().split('T')[0];
    checkinInput.setAttribute('min', today);
    checkoutInput.setAttribute('min', today);

    // Guest selector functionality
    guestsSelector.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleGuestsDropdown();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!guestsSelector.contains(e.target) && !guestsDropdown.contains(e.target)) {
            closeGuestsDropdown();
        }
    });

    function toggleGuestsDropdown() {
        const isActive = guestsDropdown.classList.contains('active');
        if (isActive) {
            closeGuestsDropdown();
        } else {
            openGuestsDropdown();
        }
    }

    function openGuestsDropdown() {
        guestsDropdown.classList.add('active');
        guestsSelector.classList.add('active');
    }

    function closeGuestsDropdown() {
        guestsDropdown.classList.remove('active');
        guestsSelector.classList.remove('active');
    }

    // Counter functionality
    counters.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.getAttribute('data-action');
            const type = this.getAttribute('data-type');
            
            if (action === 'increase') {
                increaseGuest(type);
            } else if (action === 'decrease') {
                decreaseGuest(type);
            }
        });
    });

    function increaseGuest(type) {
        if (type === 'adults') {
            if (guests.adults < 8) {
                guests.adults++;
                updateGuestDisplay();
            }
        } else if (type === 'children') {
            if (guests.children < 5) {
                guests.children++;
                updateGuestDisplay();
            }
        }
        updateCounterButtons();
    }

    function decreaseGuest(type) {
        if (type === 'adults') {
            if (guests.adults > 1) {
                guests.adults--;
                updateGuestDisplay();
            }
        } else if (type === 'children') {
            if (guests.children > 0) {
                guests.children--;
                updateGuestDisplay();
            }
        }
        updateCounterButtons();
    }

    function updateGuestDisplay() {
        adultsCount.textContent = guests.adults;
        childrenCount.textContent = guests.children;
        
        const totalGuests = guests.adults + guests.children;
        let displayText = '';
        
        if (totalGuests === 1) {
            displayText = '1 guest';
        } else {
            displayText = `${totalGuests} guests`;
        }
        
        if (guests.children > 0) {
            displayText += ` (${guests.children} ${guests.children === 1 ? 'child' : 'children'})`;
        }
        
        guestsDisplay.textContent = displayText;
    }

    function updateCounterButtons() {
        // Update adults buttons
        const decreaseAdultsBtn = document.querySelector('[data-action="decrease"][data-type="adults"]');
        const increaseAdultsBtn = document.querySelector('[data-action="increase"][data-type="adults"]');
        
        decreaseAdultsBtn.disabled = guests.adults <= 1;
        increaseAdultsBtn.disabled = guests.adults >= 8;

        // Update children buttons
        const decreaseChildrenBtn = document.querySelector('[data-action="decrease"][data-type="children"]');
        const increaseChildrenBtn = document.querySelector('[data-action="increase"][data-type="children"]');
        
        decreaseChildrenBtn.disabled = guests.children <= 0;
        increaseChildrenBtn.disabled = guests.children >= 5;
    }

    // Date validation
    checkinInput.addEventListener('change', function() {
        const checkinDate = new Date(this.value);
        const checkoutDate = new Date(checkoutInput.value);
        
        // Update checkout minimum date
        const nextDay = new Date(checkinDate);
        nextDay.setDate(nextDay.getDate() + 1);
        checkoutInput.setAttribute('min', nextDay.toISOString().split('T')[0]);
        
        // Clear checkout if it's before or same as checkin
        if (checkoutInput.value && checkoutDate <= checkinDate) {
            checkoutInput.value = '';
        }
        
        updatePricing();
    });

    checkoutInput.addEventListener('change', function() {
        updatePricing();
    });

    function updatePricing() {
        if (checkinInput.value && checkoutInput.value) {
            const checkinDate = new Date(checkinInput.value);
            const checkoutDate = new Date(checkoutInput.value);
            const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
            const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            if (nights > 0) {
                const roomTotal = roomPrice * nights;
                const total = roomTotal + cleaningFee + serviceFee;
                
                // Update pricing display
                nightsText.textContent = `$${roomPrice} x ${nights} ${nights === 1 ? 'night' : 'nights'}`;
                subtotal.textContent = `$${roomTotal}`;
                totalAmount.textContent = `$${total}`;
                
                // Show price breakdown
                priceBreakdown.style.display = 'block';
                
                // Enable reserve button
                reserveBtn.disabled = false;
                reserveBtn.textContent = 'Reserve';
            } else {
                hidePricing();
            }
        } else {
            hidePricing();
        }
    }

    function hidePricing() {
        priceBreakdown.style.display = 'none';
        reserveBtn.disabled = true;
        reserveBtn.textContent = 'Check availability';
    }

    // Form submission
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        // Show loading state
        reserveBtn.disabled = true;
        reserveBtn.textContent = 'Processing...';
        reserveBtn.classList.add('loading');
        
        // Simulate booking process
        setTimeout(() => {
            showBookingSuccess();
        }, 2000);
    });

    function validateForm() {
        let isValid = true;
        
        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(error => {
            error.classList.remove('show');
        });
        
        // Validate check-in date
        if (!checkinInput.value) {
            showError(checkinInput, 'Please select a check-in date');
            isValid = false;
        } else if (new Date(checkinInput.value) < new Date(today)) {
            showError(checkinInput, 'Check-in date cannot be in the past');
            isValid = false;
        }
        
        // Validate check-out date
        if (!checkoutInput.value) {
            showError(checkoutInput, 'Please select a check-out date');
            isValid = false;
        } else if (checkinInput.value && new Date(checkoutInput.value) <= new Date(checkinInput.value)) {
            showError(checkoutInput, 'Check-out date must be after check-in date');
            isValid = false;
        }
        
        // Validate guest count
        const totalGuests = guests.adults + guests.children;
        if (totalGuests === 0) {
            showError(guestsSelector, 'Please select at least one guest');
            isValid = false;
        } else if (totalGuests > 8) {
            showError(guestsSelector, 'Maximum 8 guests allowed');
            isValid = false;
        }
        
        return isValid;
    }

    function showError(element, message) {
        let errorElement = element.parentNode.querySelector('.error-message');
        
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            element.parentNode.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        errorElement.classList.add('show');
        
        // Add error styling to input
        element.style.borderColor = '#dc2626';
        
        // Remove error styling after user interaction
        const removeError = () => {
            element.style.borderColor = '';
            errorElement.classList.remove('show');
            element.removeEventListener('focus', removeError);
            element.removeEventListener('change', removeError);
        };
        
        element.addEventListener('focus', removeError);
        element.addEventListener('change', removeError);
    }

    function showBookingSuccess() {
        // Create success modal or redirect
        const modal = document.createElement('div');
        modal.innerHTML = `
            <div style="
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
            ">
                <div style="
                    background: white;
                    padding: 2rem;
                    border-radius: 0.75rem;
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    max-width: 400px;
                    margin: 1rem;
                ">
                    <div style="
                        width: 4rem;
                        height: 4rem;
                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0 auto 1rem;
                        color: white;
                        font-size: 1.5rem;
                    ">✓</div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: #111827;">
                        Booking Confirmed!
                    </h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem;">
                        Your reservation has been successfully submitted. You will receive a confirmation email shortly.
                    </p>
                    <button onclick="location.reload()" style="
                        background: linear-gradient(135deg, #2563eb 0%, #0891b2 100%);
                        color: white;
                        border: none;
                        padding: 0.75rem 1.5rem;
                        border-radius: 0.5rem;
                        font-weight: 600;
                        cursor: pointer;
                    ">Book Another Room</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Initialize counter buttons state
    updateCounterButtons();

    // Add smooth scrolling to reserve button on mobile
    if (window.innerWidth <= 768) {
        reserveBtn.addEventListener('click', function() {
            if (this.disabled) {
                checkinInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }

    // Auto-focus first input after page load
    setTimeout(() => {
        if (!checkinInput.value) {
            checkinInput.focus();
        }
    }, 500);

    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeGuestsDropdown();
        }
        
        if (e.key === 'Enter' && e.target.tagName !== 'BUTTON') {
            e.preventDefault();
            
            if (e.target === checkinInput) {
                checkoutInput.focus();
            } else if (e.target === checkoutInput) {
                guestsSelector.click();
            }
        }
    });

    // Add image gallery functionality
    const roomImages = document.querySelectorAll('.room-images img');
    roomImages.forEach(img => {
        img.addEventListener('click', function() {
            // In a real application, this would open a full-screen gallery
            console.log('Image gallery would open here');
        });
    });

    // Add parallax effect to hero images (subtle)
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.room-images img');
        
        parallaxElements.forEach(el => {
            const speed = 0.1;
            const yPos = -(scrolled * speed);
            el.style.transform = `translateY(${yPos}px)`;
        });
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick);
});