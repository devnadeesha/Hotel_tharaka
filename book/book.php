<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $room = $_POST['room'];
  $stay_type = $_POST['stay_type'];
  $checkin = $_POST['checkin'];
  $checkout = $_POST['checkout'];
  $guests = $_POST['guests'];
  $food = $_POST['food'];
  $drink = $_POST['drink'];
  $meal = $_POST['meal'] ?? '';

  // SAVE DB
  $stmt = $conn->prepare("INSERT INTO bookings (name, checkin, checkout, room) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $checkin, $checkout, $room]);

  // WHATSAPP MESSAGE
  $msg = "New Booking:\n"
       . "Name: $name\n"
       . "Phone: $phone\n"
       . "Room: $room\n"
       . "Stay Type: $stay_type\n "
       . "Guests: $guests\n"
       . "Checkin: $checkin\n"
       . "Checkout: $checkout\n"
       . "Food Type: $food\n"
       . "Meal: $meal\n"
       . "Drink: $drink";

  $owner = "94703466781";

  // URL encode message
  $encodedMsg = urlencode($msg);

  $whatsappLink = "https://wa.me/$owner?text=$encodedMsg";

  // redirect to whatsapp
  header("Location: $whatsappLink");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking | Rayal Park</title>
  <link rel="stylesheet" href="book.css">
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
    <div class="menu-toggle" onclick="toggleMenu()">
       ☰
    </div>
    <ul class="nav__links" id="links">
      <li><a href="../home/index.html">Home</a></li>
      <li><a href="../about/about.htmlabout.html">About</a></li>
      <li><a href="../service/service.htmlservice.html">Services</a></li>
      <li><a href="../explore.html">Explore</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
  </nav>
  
</header>

<section class="booking__section">

  <div class="booking__container">

    <h2 class="section__header">Book Your Stay</h2>
    <p class="section__description">Check availability and customize your experience</p>

    <form method="POST" class="booking__form">
      
       <!-- NAME -->
      <div class="form__group">
        <label>Your Name</label>
        <input type="text" name="name" placeholder="Enter your name" required>
      </div>

      <!-- PHONE -->
      <div class="form__group">
        <label>Phone Number</label>
        <input type="text" name="phone" placeholder="07XXXXXXXX" required>
      </div>

      <!-- DATES -->
      <div class="form__group">
        <label>Check In</label>
        <input type="date" name="checkin" required>
      </div>

      <div class="form__group">
        <label>Check Out</label>
        <input type="date" name="checkout" required>
      </div>

      <!-- GUESTS -->
      <div class="form__group">
        <label>Guests</label>
         <select name="guests" required>
          <option value="1">01</option>
          <option value="2">02</option>
          <option value="3">03</option>
          <option value="4">04</option>
        </select>
      </div>

      <!-- ROOM -->
      <div class="form__group">
        <label>Room Type</label>
        <select name="room" required>
          <option value="">Select Room</option>
          <option value="No Room">No Room</option>
          <option value="Deluxe Ocean View">Deluxe Ocean View</option>
          <option value="Executive Cityscape Room">Executive Cityscape Room</option>
          <option value="Family Garden Retreat">Family Garden Retreat</option>
        </select>
      </div>
       <!-- Stay type -->
      <div class="form__group">
        <label>Stay Type</label>
        <select name="stay_type" required>
            <option value="">Select Type</option>
            <option value="Full Day">Full Day</option>
            <option value="Day Use">Day Use</option>
            <option value="Night Stay">Night Stay</option>
        </select>
       </div>

      <!-- FOOD -->
      <div class="form__group">
        <label>Food Package</label>
        <select name="food">
          <option value="Breakfast Only">Breakfast Only</option>
          <option value="Half Board">Half Board</option>
          <option value="Full Board">Full Board</option>
        </select>
      </div>
      <!-- Meal -->
      <div class="form__group">
        <label>Meal</label>
        <select name="meal">
          <option value="Fied Rice">Fied Rice</option>
          <option value="Rice & Curry">Rice & Curry</option>
          <option value="Kottu">Kottu</option>
          <option value="Noodless">Noodless</option>
          <option value="Vegetables Soup">Vegetables Soup</option>
          <option value="Chicken Soup">Chicken Soup</option>
        </select>
      </div>

      <!-- DRINK -->
      <div class="form__group">
        <label>Welcome Drink</label>
        <select name="drink">
          <option value="Orange Juice">Orange Juice</option>
          <option value="Ice Coffee">Ice Coffee</option>
          <option value="Cocount Water">Cocount Water</option>
        </select>
      </div>

      

     

      <!-- BUTTON -->
      <button type="submit" class="btn booking__btn">Book Now</button>

      <!-- WHATSAPP LINK -->
     
    </form>

    <!-- RESULT -->
    <?php if($available !== null): ?>
      <?php if($available): ?>
        <div class="booking__success">
          ✅ Room Available! You can proceed booking.
        </div>
      <?php else: ?>
        <div class="booking__error">
          ❌ Room Not Available
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </div>

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
    <script>
        function toggleMenu() {
            document.getElementById("links").classList.toggle("active");
        }
    </script>

</body>
</html>