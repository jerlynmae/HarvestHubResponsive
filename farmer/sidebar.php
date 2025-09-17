<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get user info from session
$fullname = $_SESSION['fullname'] ?? 'User';
$role = $_SESSION['role'] ?? 'Farmer';
?>

  <div class="topbar">
    <div class="logo">
      <img src="../img/harvesthub_logo.png" alt="Logo">
    </div>

    <!-- Hamburger Menu (mobile only) -->
    <button class="menu-button" id="menuBtn">☰</button>

    <div class="profile">
      <div class="avatar"></div>
      <div class="profile-info">
        <span class="name"><?= htmlspecialchars($fullname) ?></span>
        <span class="role"><?= htmlspecialchars($role) ?></span>
      </div>
      <span class="dropdown">▼</span>
    </div>
  </div>

  <!--  Sidebar -->
  <div class="sidebar" id="sidebar">
     <ul>
        <li><a href="farmer_dashboard.php" class="active"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="farminput.php"><i class="fas fa-seedling"></i> Farm Inputs</a></li>
        <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
        <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="help.php"><i class="fas fa-question-circle"></i> Help & Support</a></li>
        <li class="logout"> <a href="../logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>


<!-- Overlay (mobile) -->
<div class="overlay" id="overlay"></div>

<!-- Menu toggle script -->
<script>
const menuBtn = document.getElementById("menuBtn");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");

menuBtn.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
});

overlay.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
});
</script>
