<?php
use App\Controllers\StudentReviewController;

if (!isset($testimonials)) {
    require_once __DIR__ . '/../Controllers/StudentReviewController.php';

    $controller = new StudentReviewController();
    $testimonials = $controller->showTestimonials(); 
}
?>
<section id="reviews">
    <div class="testimonial-section">
        <br><br><br>
        <div class="color-section">
            <h2 class="section-title">We Value Our Students, Let's Hear from them</h2>
            <div class="testimonial-slider">
                <button class="slider-btn prev">&lt;</button>

                <?php if (!empty($testimonials)) : ?>
                    <?php foreach ($testimonials as $row) : ?>
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <img src="<?php echo htmlspecialchars($row['student_profile_photo']); ?>" alt="<?php echo htmlspecialchars($row['student_first_name'] . ' ' . $row['student_last_name']); ?>" class="testimonial-img">
                                <div class="testimonial-text">
                                    <h3>Find the right tutor for you!</h3>
                                    <p>"<?php echo htmlspecialchars($row['student_feedback']); ?>"</p>
                                    <span>- <?php echo htmlspecialchars($row['student_first_name'] . ' ' . $row['student_last_name']); ?> -</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No testimonials available.</p>
                <?php endif; ?>

                <button class="slider-btn next">&gt;</button>
            </div>
        </div>
    </div>  
</section>


    <!-- (Optional static testimonials below, or remove them if unnecessary) -->
    <!-- <div class="testimonial-section">
        <br><br><br>
        <div class="color-section">
            <h2 class="section-title">We Value Our Students, Let's Hear from them</h2>

            <div class="features-columns">
                <button class="arrow-btn prev">&lt;</button>

                <?php if (!empty($testimonials)) : ?>
                    <?php foreach ($testimonials as $row) : ?>
                        <div class="column">
                            <p>"<?php echo htmlspecialchars($row['student_feedback']); ?>"</p>
                            <span>- <?php echo htmlspecialchars($row['student_first_name'] . ' ' . $row['student_last_name']); ?> -</span>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No testimonials available.</p>
                <?php endif; ?>

                <button class="arrow-btn next">&gt;</button>
            </div>

        </div>
    </div>
 -->

<!-- Add this script to enable testimonial navigation -->
<script>
    const testimonials = document.querySelectorAll('.testimonial');
    const prevBtn = document.querySelector('.slider-btn.prev');
    const nextBtn = document.querySelector('.slider-btn.next');

    let currentIndex = 0;

    function showTestimonial(index) {
        testimonials.forEach((testimonial, i) => {
            testimonial.style.display = (i === index) ? 'block' : 'none';
        });
    }

    showTestimonial(currentIndex); // Show first on load

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % testimonials.length;
        showTestimonial(currentIndex);
    });

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
        showTestimonial(currentIndex);
    });
</script>

<!-- Add this CSS somewhere in your CSS file or within a <style> block -->
<style>
    .testimonial {
        display: none;
    }
    .testimonial.active {
        display: block;
    }
    .testimonial-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
    }
    .testimonial-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }
</style>


        