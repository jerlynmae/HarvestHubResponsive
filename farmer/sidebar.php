<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get user info from session
$fullname = $_SESSION['fullname'] ?? 'User';
$role = $_SESSION['role'] ?? 'Farmer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Farm Inputs</title>
<link rel="stylesheet" href="../css/sidebar.css?v=<?= time() ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

  <div class="topbar">
    <div class="search-filter">
      <input id="search" type="search" placeholder="Search..." />
    </div>
  </div>
<!-- MENUUU-->
<button id="menuBtn" class="menu-button">
    <i class="fas fa-bars"></i>
</button>


<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <!-- Top Profile -->
    <div class="sidebar-top">
 <div class="profile">
        <img src="../img/avatar.png" alt="Profile Picture" class="avatar">
        <div class="profile-info">
          <span class="name"><?= htmlspecialchars($fullname) ?></span>
        </div>
      </div>
    </div>

    <!-- Navigation Links -->
    <ul class="nav-links">
        <li><a href="farmer_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="farminput.php"><i class="fas fa-seedling"></i> Farm Inputs</a></li>
        <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
        <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="help.php"><i class="fas fa-question-circle"></i> Help & Support</a></li>
    </ul>

    <!-- Bottom Logo -->
    <div class="sidebar-bottom">
        <div class="logo">Harvest Hub</div>
    </div>
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
