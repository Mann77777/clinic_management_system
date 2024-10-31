<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Font for Navbar Brand -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="about.css">
    <title>About</title>
</head>
<body>
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

    <div class="section">
        <h1>Together for a Healthier Tomorrow</h1>
    </div>
    <div class="section location">
        <img src="possepin.jpg" alt="Marie Poussepin Care Center Location">
        <div class="text">
            <h2>Location</h2>
            <p>Maricaban, Pasay City, Metro Manila, Philippines</p>
        </div>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d301.1055441857821!2d121.0116657431147!3d14.530709361873388!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sph!4v1718021079826!5m2!1sen!2sph" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <div class="section">
        <p>The Marie Poussepin Care Center, located in Maricaban, Pasay City, Metro Manila, Philippines, was established in 2001. Initially organized by The Little Sisters of Assumptions from 2001 to 2014, it transitioned ownership to the Dominican Sisters of the Presentation in 2014. Since then, the center has been dedicated to providing assistance to residents in Barangay Maricaban. With a focus on addressing the health needs of the local community, particularly those facing unemployment or minimal income, the center endeavors to improve the well-being of its residents.</p>
    </div>
    <div class="section owner">
        <img src="founder.jpg" alt="Sr. Rubyclare Pulickal">
        <div class="text">
            <h2>Owner Name</h2>
            <p>Sr. Rubyclare Pulickal</p>
        </div>
    </div>
    <div class="section">
        <p>This healthcare facility has offered free medical services to patients in need since 2001.</p>
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
</html>

