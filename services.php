<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Font for Navbar Brand -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="services.css">
    <title>Services</title>
</head>
<body>
<header>
<nav>
        <ul class="main-nav">
            <li class="navbar-brand">
                <a href="#"><img src="logo.png" alt="Logo" class="navbar-logo"> <span class="brand-name">Marie Poussepin Care Center</span></a>
            </li>
            <li class="hideOnMobile"><a href="index.php">Home</a></li>
            <li class="hideOnMobile"><a href="services.php">Services</a></li>
            <li class="hideOnMobile"><a href="about.php">About</a></li>
            <li class="hideOnMobile"><a href="contactus.php">Contact Us</a></li>
            <li onclick="showSidebar()" class="showOnMobile"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
        </ul>
    </nav>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Menu</h2>
            <span class="sidebar-close" onclick="hideSidebar()">&times;</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
        </ul>
    </div>
</header>
<div class="services-container">
    <h1>Our Services</h1>

    <div class="service-card">
        <i class="fas fa-stethoscope"></i>
        <h2>General Consultations</h2>
        <p>A medical evaluation conducted by a general practitioner to assess overall health and diagnose common ailments.</p>
    </div>

    <div class="service-card">
        <i class="fas fa-syringe"></i>
        <h2>Vaccinations</h2>
        <p>Keep yourself and your family protected with our extensive range of vaccinations available for all ages.</p>
    </div>

    <div class="service-card">
        <i class="fas fa-heartbeat"></i>
        <h2>Health Screening</h2>
        <p>Regular check-ups or tests to identify potential health issues, such as blood pressure monitoring, cholesterol checks, and cancer screenings.</p>
    </div>

    <div class="service-card">
        <i class="fas fa-hospital"></i>
        <h2>Emergency Care</h2>
        <p>Immediate medical attention for urgent or life-threatening situations like injuries, severe pain, or sudden illnesses.</p>
    </div>

    <div class="service-card">
        <i class="fas fa-brain"></i>
        <h2>Mental Health Counseling</h2>
        <p>Psychological support and counseling services for mental health conditions like anxiety, depression, or stress.</p>
    </div>

    <div class="service-card">
        <i class="fas fa-pills"></i>
        <h2>Pharmacy Services</h2>
        <p>On-site pharmacy services offering prescription and over-the-counter medications for your convenience.</p>
    </div>

    <div class="service-card">
        <i class="fas fa-pills"></i>
        <h2>Free Medicine Distribution</h2>
        <p>Provision of free or low-cost medication for certain patients, often as part of a government program or charitable initiative.</p>
    </div>
</div>

    <script>
        function showSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = 'flex';
        }

        function hideSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = 'none';
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth > 800) {
                hideSidebar();
            }
        });
    </script>
</body>