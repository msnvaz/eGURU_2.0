<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-GURU</title>
    <link rel="stylesheet" href="/css/home.css"> <!-- Link to the external CSS -->

</head>
<body>

<?php include 'navbar.php'; ?> <!-- Include the navbar -->

    <section id="home">
        <div class="main_pg" ><!-- main home page -->
            <div class="content">

                <div class="text">
                    <h1 class="main_title">Welcome to e-Guru</h1>

                    <h2 class="sub_title_1">Unlock Your Potential with Personalized One-on-One Tutoring Sessions</h2>

                    <h3 class="sub_title_2">Find the perfect tutor to match your learning style and goals. Join our community today and start your journey to success.</h3>

                    <br>

                    <div class="button-container">
                        <a href="tutor-signup"><button class="btn_tutor">Join as a Tutor</button></a>
                        <span class="or-text">OR</span>
                        <a href="student-signup"><button class="btn_student">Start Learning Now</button></a>
                    </div>
                </div>

                <div class="image">
                    <img src="/images/front-image-01.png" alt="Front Image" >
                </div>

            </div>
        </div>
    </section>

    <section  id="howitworks">
        <div class="how_it_works_pg" style="background-color:rgba(249, 249, 249, 0.44);">

            <!-- How e-Guru Works Section -->
            <div class="eguru-works">
                <h2>How e-Guru Works?</h2>
                <div class="steps-container">
                    <!-- Step 1 -->
                    <div class="step">
                        <h3>1. Find Your Tutor, Earn Your Way.</h3>
                        <p>Discover your ideal tutor, share your knowledge, and earn.</p>
                        <img src="images/works_img_1.png" alt="Step 1: Find Your Tutor, Earn Your Way">
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="step">
                        <h3>2. Start learning. Start Tutoring.</h3>
                        <p>Conquer your challenges with expert guidance.</p>
                        <img src="images/works_img_3.png" alt="Step 2: Start learning. Start Tutoring">
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="step">
                        <h3>3. Discuss. Learn. Practice. Repeat.</h3>
                        <p>Choose lessons you want to learn and achieve your goals.</p>
                        <img src="images/works_img_2.png" alt="Step 3: Discuss. Learn. Practice. Repeat">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section  id="why">
        <div class="why_pg" >

            <!-- Top Section - Why Choose Us -->
            <div class="why-choose-us">
                <div class="container">
                    <h2>Why Choose Us?</h2>
                    <p class="subtitle">A choice that makes the difference</p>

                    <div class="features">
                        <div class="feature">
                            <img src="images/Experience.png" alt="Highly Experienced" width="350px">
                            <h3>Highly Experienced</h3>
                        </div>
                        <div class="feature">
                            <img src="images/Support.png" alt="Dedicated Support" width="350px">
                            <h3>Dedicated Support</h3>
                        </div>
                        <div class="feature">
                            <img src="images/Q&A.png" alt="Questions & Answers" width="350px">
                            <h3>Questions & Answers</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Section - Empowering Learning Journey -->
            <div class="empowering-journey">
                <h1>Empowering Your Learning Journey</h1>
                <p>Our website lets you quickly find the right tutors, schedule classes, and track your progress from anywhere, at any time. Achieve your academic goals with ease and efficiency.</p>
            </div>

            <!-- Three Columns Section -->
            <div class="features-columns">
                <div class="column">
                    <h3>Empowered Learning</h3>
                    <p>Students are empowered to find and connect with qualified tutors anytime, anywhere, ensuring personalized and effective learning experiences.</p>
                </div>
                <div class="column">
                    <h3>Comprehensive Support</h3>
                    <p>The platform allows students to report any issues or request additional help directly to their tutors or administrators.</p>
                </div>
                <div class="column">
                    <h3>Seamless Connection</h3>
                    <p>Our platform connects students with a wide range of tutors specializing in various subjects and grades. Find the perfect tutor for your academic needs.</p>
                </div>
            </div>
        </div>

    </section>

    <!-- testimonial-section - We Value Our Students Let's Hear from them -->

    <?php include 'studentreview.php'?>

    <!-- Advertisement-section - Meet Some of Our Best Tutors -->

    <section  id="tutors">
        <?php include 'tutor_ad_display.php';?>
        
        <br>
        <?php include 'announcement.php'; ?>

        <br>


        <!-- Most-Populat-tutor-section - Meet Some of Our Best Tutors -->

        <h3 class="category-title">Most Active Tutors</h3>
        
        <?php include 'tutor-active.php'; ?>

        <!-- <div class="tutor-gallery">
            <button class="gallery-btn prev">&lt;</button>
            <div class="tutors">
                <div class="tutor"><img src="images/tutor_1.jpeg" alt="Tutor 1"><span>Tutor 1</span></div>
                <div class="tutor"><img src="images/tutor_1.jpeg" alt="Tutor 1"><span>Tutor 1</span></div>
                <div class="tutor"><img src="images/tutor_1.jpeg" alt="Tutor 1"><span>Tutor 1</span></div>
                <div class="tutor"><img src="images/tutor_1.jpeg" alt="Tutor 1"><span>Tutor 1</span></div>
            </div>
            <button class="gallery-btn next">&gt;</button>
        </div> -->

        <br>

        <h3 class="category-title">Most Popular Tutors</h3>

        <?php include 'tutor-popular.php'; ?>

        <!-- <div class="tutor-gallery">
            <button class="gallery-btn prev">&lt;</button>
            <div class="tutors">
                <div class="tutor"><img src="images/tutor_1.jpeg" alt="Tutor 1"><span>Tutor 1</span></div>
                <div class="tutor"><img src="images/tutor_1.jpeg" alt="Tutor 1"><span>Tutor 1</span></div>
                <div class="tutor"><img src="images/tutor_1.jpeg" alt="Tutor 1"><span>Tutor 1</span></div>
                <div class="tutor"><img src="images/tutor_1.jpeg" alt="Tutor 1"><span>Tutor 1</span></div>
            </div>
            <button class="gallery-btn next">&gt;</button>
        </div> -->
        
        <br><br>
    </section>

    <section id="subjects">
            <br>
            <br>

            <h2 class="subject-heading" >CHOOSE YOUR SUBJECT</h2>

            <div class="subject-container">
    <a href="/subject?subject=Science"><div class="subject"><img src="images/subjects/Agri.png" alt="Science"><br>Science</div></a>
    <a href="/subject?subject=English"><div class="subject"><img src="images/subjects/English.jpg" alt="English"><br>English</div></a>
    <a href="/subject?subject=History"><div class="subject"><img src="images/subjects/History.png" alt="History"><br>History</div></a>
    <a href="/subject?subject=Geography"><div class="subject"><img src="images/subjects/Geography.jpg" alt="Geography"><br>Geography</div></a>
    <a href="/subject?subject=Information Technology"><div class="subject"><img src="images/subjects/IT.jpg" alt="IT"><br>Information Technology</div></a>
    <a href="/subject?subject=Sinhala"><div class="subject"><img src="images/subjects/Sinhala.jpg" alt="Sinhala"><br>Sinhala</div></a>
    <a href="/subject?subject=Tamil"><div class="subject"><img src="images/subjects/Tamil.svg" alt="Tamil"><br>Tamil</div></a>
    <a href="/subject?subject=Chemistry"><div class="subject"><img src="images/subjects/Chemistry.jpg" alt="Chemistry"><br>Chemistry</div></a>
    <a href="/subject?subject=Physics"><div class="subject"><img src="images/subjects/Chemistry.jpg" alt="Physics"><br>Physics</div></a>
    <a href="/subject?subject=Biology"><div class="subject"><img src="images/subjects/Biology.jpg" alt="Biology"><br>Biology</div></a>
    <a href="/subject?subject=Mathematics"><div class="subject"><img src="images/subjects/math_icon.jpg" alt="Mathematics"><br>Mathematics</div></a>
    <a href="/subject?subject=Buddhism"><div class="subject"><img src="images/subjects/Buddhism.jpeg" alt="Buddhism"><br>Buddhism</div></a>
