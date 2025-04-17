<!-- src/Views/navbar.php -->
<html><style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300,400,600&display=swap');

    /* General Styles */
    body, html {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    nav {
        position: fixed;
        top: 0;
        width: 103%;
        z-index: 1000;
        margin-left: -3%;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        padding-left:30px;
        padding-right:30px;
    }

    .logo {
        padding-top: 10px;
        height: 40px;
    }

    .nav-links {
        list-style: none;
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .nav-links li {
        margin-left: 20px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }

    .nav-link {
        text-decoration: none;
        color: rgba(41, 50, 65,1);;
        font-weight: 400;
        font-size: 15px;
        padding: 10px;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: rgb(229, 34, 115);
        border-bottom: 8px solid rgb(229, 34, 115);
        font-weight: 600;   
    }

    .nav-link.active {
        border-bottom: 8px solid rgb(229, 34, 115);
        font-weight: 600;
    }

    /* Hamburger Menu */
    .menu-toggle {
        display: none;
        flex-direction: column;
        gap: 5px;
        background: none;
        border: none;
        cursor: pointer;
    }

    .menu-toggle .bar {
        width: 25px;
        height: 3px;
        background-color: rgba(41, 50, 65,1);;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .nav-links {
            display: none;
            flex-direction: column;
            background-color: #ffffff;
            position: absolute;
            top: 60px;
            right: 10%;
            width: 80%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-links.active {
            display: flex;
        }

        .menu-toggle {
            display: flex;
        }
    }
</style>

<nav>
    <div class="navbar-container">
        <a href="/" class="logo-link">
            <img src="./images/eGURU_3.png" alt="Your Logo" class="logo">
        </a>
        <button class="menu-toggle" aria-label="Toggle Navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <ul class="nav-links">
            <li><a href="#home" class="nav-link">Home</a></li>
            <!--<li><a href="#howitworks" class="nav-link">How it Works</a></li>
            <li><a href="#why" class="nav-link">Why</a></li>-->
            <li><a href="#reviews" class="nav-link">Reviews</a></li>
            <li><a href="#tutors" class="nav-link">Tutors</a></li>
            <li><a href="#subjects" class="nav-link">Subjects</a></li>
            <li><a href="#search" class="nav-link">Search</a></li>
            <!--<li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#faq" class="nav-link">FAQ</a></li>-->
            <li><a href="#forum" class="nav-link">Forum</a></li>
            <li style='background-color: rgba(205, 199, 199, 0.4); border-radius:5px;'><a href="/tutor-login" class="nav-link">Tutor Login</a></li>
            <li style='background-color: rgba(205, 199, 199, 0.4); border-radius:5px;'><a href="/student-login" class="nav-link">Student Login</a></li>
        </ul>
    </div>
</nav>

<!--<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.querySelector(".menu-toggle");
        const navLinks = document.querySelector(".nav-links");
        const mainPageUrl = "/"; // Update with your home page URL

        // Toggle the hamburger menu
        menuToggle.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });

        // Function to remove the active class from all links
        function removeActiveClasses() {
            document.querySelectorAll(".nav-link").forEach((link) => {
                link.classList.remove("active");
            });
        }

        // Function to add the active class based on scroll position
        function addActiveClass() {
            const sections = document.querySelectorAll("section");
            const scrollPos = window.scrollY + 100; // Offset for better detection

            let activeFound = false;

            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                const sectionBottom = sectionTop + section.offsetHeight;

                if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                    const id = section.getAttribute("id");
                    const navLink = document.querySelector(`a[href="#${id}"]`);
                    if (navLink) {
                        removeActiveClasses();
                        navLink.classList.add("active");
                        activeFound = true;
                    }
                }
            });

            // Remove active class if no section is found
            if (!activeFound) {
                removeActiveClasses();
            }
        }

        // Handle navbar link clicks
        document.querySelectorAll(".nav-link").forEach((link) => {
            const href = link.getAttribute("href");

            // Redirect to the main page if hash doesn't match
            link.addEventListener("click", (event) => {
                if (href.startsWith("#") && !document.querySelector(href)) {
                    event.preventDefault();
                    window.location.href = mainPageUrl + href;
                }
            });
        });

        // On page load, handle hash-based navigation
        if (window.location.hash) {
            const hashLink = document.querySelector(`a[href="${window.location.hash}"]`);
            if (hashLink) {
                removeActiveClasses();
                hashLink.classList.add("active");
            }
        }

        // Add scroll-based detection
        const isMainPage = document.querySelectorAll("section").length > 0;
        if (isMainPage) {
            window.addEventListener("scroll", addActiveClass);
            addActiveClass(); // Initial check
        }
    });
</script>-->
</html>
