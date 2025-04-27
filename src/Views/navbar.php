<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<nav>
    <div class="navbar-container">
        <a href="/" class="logo-link" aria-label="eGURU Home">
            <img src="./images/eGURU_3.png" alt="eGURU Logo" class="logo">
        </a>
        
        <button class="menu-toggle" aria-label="Toggle Navigation" aria-expanded="false">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        
        <ul class="nav-links">
            <li><a href="/#home" class="nav-link"><i class="fas fa-home fa-fw"></i> Home</a></li>
            <li><a href="/#reviews" class="nav-link"><i class="fas fa-star fa-fw"></i> Reviews</a></li>
            <li><a href="/#tutors" class="nav-link"><i class="fas fa-chalkboard-teacher fa-fw"></i> Tutors</a></li>
            <li><a href="/#subjects" class="nav-link"><i class="fas fa-book fa-fw"></i> Subjects</a></li>
            <li><a href="/#search" class="nav-link"><i class="fas fa-search fa-fw"></i> Search</a></li>
            <li><a href="/#forum" class="nav-link"><i class="fas fa-comments fa-fw"></i> Forum</a></li>
            <li class="login-btn tutor-login"><a href="/tutor-login" class="nav-link"><i class="fas fa-user-tie fa-fw"></i> Tutor Login</a></li>
            <li class="login-btn" style="margin-right:15px;">
                <a href="/student-login" class="nav-link"><i class="fas fa-user-graduate fa-fw"></i> Student Login</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.querySelector(".menu-toggle");
        const navLinks = document.querySelector(".nav-links");
        
        // Toggle the hamburger menu
        menuToggle.addEventListener("click", () => {
            navLinks.classList.toggle("active");
            menuToggle.classList.toggle("active");
            
            // Update aria-expanded attribute for accessibility
            const expanded = menuToggle.getAttribute("aria-expanded") === "true" || false;
            menuToggle.setAttribute("aria-expanded", !expanded);
        });
        
        // Handle active link states based on current page/section
        const currentPath = window.location.pathname;
        const currentHash = window.location.hash;
        
        document.querySelectorAll(".nav-link").forEach(link => {
            const href = link.getAttribute("href");
            
            // Check if this link matches current path or hash
            if ((href === currentPath) || 
                (href === currentHash) || 
                (currentPath === "/" && href === "#home")) {
                link.classList.add("active");
            }
            
            // Add click event for smooth scrolling on hash links
            if (href.startsWith("#")) {
                link.addEventListener("click", function(e) {
                    const targetElement = document.querySelector(href);
                    if (targetElement) {
                        e.preventDefault();
                        
                        // Remove active class from all links
                        document.querySelectorAll(".nav-link").forEach(l => {
                            l.classList.remove("active");
                        });
                        
                        // Add active class to clicked link
                        this.classList.add("active");
                        
                        // Close mobile menu if open
                        navLinks.classList.remove("active");
                        menuToggle.classList.remove("active");
                        menuToggle.setAttribute("aria-expanded", "false");
                        
                        // Smooth scroll to target
                        targetElement.scrollIntoView({
                            behavior: "smooth"
                        });
                    }
                });
            }
        });
    });
</script>

</body>
</html>