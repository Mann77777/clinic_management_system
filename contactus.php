<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <!-- Google Font for Navbar Brand -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;700&display=swap" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="services.css"> <!-- Using the same styles as services.css for consistency -->
  <link rel="stylesheet" href="contactus.css"> <!-- Custom styles for contact page -->
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

<main>
  <section id="contact" class="contact-section">
    <h2>Contact Us</h2>
    <p>If you have any questions, feel free to reach out to us. We are here to help!</p>

    <div class="contact-details">
      <div class="contact-item">
        <i class="fas fa-envelope"></i>
        <div>
          <strong>Email:</strong>
          <p>mpcc@gmail.com</p>
        </div>
      </div>
      <div class="contact-item">
        <i class="fas fa-phone-alt"></i>
        <div>
          <strong>Phone:</strong>
          <p>(+63) 945-316-9346</p>
        </div>
      </div>
    </div>

    <h2 class="feedback-heading">Feedback</h2>
    <p>We value your feedback. Let us know how we can improve.</p>
    
    <form id="feedbackForm">
      <label for="feedbackEmail"><i class="fas fa-envelope"></i> <strong> Email:</strong></label>
      <input type="email" id="feedbackEmail" name="feedbackEmail" placeholder="Your email" required>

      <label for="feedbackMessage"><i class="fas fa-comment"></i> <strong> Message:</strong></label>
      <textarea id="feedbackMessage" name="feedbackMessage" rows="4" placeholder="Your feedback" required></textarea>

      <button type="submit" class="submit-btn">Submit Feedback</button>
    </form>

    <p id="thankYouMessage" class="thank-you-message" style="display:none;">Thank you for your feedback!</p>
  </section>
</main>


<script>
  document.getElementById('feedbackForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var email = document.getElementById('feedbackEmail').value;
    var message = document.getElementById('feedbackMessage').value;
    if (email && message) {
      document.getElementById('thankYouMessage').style.display = 'block';
      document.getElementById('feedbackForm').reset();
    }
  });

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
