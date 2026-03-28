<?php
// DATABASE CONNECT (db.php wenuwata meka direct dapuwa)
$host = 'localhost';
$dbname = 'hotel';
$username = 'root';
$password = '';

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

$available = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $room = $_POST['room'];
  $checkin = $_POST['checkin'];
  $checkout = $_POST['checkout'];

  // 🔍 CHECK ROOM AVAILABILITY
  $stmt = $conn->prepare("SELECT * FROM bookings 
    WHERE room = ? 
    AND (
      (checkin <= ? AND checkout >= ?) OR
      (checkin <= ? AND checkout >= ?) OR
      (checkin >= ? AND checkout <= ?)
    )");

  $stmt->execute([$room, $checkin, $checkin, $checkout, $checkout, $checkin, $checkout]);

  if ($stmt->rowCount() > 0) {
    $available = false;
  } else {
    $available = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking | Rayal Park</title>
  <link rel="stylesheet" href="booking.css">
</head>
<body>

<!-- HEADER -->
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


<!-- FORM -->
<section class="booking">
   
  <form method="POST">
    <h3 class="heder_topic">Check Room Availability</h3>

    <select name="room" required>
      <option value="">Select Room</option>
      <option value="Deluxe Ocean View">Deluxe Ocean View</option>
      <option value="Executive Cityscape Room">Executive Cityscape Room</option>
      <option value="Family Garden Retreat">Family Garden Retreat</option>
    </select>

    <label>Check In</label>
    <input type="date" name="checkin" required>

    <label>Check Out</label>
    <input type="date" name="checkout" required>

    <button type="submit" class="btn">Check Availability</button>

  </form>

  <!-- RESULT -->
  <?php if($available !== null): ?>

    <?php if($available): ?>
      <div class="success">
        Room is Available ✅ <br><br>
        <button class="btn">Proceed to Booking</button>
      </div>
    <?php else: ?>
      <div class="error">
        Room Not Available ❌
      </div>
    <?php endif; ?>

  <?php endif; ?>

</section>

<!-- FOOTER -->
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