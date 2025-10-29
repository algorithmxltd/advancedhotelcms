<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mt Everest Hotel</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://kit.fontawesome.com/e4c074505f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/about.css">
</head>

<body>

 <!-- Navigation -->
    <?php include 'includes/navbar.php' ?>
 

    
    <section class="hero">
        <div class="container">
            <h1>About Mt Everest Hotel</h1>
            <p>Discover the story behind our commitment to excellence and the passion that drives us to provide unforgettable experiences at the heart of Kisii Town.</p>
        </div>
    </section>

   
    <section class="about-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Story</h2>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <h3>Experience the Peak of Luxury</h3>
                    <p>Mt Everest Hotel has been a sanctuary for travelers seeking both adventure and luxury. Nestled in the heart of Kisii Town
                        , our hotel offers clear views and easy accessibility to Kisii Town and world-class amenities that create an unforgettable
                        hospitality experience.</p>
                    <p>Our journey began with a simple vision to create a haven where guests could experience the majestic comfort of a luxury retreat. Over the years, we've expanded our facilities
                        while maintaining our commitment to personalized service and hospitality sustainability.</p>
                    <p>Today, we continue to welcome explorers, visitors, and luxury travelers from around the globe, offering them a unique 
                        blend of authentic Kisii cultural foods and five-star hospitality.</p>
                </div>
                <div class="about-image">
                    <img src="uploads/rooms/landingimage.jpeg" alt="Mt Everest Hotel Exterior">
                </div>
            </div>
        </div>
    </section>

  
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;">Why Choose Us</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <h3>Ampient View of Kisii Town</h3>
                    <p>Wake up to panoramic views of Kisii Town from your private balcony.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h3>Luxury Amenities</h3>
                    <p>Enjoy our world-class facilities including ample parking space, and fine dining restaurants offering delicious meals.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Personalized Service</h3>
                    <p>Our dedicated staff ensures every detail of your stay is perfectly tailored to your preferences.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Sustainable Luxury</h3>
                    <p>We're committed to environmental sustainability while providing exceptional comfort.</p>
                </div>
            </div>
        </div>
    </section>

  
    <section class="team-section">
        <div class="container">
            <div class="section-title">
                <h2>Meet Our Team</h2>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image">
                        <img src="uploads/rooms/Cashier.png" alt="Head of Hospitality">
                    </div>
                    <div class="member-info">
                        <h3>John Brian</h3>
                        <p>Cashier</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-image">
                        <img src="uploads/rooms/Cashier.png" alt="Head of Hospitality">
                    </div>
                    <div class="member-info">
                       <h3>John Brian</h3>
                        <p>Cashier</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-image">
                        <img src="uploads/rooms/Cashier.png" alt="Head of Hospitality">
                    </div>
                    <div class="member-info">
                       <h3>John Brian</h3>
                        <p>Cashier</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

  
    <section class="values-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Values</h2>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Community</h3>
                    <p>We actively support local communities and employ residents from surrounding villages.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Sustainability</h3>
                    <p>We implement eco-friendly practices to minimize our environmental footprint.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Excellence</h3>
                    <p>We strive for perfection in every aspect of our guests' experience.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="cta-section">
        <div class="container">
            <h2>Ready for an Unforgettable Experience?</h2>
            <p>Book your stay at Mt Everest Hotel and discover the perfect blend with the kisii culture.</p>
            <a href="rooms.php" class="cta-btn">Book Your Stay Now</a>
        </div>
    </section>

 
 <?php include 'includes/footer.php' ?>
    <script>
  
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

           
            const elementsToAnimate = document.querySelectorAll('.feature-card, .team-member, .value-card');
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