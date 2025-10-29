<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Mt Everest Hotel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/contactus.css">
</head>
<body>

       <!-- Navigation -->
    <?php include 'includes/navbar.php' ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We're here to assist you with any inquiries about your stay at Mt Everest Hotel. Reach out to us through any of the channels below.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="section-title">
                <h2>Get In Touch</h2>
                <p>Our team is always ready to help you plan your perfect mountain getaway.</p>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Our Location</h3>
                            <p>Everest Base Camp, Solukhumbu District</p>
                            <p>Nepal</p>
                        </div>
                    </div>
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Phone Numbers</h3>
                            <p>Main: +977 1 1234567</p>
                            <p>Reservations: +977 1 1234568</p>
                            <p>Emergency: +977 9801234567</p>
                        </div>
                    </div>
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Email Addresses</h3>
                            <p>General: info@mteveresthotel.com</p>
                            <p>Reservations: reservations@mteveresthotel.com</p>
                            <p>Events: events@mteveresthotel.com</p>
                        </div>
                    </div>
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Operating Hours</h3>
                            <p>Front Desk: 24/7</p>
                            <p>Reservations: 6:00 AM - 10:00 PM (NPT)</p>
                            <p>Restaurant: 7:00 AM - 10:00 PM</p>
                        </div>
                    </div>
                </div>
                <div class="contact-form">
                    <h3 style="color: var(--primary); margin-bottom: 1.5rem;">Send Us a Message</h3>
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Your full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" class="form-control" placeholder="Your email address" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" class="form-control" placeholder="Your phone number">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" class="form-control" placeholder="Message subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea id="message" class="form-control" placeholder="How can we help you?" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="section-title">
                <h2>Find Us</h2>
                <p>Located at the base of the world's highest peak for an unforgettable experience</p>
            </div>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5686016.5327611!2d82.188915275!3d27.988120999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39be6cc8f5ce3cf1%3A0x14a9f7c50b8d9c78!2sMount%20Everest!5e0!3m2!1sen!2snp!4v1690386787897!5m2!1sen!2snp" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-title">
                <h2>Frequently Asked Questions</h2>
                <p>Quick answers to common questions about our hotel and services</p>
            </div>
            <div class="faq-grid">
                <div class="faq-item">
                    <h3><i class="fas fa-question-circle"></i> How do I get to Mt Everest Hotel?</h3>
                    <p>We arrange helicopter transfers from Kathmandu to our hotel. Alternatively, you can take a flight to Lukla and then a 2-day trek to our location. Our concierge can help arrange all transportation.</p>
                </div>
                <div class="faq-item">
                    <h3><i class="fas fa-question-circle"></i> What is the best time to visit?</h3>
                    <p>The optimal seasons are pre-monsoon (March to May) and post-monsoon (late September to November) when weather conditions are most favorable for mountain views and outdoor activities.</p>
                </div>
                <div class="faq-item">
                    <h3><i class="fas fa-question-circle"></i> Do you offer altitude sickness assistance?</h3>
                    <p>Yes, we have a medical clinic with oxygen facilities and trained staff. We also provide acclimatization guidance and can arrange immediate evacuation if necessary.</p>
                </div>
                <div class="faq-item">
                    <h3><i class="fas fa-question-circle"></i> What amenities are available?</h3>
                    <p>We offer heated rooms, gourmet dining, a wellness spa, oxygen-enriched areas, satellite internet, and a range of mountain activities with expert guides.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready for Your Mountain Adventure?</h2>
            <p>Book your stay at the world's most exclusive mountain hotel and create memories that will last a lifetime.</p>
            <a href="#" class="cta-btn">Book Your Stay Now</a>
        </div>
    </section>

<?php include 'includes/footer.php' ?>

    <script>
  
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
           
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            
           
            alert(`Thank you, ${name}! Your message about "${subject}" has been sent. We'll respond to ${email} within 24 hours.`);
            
           
            this.reset();
        });

       
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

          
            const elementsToAnimate = document.querySelectorAll('.contact-card, .faq-item');
            elementsToAnimate.forEach(el => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>