<?php
use App\Controllers\TutorAdDisplayController;

if (!isset($ads)) {
    require_once __DIR__ . '/../Controllers/TutorAdDisplayController.php';

    $controller = new TutorAdDisplayController();
    $ads = $controller->getAds(); // This should return the ads without rendering the view
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tutor Ads</title>
    <style>
        .carousel-container {
            max-width: 800px;
            position: relative;
            margin: 0 auto;
            overflow: hidden;
            padding: 20px 0;
        }
        
        .carousel-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: transform 0.5s ease;
        }
        
        .carousel-slide {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            margin: 0 10px;
            transition: all 0.5s ease;
            flex: 0 0 auto;
            position: relative;
            opacity: 0.7;
            transform: scale(0.8);
        }
        
        .carousel-slide.active {
            opacity: 1;
            transform: scale(1.2);
            z-index: 10;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        
        .carousel-slide img {
            border-radius: 6px;
            width: 200px;
            height: 200px;
            object-fit: cover;
            transition: all 0.5s ease;
        }
        
        .carousel-slide.active img {
            width: 255px;
            height: 250px;
        }
        
        /* Arrow navigation styles */
        .arrow-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            z-index: 20;
        }
        
        .arrow-btn {
            color:#E14177;;
            border: none;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        
        
        
        .prev-btn {
            margin-left: -20px;
        }
        
        .next-btn {
            margin-right: -20px;
        }
        
        .carousel-dots {
            text-align: center;
            margin-top: 10px;
        }
        
        .dot {
            height: 10px;
            width: 10px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .dot.active {
            background-color: #4CAF50;
        }
        
        /* For screens where carousel needs to be more compact */
        @media (max-width: 768px) {
            .carousel-slide.active img {
                width: 200px;
                height: 200px;
            }
            
            .carousel-slide {
                transform: scale(0.7);
            }
            
            .carousel-slide.active {
                transform: scale(1);
            }
            
            .arrow-btn {
                width: 5px;
                height: 5px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <h2>Tutor Advertisements</h2>
    <center>
    <?php if (!empty($ads) && is_array($ads)): ?>
        <div class="carousel-container">
            <div class="carousel-wrapper">
                <?php foreach ($ads as $index => $ad): ?>
                    <div class="carousel-slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                        <img src="images/<?= htmlspecialchars($ad['ad_display_pic']) ?>" alt="Ad Pic">
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Arrow navigation -->
            <div class="arrow-nav">
                <button class="arrow-btn prev-btn">&#10094;</button>
                <button class="arrow-btn next-btn">&#10095;</button>
            </div>
            
            <div class="carousel-dots">
                <?php for ($i = 0; $i < count($ads); $i++): ?>
                    <span class="dot <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>"></span>
                <?php endfor; ?>
            </div>
        </div>
    <?php else: ?>
        <p>No ads found.</p>
    <?php endif; ?>
    </center>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.dot');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            const wrapper = document.querySelector('.carousel-wrapper');
            let currentIndex = 0;
            const totalSlides = slides.length;
            
            // Initial arrangement
            arrangeSlides();
            
            // Function to update active class and arrange slides
            function showSlide(index) {
                // Remove active class from all slides and dots
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));
                
                // Add active class to current slide and dot
                slides[index].classList.add('active');
                dots[index].classList.add('active');
                
                // Update current index
                currentIndex = index;
                
                // Rearrange the slides for the carousel effect
                arrangeSlides();
            }
            
            // Function to arrange slides based on current index
            function arrangeSlides() {
                // Calculate position for each slide relative to the active one
                slides.forEach((slide, index) => {
                    let offset = index - currentIndex;
                    
                    // Adjust offset for circular navigation
                    if (offset < -Math.floor(totalSlides / 2)) {
                        offset += totalSlides;
                    } else if (offset > Math.floor(totalSlides / 2)) {
                        offset -= totalSlides;
                    }
                    
                    // Position slides
                    slide.style.order = offset + Math.floor(totalSlides / 2);
                });
            }
            
            // Event listeners for navigation
            prevBtn.addEventListener('click', function() {
                let newIndex = currentIndex - 1;
                if (newIndex < 0) {
                    newIndex = slides.length - 1;
                }
                showSlide(newIndex);
            });
            
            nextBtn.addEventListener('click', function() {
                let newIndex = (currentIndex + 1) % slides.length;
                showSlide(newIndex);
            });
            
            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    showSlide(index);
                });
            });
            
            // Auto-advance the carousel every 5 seconds
            let autoplayInterval = setInterval(function() {
                let newIndex = (currentIndex + 1) % slides.length;
                showSlide(newIndex);
            }, 5000);
            
            // Pause autoplay on hover
            const carouselContainer = document.querySelector('.carousel-container');
            carouselContainer.addEventListener('mouseenter', function() {
                clearInterval(autoplayInterval);
            });
            
            carouselContainer.addEventListener('mouseleave', function() {
                autoplayInterval = setInterval(function() {
                    let newIndex = (currentIndex + 1) % slides.length;
                    showSlide(newIndex);
                }, 5000);
            });
            
            // Add swipe support for touch devices
            let touchStartX = 0;
            let touchEndX = 0;
            
            carouselContainer.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });
            
            carouselContainer.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });
            
            function handleSwipe() {
                const swipeThreshold = 50;
                if (touchEndX < touchStartX - swipeThreshold) {
                    // Swipe left - show next slide
                    let newIndex = (currentIndex + 1) % slides.length;
                    showSlide(newIndex);
                } else if (touchEndX > touchStartX + swipeThreshold) {
                    // Swipe right - show previous slide
                    let newIndex = currentIndex - 1;
                    if (newIndex < 0) {
                        newIndex = slides.length - 1;
                    }
                    showSlide(newIndex);
                }
            }
        });
    </script>
</body>
</html>