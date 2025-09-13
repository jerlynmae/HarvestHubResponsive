<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HarvestHub - Fresh Goods</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- NAVBAR -->
  <div class="navbar">
    <div class="logo"> HarvestHub</div>
    <div class="search-bar">
      <input type="text" placeholder="Search Products">
    </div>
    <div class="nav-links">
      <a href="#">Cart</a>
      <a href="#">Profile</a>
      <button onclick="window.location.href='login.php'" class="btn-login" >Log In</button>
      <button onclick="window.location.href='createaccount.php'" class="btn-signup">Sign Up</button>
      <button class="menu-toggle" id="menuBtn">☰</button>
    </div>
  </div>

  <!-- OVERLAY -->
  <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

    <!-- Dropdown Menu -->
  <div class="dropdown" id="dropdownMenu">
    <a href="farmer/farmer_signup.php">Sell your Harvest?</a>
    <a href="#products">Products</a>
    <a href="#">Help and Support</a>
    <a href="#">Contact Us</a>
  </div>

  <!-- HERO -->
<div class="hero" id="products">
    <div class="slides" id="slides">
      <div class="slide" style="background:#e6ffe6;">
        <div class="hero-text">
          <h1>Fresh Goods</h1>
          <p>Order Now and support our local farmers!</p>
          <button onclick="window.location.href='login.php'">Shop Now</button>
        </div>
      </div>
      <div class="slide" style="background:#fff3e6;">
        <div class="hero-text">
          <h1>High Valued Crops</h1>
          <p>Best quality crops directly from farmers</p>
          <button onclick="window.location.href='login.php'">Shop Now</button>
        </div>
      </div>
      <div class="slide" style="background:#e6f7ff;">
        <div class="hero-text">
          <h1>Support Local</h1>
          <p>Buy fresh, healthy, and sustainable food</p>
          <button onclick="window.location.href='login.php'">Shop Now</button>
        </div>
      </div>
    </div>
    <div class="dots" id="dots">
      <div class="dot active"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </div>

  <!-- PRODUCTS -->
  <div class="section">
    <h2>Grab the Best Deal on Products</h2>
    <div class="products">
      <div class="product-card">
        <img src="vege.jpg" alt="Apple">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Apple</h3>
          <p>Fruit</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.8 | 1,238 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button onclick="window.location.href='login.php'">Find Similar</button>
          <button onclick="window.location.href='login.php'">Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
      <div class="product-card">
        <img src="vege.jpg" alt="Potato">
        <div class="hover-options">
          <button>Find Similar</button>
          <button>Want to Buy?</button>
        </div>
        <div class="product-info">
          <h3>Potato</h3>
          <p>Vegetable</p>
          <p class="price">₱200.00</p>
          <p class="rating">⭐ 4.6 | 980 Sold</p>
          <p class="bulk">Bulk Available: 100 Sacks</p>
        </div>
      </div>
    </div>
  </div>

<!-- ABOUT SECTION -->
  <div class="about-section">
    <h2>About HarvestHub</h2>
    <p>
      HarvestHub is an online marketplace connecting farmers directly with customers. 
      Our goal is to support local farmers by giving them a platform to showcase 
      their fresh produce, while also giving customers access to healthy and affordable food.  
      We believe in sustainability, fair trade, and building stronger communities through agriculture.
    </p>
  </div>

  <!-- FOOTER -->
  <footer>
    <div>
      <h4>Explore</h4>
      <ul>
        <li>Home</li>
        <li>About Us</li>
        <li>Services</li>
      </ul>
    </div>
    <div>
      <h4>Customer Services</h4>
      <ul>
        <li>Online Payment & COD</li>
        <li>Order Tracking</li>
        <li>Help Center</li>
      </ul>
    </div>
    <div>
      <h4>Resources</h4>
      <ul>
        <li>Best Practices</li>
        <li>Support</li>
        <li>Developers</li>
      </ul>
    </div>
  </footer>

  <!-- JAVASCRIPT -->
  <script>
        let index = 0;
    const slides = document.getElementById("slides");
    const dots = document.querySelectorAll(".dot");

    function showSlide(i) {
      index = i;
      slides.style.transform = `translateX(-${i * 100}%)`;
      dots.forEach((dot, d) => {
        dot.classList.toggle("active", d === i);
      });
    }

    function nextSlide() {
      index = (index + 1) % dots.length;
      showSlide(index);
    }

    setInterval(nextSlide, 4000);

    dots.forEach((dot, i) => {
      dot.addEventListener("click", () => showSlide(i));
    });
  
    const menuBtn = document.getElementById("menuBtn");
    const dropdownMenu = document.getElementById("dropdownMenu");

    menuBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdownMenu.classList.toggle("show");
    });

    // Auto-hide kapag nag-click sa labas
    document.addEventListener("click", (e) => {
      if (!dropdownMenu.contains(e.target) && !menuBtn.contains(e.target)) {
        dropdownMenu.classList.remove("show");
      }
    });
  </script>

</body>
</html>
