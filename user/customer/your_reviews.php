<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Reviews</title>
  <link rel="stylesheet" href="../../css/customer/your_review.css?v=<?=time()?>">
</head>
<body>

  <!-- Sidebar include -->
  <?php include 'customer_sidebar.php'; ?>

  <!-- Overlay (for mobile sidebar toggle) -->
  <div class="overlay"></div>

  <!-- Topbar -->
  <header class="topbar">
    <button class="menu-button" id="menu-toggle">&#9776;</button>
    <a href="purchases.php" class="back-btn">← Back</a>
    <h2>My Reviews</h2>
  </header>

  <!-- Main Content -->
  <div class="main">
    <!-- Page Header -->
    <section class="reviews-banner">
      <h1>My Reviews</h1>
      <p class="subtitle">All the feedback you’ve shared on your orders.</p>
    </section>

    <!-- Reviews List -->
    <section class="reviews-list">
      <!-- Example of a review item -->
      <article class="review-item">
        <div class="review-header">
          <img src="product1.jpg" alt="Product" class="product-img">
          <div>
            <h3 class="product-name">Fresh Organic Tomatoes</h3>
            <div class="stars">★★★★★</div>
            <span class="date">Reviewed on Sept 12, 2025</span>
          </div>
        </div>
        <p class="review-text">
          These tomatoes were incredibly fresh and sweet. Highly recommended!
        </p>
      </article>

      <article class="review-item">
        <div class="review-header">
          <img src="product2.jpg" alt="Product" class="product-img">
          <div>
            <h3 class="product-name">Free-Range Eggs</h3>
            <div class="stars">★★★★☆</div>
            <span class="date">Reviewed on Aug 30, 2025</span>
          </div>
        </div>
        <p class="review-text">
          Eggs were good quality. Delivery was a bit late but still worth it.
        </p>
      </article>

      <!-- Repeat <article> blocks for each review fetched from backend -->
    </section>
  </div>

  <!-- Optional JS for sidebar toggle -->
  <script>
    const menuBtn = document.getElementById('menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.overlay');

    menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
    });
  </script>
</body>
</html>
