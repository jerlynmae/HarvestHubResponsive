<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get user info from session
$fullname = $_SESSION['fullname'] ?? 'User';
$role = $_SESSION['role'] ?? 'Farmer';

include '../config/db_connect.php';

// --- SAFE DEFAULTS
$total_sales    = 0.00; 
$total_orders   = 0;
$pending_orders = 0;
$result_top     = null; 

// --- TOTAL ORDERS
if ($result = $conn->query("SELECT COUNT(*) AS total_orders FROM orders")) {
    $row = $result->fetch_assoc();
    $total_orders = (int)($row['total_orders'] ?? 0);
    $result->free();
}

// --- PENDING ORDERS
if ($result = $conn->query("SELECT COUNT(*) AS pending_orders FROM orders WHERE status = 'pending'")) {
    $row = $result->fetch_assoc();
    $pending_orders = (int)($row['pending_orders'] ?? 0);
    $result->free();
}

// --- TOP PRODUCTS
$sql_top = "SELECT name, sold_quantity FROM products ORDER BY sold_quantity DESC LIMIT 5";
try {
    $tmp = $conn->query($sql_top);
    if ($tmp instanceof mysqli_result) {
        $result_top = $tmp;
    }
} catch (mysqli_sql_exception $e) {
    // fallback
}

include 'sidebar.php'; ?>
<link rel="stylesheet" href="sidebar.css?v=<?=time()?>"
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farmer Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/farmers_dashboard.css?v=<?= time() ?>"> 
</head>
<body>
 
  <!-- Overlay (mobile only) -->
  <div class="overlay" id="overlay"></div>

  <!-- Main Content -->
  <div class="main">
    <div class="notice">Notice: Your farm details are not set. Please complete it <a href="register_farm.php">here</a>.</div>

    <!-- Cards -->
    <div class="cards">
      <div class="card">
        <h3>Total Sales</h3>
        <p>₱<?php echo number_format($total_sales, 2); ?></p>
      </div>
      <div class="card">
        <h3>Total Orders</h3>
        <p><?php echo $total_orders; ?></p>
      </div>
      <div class="card">
        <h3>Pending Orders</h3>
        <p><?php echo $pending_orders; ?></p>
      </div>
    </div>

    <!-- Content -->
    <div class="content">
      <!-- Sales Chart Placeholder -->
      <div class="chart">
        <h3>Monthly Sales</h3>
        <img src="https://via.placeholder.com/600x300?text=Sales+Chart+Here" 
             alt="Chart Placeholder" style="width:100%; border-radius:6px;">
      </div>

      <!-- Top Products -->
      <div class="products">
        <h3>Top Products</h3>
        <table>
          <tr>
            <th>Rank</th>
            <th>Product</th>
            <th>Sold</th>
          </tr>
          <?php
          $rank = 1;
          if ($result_top instanceof mysqli_result && $result_top->num_rows > 0) {
            while ($row = $result_top->fetch_assoc()) {
              echo "<tr>
                      <td>".$rank."</td>
                      <td>".htmlspecialchars($row['name'])."</td>
                      <td>".(int)$row['sold_quantity']."</td>
                    </tr>";
              $rank++;
            }
          } else {
            echo "<tr><td colspan='3'>No products found</td></tr>";
          }
          ?>
        </table>
      </div>
    </div>
  </div>

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
</body>
</html>