</div>

    </section>

    <br><br><br>
    <br><br><br>
    
    <?php include 'tutorsearch.php'; ?>


    <!--Your Path to Personalized Learning Section-->

    <section id="about">
            <br><br>
            <div class="banner" >
                <h1 >E-Guru</h1>
                <p>Your Path to Personalized Learning</p>
            </div>
        

        <div class="content-box">
            <h2>Our Mission</h2>
            <p>
                Our mission is to empower students by providing access to high-quality, personalized education. 
                We strive to bridge the gap between traditional classroom learning and the flexibility of online education, 
                ensuring that every student can achieve their full potential.
            </p>

            <br>
            
            <h2>Our Vision</h2>
            <p>
                We envision a world where education is accessible, flexible, and tailored to each student's needs. 
                At e-Guru, we are committed to leveraging technology to enhance learning experiences and outcomes, 
                making education more inclusive and effective.
            </p>
        </div>
    </section>
    <!-- php code line for visitor-query should be here -->
     <br>
    <!-- FAQ Section-->

    <section id="faq">
        <div class="faq-container" id="faq">
            <br><br><br><br>
            <h1>Frequently Asked Questions</h1>
            <br>
            <h2>For Students and Parents</h2>
            <br>
            <div class="faq">
                <button class="faq-question">How to report an issue?</button>
                <div class="faq-answer">
                    <p>You can report an issue by contacting the support team through our website or app.</p>
                </div>

                <button class="faq-question">Who should I report to?</button>
                <div class="faq-answer">
                    <p>You should report issues to the school administration or use the designated reporting channel.</p>
                </div>

                <button class="faq-question">Can I report anonymously?</button>
                <div class="faq-answer">
                    <p>Yes, our reporting system allows anonymous submissions to protect your privacy.</p>
                </div>
            </div>
            <br>
            <h2>For Teachers and Administrators</h2>
            <br>
            <div class="faq">
                <button class="faq-question">How do authorities know if a student or parent reported an issue?</button>
                <div class="faq-answer">
                    <p>Authorities review each report and use secure tracking systems to verify submissions.</p>
                </div>

                <button class="faq-question">What can the authorities do with the reports?</button>
                <div class="faq-answer">
                    <p>Authorities can take appropriate actions based on the content of the reports.</p>
                </div>

                <button class="faq-question">How can authorities inform the public about the status of their report?</button>
                <div class="faq-answer">
                    <p>Authorities may issue status updates through a secure dashboard or email notifications.</p>
                </div>

                <button class="faq-question">What types of dashboards or user options are available?</button>
                <div class="faq-answer">
                    <p>There are various dashboards available that allow users to track report statuses and access other information.</p>
                </div>
            </div>
        </div>

        <script>

            document.querySelectorAll(".faq-question").forEach(button => {
                button.addEventListener("click", () => {
                    const answer = button.nextElementSibling;

                    // Toggle the 'visible' class on the answer
                    answer.classList.toggle("visible");

                    // Optionally, close other answers
                    document.querySelectorAll(".faq-answer").forEach(otherAnswer => {
                        if (otherAnswer !== answer) otherAnswer.classList.remove("visible");
                    });
                });
            });

        </script>
    </section>


    <div class="trusted-companies-section">
        <h2>Companies That Trust Us</h2>
        <div class="companylogo-container">
            <img src="images/BOC.png" alt="BOC Logo">
            <img src="images/commercialbank.png" alt="Commercial Bank Logo">
            <img src="images/NTB.png" alt="Nations Trust Bank Logo">
        </div>
    </div>

        <h2>Discussion Platform</h2>
    
    <?php include 'forum.php'; ?> <!-- Include the forum-->



    <?php include 'footer.php'; ?> <!-- Include the footer-->


</body>
</html>