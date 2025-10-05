<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../../css/customer/customer_sidebar.css?v=<?= time() ?>">
<title>Sidebar</title>
</head>
<body>

  <div class="topbar">
    <a href="customer_page.php" class="back-btn">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
  </div>

<!-- MENU BUTTON -->
<button class="menu-button">&#9776;</button>

<!-- OVERLAY -->
<div class="overlay"></div>

<!-- SIDEBAR -->
<div class="sidebar">
  <div>
    <div class="profile">
      <img src="https://via.placeholder.com/70" alt="Profile">
      <h3>
  <a href="profile.php" style="text-decoration: none; color: inherit;">
    Sadiwa, Jessieca
    <i class="fa-solid fa-pen-to-square" style="font-size:14px; margin-left:8px; color:#27ae60;"></i>
  </a>
</h3>

    </div>
    <nav class="nav">
      <ul>
        <li><a href="profile.php"><i class="fa-solid fa-user"></i> My Profile</a></li>
        <li><a href="preorder.php"><i class="fas fa-calendar-alt"></i> Pre-Orders</a></li>
        <li><a href="purchases.php" class="active"><i class="fa-solid fa-bag-shopping"></i> My Purchases</a></li>
        <li><a href="#"><a href="#"> <i class="fas fa-message"></i> Message</a></li>
        <li><a href="your_reviews.php"><i class="fa-solid fa-star"></i> Your Reviews</a></li>
        <li><a href="#"><a href="#"><i class="fas fa-question-circle"></i> Help & Support</a></li>
        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>
      </ul>
    </nav>
  </div>
</div>

<!-- JS TOGGLE SIDEBAR -->
<script>
const menuButton = document.querySelector('.menu-button');
const sidebar = document.querySelector('.sidebar');
const overlay = document.querySelector('.overlay');

menuButton.addEventListener('click', () => {
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
