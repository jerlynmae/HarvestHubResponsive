<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HarvestHub - Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f9f9f9;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ==== DASHBOARD LAYOUT ==== */
    .dashboard {
      display: grid;
      grid-template-columns: 240px 1fr;
      gap: 20px;
      padding: 30px 5%;
    }

    /* ==== SIDEBAR ==== */
    .sidebar {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      height: fit-content;
    }
    .sidebar h3 {
      font-size: 16px;
      margin-bottom: 18px;
      color: #2c7a2c;
    }
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 8px;
      font-size: 14px;
      color: #333;
      margin-bottom: 8px;
      transition: 0.3s;
      text-decoration: none;
    }
    .sidebar a i {
      width: 18px;
      text-align: center;
      color: #2c7a2c;
    }
    .sidebar a:hover, .sidebar a.active {
      background: #e6f7e6;
      color: #2c7a2c;
      font-weight: 500;
    }

    /* ==== MAIN CONTENT ==== */
    .main {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* ==== SEARCH BAR ==== */
    .order-search {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 15px;
    }
    .order-search input {
      width: 280px;
      padding: 8px 14px;
      border: 1px solid #ccc;
      border-radius: 20px;
      outline: none;
      transition: 0.2s;
    }
    .order-search input:focus {
      border-color: #2c7a2c;
      box-shadow: 0 0 6px rgba(44,122,44,0.3);
    }

    /* ==== ORDER TABS ==== */
    .order-tabs {
      display: flex;
      gap: 20px;
      border-bottom: 2px solid #f0f0f0;
      margin-bottom: 20px;
    }
    .order-tabs button {
      background: none;
      border: none;
      padding: 12px 0;
      font-size: 15px;
      cursor: pointer;
      position: relative;
      color: #555;
    }
    .order-tabs button.active {
      font-weight: 600;
      color: #2c7a2c;
    }
    .order-tabs button.active::after {
      content: "";
      position: absolute;
      bottom: -2px;
      left: 0;
      right: 0;
      height: 3px;
      background: #2c7a2c;
      border-radius: 2px;
    }

    /* ==== ORDER CARD ==== */
    .order-card {
      border: 1px solid #eee;
      border-radius: 10px;
      margin-bottom: 16px;
      padding: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: box-shadow 0.3s;
    }
    .order-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .order-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .order-card img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 8px;
    }
    .order-details p {
      margin: 4px 0;
      font-size: 14px;
    }
    .order-status {
      font-weight: bold;
      color: #2c7a2c;
      font-size: 13px;
    }
    .btn {
      background: #2c7a2c;
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 20px;
      cursor: pointer;
      font-size: 13px;
      transition: 0.3s;
    }
    .btn:hover {
      background: #256025;
    }

    /* ==== RESPONSIVE ==== */
    @media (max-width: 992px) {
      .dashboard {
        grid-template-columns: 1fr;
      }
      .sidebar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
      }
      .sidebar a {
        flex: 1 1 calc(50% - 10px);
      }
      .order-search {
        justify-content: center;
      }
      .order-search input {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <!-- NAVBAR -->
  <div class="navbar">
    <div class="logo">HarvestHub</div>
    <div class="search-bar">
      <input type="text" placeholder="Search Products">
    </div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="#">Cart</a>
      <a href="#">Logout</a>
    </div>
  </div>

  <!-- DASHBOARD -->
  <div class="dashboard">
    <!-- SIDEBAR -->
    <div class="sidebar">
      <h3>My Account</h3>
      <a href="#" class="active"><i class="fa-solid fa-box"></i> My Orders</a>
      <a href="#"><i class="fa-solid fa-heart"></i> Wishlist</a>
      <a href="#"><i class="fa-solid fa-house"></i> Addresses</a>
      <a href="#"><i class="fa-solid fa-credit-card"></i> Payments</a>
      <a href="#"><i class="fa-solid fa-cog"></i> Settings</a>
      <a href="#"><i class="fa-solid fa-circle-question"></i> Help Center</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
      <!-- ORDER SEARCH BAR -->
      <div class="order-search">
        <input type="text" placeholder="🔍 Search your orders...">
      </div>

      <!-- ORDER TABS -->
      <div class="order-tabs">
        <button class="active">All</button>
        <button>To Pay</button>
        <button>To Ship</button>
        <button>To Receive</button>
        <button>Completed</button>
      </div>

      <!-- ORDER CARDS -->
      <div class="order-card">
        <div class="order-info">
          <img src="vege.jpg" alt="Apple">
          <div class="order-details">
            <p><strong>Apple (5kg)</strong></p>
            <p>₱1,000</p>
            <p class="order-status">Shipped</p>
          </div>
        </div>
        <button class="btn">Track Order</button>
      </div>

      <div class="order-card">
        <div class="order-info">
          <img src="vege.jpg" alt="Potato">
          <div class="order-details">
            <p><strong>Potato (10kg)</strong></p>
            <p>₱1,200</p>
            <p class="order-status">To Receive</p>
          </div>
        </div>
        <button class="btn">Confirm Receipt</button>
      </div>
    </div>
  </div>
</body>
</html>
