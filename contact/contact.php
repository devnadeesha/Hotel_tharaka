<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'hotel'; // ⚠️ change to your DB name
$username = 'root';
$password = '';

$errors = [];
$success = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // ✅ Validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // ✅ Insert if no errors
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);

            $success ="Massage sent successfully";

            // Clear form
            $_POST = [];

        } catch(PDOException $e) {
            $errors[] = "Database error. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet"/>
  <link rel="stylesheet" href="contact.css" />
  <title>Contact | Rayal Park</title>
</head>

<body>

<header class="header">
  <nav>
    <div class="nav__bar">
      <div class="logo">
        <a href="#"><img src="assets/logo.png" alt="logo" /></a>
      </div>
    </div>

    <ul class="nav__links">
      <li><a href="../home/index.html">Home</a></li>
      <li><a href="../about/about.htmlabout.html">About</a></li>
      <li><a href="../service/service.htmlservice.html">Services</a></li>
      <li><a href="../explore.html">Explore</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
  </nav>
</header>

<section class="contact" id="contact">
  <div class="section__container contact__container">

    <div class="contact__info">
      <h2>Contact Us</h2>
      <p>We are here to help you. Reach out anytime.</p>

      <div class="contact__details">
        <p><i class="ri-mail-line"></i> rayalpark@info.com</p>
        <p><i class="ri-phone-line"></i> +94 77 123 4567</p>
        <p><i class="ri-map-pin-line"></i> Negombo, Sri Lanka</p>
      </div>
    </div>

    <div class="contact__form">

      <!-- SUCCESS MESSAGE -->
      <?php if (!empty($errors)): ?>
    <div style="color:red;">
        <?php foreach ($errors as $error): ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;">
            <p><?php echo $success; ?></p>
        </div>
    <?php endif; ?>

      <!-- FORM -->
      <form method="POST" action="contact.php">

        <div class="form__group">
          <input type="text" name="name" placeholder="Your Name" required />
        </div>

        <div class="form__group">
          <input type="email" name="email" placeholder="Your Email" required />
        </div>

        <div class="form__group">
          <input type="text" name="subject" placeholder="Subject" />
        </div>

        <div class="form__group">
          <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn">Send Message</button>


      </form>
    </div>

  </div>

  <!-- MAP -->
  <div class="contact__map">
    <iframe
      src="https://www.google.com/maps?q=Udugalakanda,Sri%20Lanka&output=embed"
      width="100%"
      height="300"
      style="border:0;"
      allowfullscreen=""
      loading="lazy">
    </iframe>
  </div>

</section>
 <footer class="footer" id="contact">
      <div class="section__container footer__container">
        <div class="footer__col">
          <div class="logo">
            <a href="#home"><img src="assets/logo.png" alt="logo" /></a>
          </div>
          <p class="section__description">
            Discover a world of comfort, luxury, and adventure as you explore
            our curated selection of hotels, making every moment of your getaway
            truly extraordinary.
          </p>
          <button class="btn">Book Now</button>
        </div>
        <div class="footer__col">
          <h4>QUICK LINKS</h4>
          <ul class="footer__links">
            <li><a href="#">Browse Destinations</a></li>
            <li><a href="#">Special Offers & Packages</a></li>
            <li><a href="#">Room Types & Amenities</a></li>
            <li><a href="#">Customer Reviews & Ratings</a></li>
            <li><a href="#">Travel Tips & Guides</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>OUR SERVICES</h4>
          <ul class="footer__links">
            <li><a href="#">Concierge Assistance</a></li>
            <li><a href="#">Flexible Booking Options</a></li>
            <li><a href="#">Airport Transfers</a></li>
            <li><a href="#">Wellness & Recreation</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>CONTACT US</h4>
          <ul class="footer__links">
            <li><a href="#">tharaka@info.com</a></li>
          </ul>
          <div class="footer__socials">
            <a href="#"><img src="assets/facebook.png" alt="facebook" /></a>
            <a href="#"><img src="assets/instagram.png" alt="instagram" /></a>
            <a href="#"><img src="assets/youtube.png" alt="youtube" /></a>
            <a href="#"><img src="assets/twitter.png" alt="twitter" /></a>
          </div>
        </div>
      </div>
      <div class="footer__bar">
        Copyright © 2026 ViaDesign. All rights reserved.
      </div>
    </footer>

</body>
</html>