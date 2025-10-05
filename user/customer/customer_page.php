<?php
session_start();
// Database connection
include "../../config/db_connect.php";

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HarvestHub - Fresh Goods</title>
  <link rel="stylesheet" href="../../css/customer/customer_page.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- NAV -->
  <header class="nav-wrap">
    <div class="container nav">
      <div class="brand">HarvestHub</div>
      <div class="search-filter">
        <input id="search" type="search" placeholder="Search products..." />
        <select id="category" name="category" class="category">
          <option value="all">All categories</option>
          <option value="vegetables">High Valued Products</option>
          <option value="fruits">Fruits</option>
        </select>
      </div>
      <button class="nav-toggle" id="navToggle"><i class="fas fa-bars"></i></button>
      <nav class="nav-links">
        <a href="purchases.php">My Purchase </a>
        <a href="#">Help & Support</a>
        <a href="cart.php" id="cartBtn" class="cart">
          <i class="fas fa-shopping-cart"></i>
          <span id="cart-count">
            <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
          </span>
        </a>
        <a href="#"><i class="fas fa-comment-dots"></i></a>
        <a href="profile.php"><i class="fas fa-user"></i></a>
      </nav>
    </div>
  </header>
<!-- Sidebar Drawer -->


<div class="sidebar" id="sidebar">
    <div class="profile">
      <img src="https://via.placeholder.com/70" alt="Profile">
          </div>
      <h3>
        <a href="profile.php" style="text-decoration:none;color:inherit;">
          Sadiwa, Jessieca
          <i class="fa-solid fa-pen-to-square" style="font-size:14px;margin-left:8px;color:#27ae60;"></i>
        </a>
      </h3>
  <span class="sidebar-close" id="sidebarClose">&times;</span>

  <a href="profile.php"> <i class="fas fa-user"></i> My Profile</a>
  <a href="#"><i class="fas fa-calendar-alt"></i> Pre-Orders</a>
  <a href="purchases.php"><i class="fas fa-shopping-bag"></i> My Purchase</a>
  <a href="#"> <i class="fas fa-message"></i> Message</a>
   <a href="#"><i class="fas fa-question-circle"></i> Help & Support</a>
</div>

<!-- Add this in your <head> if Font Awesome is not included yet -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

  <!-- Banners -->
  <div class="swiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide"><img src="../img/banner1.png" alt="banner1"></div>
      <div class="swiper-slide"><img src="../img/banner2.png" alt="banner2"></div>
      <div class="swiper-slide"><img src="../img/banner3.png" alt="banner3"></div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
  
  <!-- PRODUCTS -->
  <section id="shop" class="container" style="padding:20px;">
    <h2 style="margin:20px 0; color:#16a085;">Available Products</h2>
    <div class="products-grid">
      <?php
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
      <div class="card">
        <!-- Product Image -->
        <img src="../img/<?php echo htmlspecialchars($row['image']); ?>" 
             alt="<?php echo htmlspecialchars($row['name']); ?>">

        <!-- Action Icons -->
        <div class="card-actions">
          <button class="icon-btn"><i class="fa fa-clock"></i></button>
          <button class="icon-btn"><i class="fa fa-envelope"></i></button>
        </div>

        <!-- Product Info -->
        <div class="card-content">
          <h3><?php echo htmlspecialchars($row['name']); ?></h3>
          <p class="stocks">Stocks: <?php echo (int)$row['stock']; ?></p>
          <div class="price-row">
            <span class="price">₱<?php echo number_format($row['price'], 2); ?></span>
            <!-- AJAX Form -->
            <form method="post" action="cart_handler.php" class="add-to-cart-form">
              <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
              <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
              <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
              <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="btn add-to-cart">Add to Cart</button>
            </form>
          </div>
        </div>
      </div>
      <?php
        }
      } else {
        echo "<p style='text-align:center;'>No products available.</p>";
      }
      ?>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <p>&copy; <span id="year"></span> HarvestHub. All rights reserved.</p>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms</a>
      <a href="#">Contact</a>
    </div>
  </footer>

  <script>
  // AJAX Add to Cart
  document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e){
      e.preventDefault();

      const formData = new FormData(this);

      fetch(this.action, {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Update cart badge
          document.getElementById('cart-count').textContent = data.cart_count;
          // Show toast
          showToast(data.message);
        } else {
          showToast("Error adding to cart");
        }
      })
      .catch(err => {
        console.error(err);
        showToast("Something went wrong!");
      });
    });
  });

  function showToast(msg) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerText = msg;
    document.body.appendChild(toast);
    setTimeout(()=>{ toast.classList.add('show'); }, 100);
    setTimeout(()=>{ toast.classList.remove('show'); toast.remove(); }, 3000);
  }

  // Sidebar toggle
  const navToggle=document.getElementById('navToggle');
  const sidebar=document.getElementById('sidebar');
  const sidebarClose=document.getElementById('sidebarClose');
  navToggle.addEventListener('click',()=>{ sidebar.classList.add('active'); });
  sidebarClose.addEventListener('click',()=>{ sidebar.classList.remove('active'); });

  document.getElementById('year').textContent=new Date().getFullYear();

  const swiper = new Swiper('.swiper', {
    loop:true,
    autoplay:{ delay:4000 },
    pagination:{ el:'.swiper-pagination', clickable:true },
    navigation:{ nextEl:'.swiper-button-next', prevEl:'.swiper-button-prev' },
  });
  </script>
</body>
</html>
