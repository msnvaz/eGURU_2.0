<section  id="reviews">
<section id="reviews">
    <div class="testimonial-section">
        <br><br><br>
        <div class="color-section">
            <h2 class="section-title">We Value Our Students, Let's Hear from them</h2>
            <div class="testimonial-slider">
                <button class="slider-btn prev">&lt;</button>

                <?php
                // Replace with your actual database credentials
                $conn = new mysqli("localhost", "root", "", "eguru");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Limit to 5 testimonials with rating = 5
                $sql = "SELECT sf.student_feedback, st.student_first_name, st.student_last_name, st.student_profile_photo
                        FROM session_feedback sf
                        JOIN session s ON sf.session_id = s.session_id
                        JOIN student st ON s.student_id = st.student_id
                        WHERE sf.session_rating = '5'
                        LIMIT 5";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <img src="' . htmlspecialchars($row['student_profile_photo']) . '" alt="' . htmlspecialchars($row['student_first_name']) . ' ' . htmlspecialchars($row['student_last_name']) . '" class="testimonial-img">
                                <div class="testimonial-text">
                                    <h3>Find the right tutor for you!</h3>
                                    <p>"' . htmlspecialchars($row['student_feedback']) . '"</p>
                                    <span>- ' . htmlspecialchars($row['student_first_name']) . ' ' . htmlspecialchars($row['student_last_name']) . ' -</span>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo "<p>No 5-star testimonials available.</p>";
                }

                $conn->close();
                ?>

                <button class="slider-btn next">&gt;</button>
            </div>
        </div>
    </div>

    <!-- (Optional static testimonials below, or remove them if unnecessary) -->
    <div class="features-columns">
        <button class="arrow-btn prev">&lt;</button>
        <div class="column">
            <p>Whenever I think of quality education now, I think of them instantly. I’ve done so many courses in my free time and learned so much! Thank you for redefining online education for me!</p>
            <span>- Ellison Morkel -</span>
        </div>
        <div class="column">
            <p>Whenever I think of quality education now, I think of them instantly. I’ve done so many courses in my free time and learned so much! Thank you for redefining online education for me!</p>
            <span>- Ellison Morkel -</span>
        </div>
        <div class="column">
            <p>Whenever I think of quality education now, I think of them instantly. I’ve done so many courses in my free time and learned so much! Thank you for redefining online education for me!</p>
            <span>- Ellison Morkel -</span>
        </div>
        <button class="arrow-btn next">&gt;</button>
    </div>
</section>

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
