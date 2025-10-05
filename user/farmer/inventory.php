<?php
session_start();
include '../../config/db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ===== Orders Summary (dummy data for now) =====
$total_orders = 12;
$pending_orders = 5;
$completed_orders = 7;
$completed_preorders = 3;

// ===== Get farm expenses for suggestion =====
$expenseResult = $conn->query("SELECT SUM(cost) as total_cost FROM farm_inputs WHERE user_id = $user_id");
$rowExpense = $expenseResult->fetch_assoc();
$total_expenses = $rowExpense['total_cost'] ?? 0;

// Suggested price (dummy calculation)
$suggested_price = $total_expenses > 0 ? $total_expenses * 1.2 : 0;

// ===== Add Product =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $category = $_POST['category'];
    $name     = $_POST['name'];
    $planted_date = $_POST['planted_date'] ?? null;
    $harvest_date = $_POST['harvest_date'] ?? null;
    $price    = $_POST['price'];
    $stock    = $_POST['stock'];
    $status   = $_POST['status'] ?? 'available';
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image = time() . '_' . basename($_FILES['image']['name']); 
        $target = "../uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $stmt = $conn->prepare("INSERT INTO products (category, name, price, stock, image, user_id, planted_date, harvest_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisssss", $category, $name, $price, $stock, $image, $user_id, $planted_date, $harvest_date, $status);
    $stmt->execute();
    $stmt->close();

    header("Location: inventory.php");
    exit;
}

// ===== Edit Product =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id       = $_POST['id'];
    $category = $_POST['category'];
    $name     = $_POST['name'];
    $price    = $_POST['price'];
    $stock    = $_POST['stock'];
    $status   = $_POST['status'] ?? 'available';

    $stmt = $conn->prepare("UPDATE products SET category=?, name=?, price=?, stock=?, status=? WHERE product_id=?");
    $stmt->bind_param("ssdssi", $category, $name, $price, $stock, $status, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: inventory.php");
    exit;
}

// ===== Fetch Products =====
$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE user_id = ? AND (name LIKE ? OR category LIKE ?) ORDER BY product_id DESC");
    $likeSearch = "%$search%";
    $stmt->bind_param("iss", $user_id, $likeSearch, $likeSearch);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM products WHERE user_id = $user_id ORDER BY product_id DESC");
}

// ===== Include Sidebar =====
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory</title>
<link rel="stylesheet" href="../../css/farmer/farmers_dashboard.css?v=<?=time()?>">
<link rel="stylesheet" href="../../css/farmer/inventory.css?v=<?=time()?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="main-content">
    <h1> Inventory </h1>
  <!-- Summary Cards -->
  <div class="summary-cards">
      <div class="card total">Total Orders<h2><?= $total_orders ?></h2></div>
      <div class="card pending">Pending Orders <h2><?= $pending_orders ?></h2></div>
      <div class="card completed">Completed Orders <h2><?= $completed_orders ?></h2></div>
      <div class="card preorder">Total Pre-Orders<h2><?= $completed_preorders ?></h2></div>
  </div>

  <!-- Add Product Button -->
  <button class="add-btn" id="addBtn">+ Add Product</button>

  <!-- Products Table -->
  <table>
      <tr>
          <th>Product & Category</th>
          <th>Price</th>
          <th>Planted Date</th>
          <th>Harvest Date</th>
          <th>Status</th>
          <th>Action</th>
      </tr>
      <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                  <td><?= htmlspecialchars($row['name'])." (".htmlspecialchars($row['category']).")" ?></td>
                  <td>₱<?= number_format($row['price'], 2) ?></td>
                  <td><?= htmlspecialchars($row['planted_date'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['harvest_date'] ?? '') ?></td>
                  <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                  <td>
                     <a href="#" class="editBtn"
                        data-id="<?= $row['product_id'] ?>"
                        data-category="<?= htmlspecialchars($row['category']) ?>"
                        data-name="<?= htmlspecialchars($row['name']) ?>"
                        data-price="<?= $row['price'] ?>"
                        data-stock="<?= $row['stock'] ?>"
                        data-status="<?= $row['status'] ?>">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                  </td>
              </tr>
          <?php endwhile; ?>
      <?php else: ?>
          <tr><td colspan="6">No products added yet.</td></tr>
      <?php endif; ?>
  </table>
</div>

<!-- Add Product Modal -->
<div id="addModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeAdd">&times;</span>
    <h3>Add Product</h3>
    <form method="POST" enctype="multipart/form-data">
        <label>Category</label>
        <input type="text" name="category" required>

        <label>Product Name</label>
        <input type="text" name="name" required>

        <label>Planted Date</label>
        <input type="date" name="planted_date" required>

        <label>Harvest Date</label>
        <input type="date" name="harvest_date" required>

        <label>Suggested Price</label>
        <input type="number" value="<?= $suggested_price ?>" readonly>

        <label>Price</label>
        <input type="number" name="price" step="0.01" required>

        <label>Stock</label>
        <input type="number" name="stock" required>

        <label>Status</label>
        <select name="status">
            <option value="available">Available</option>
            <option value="preorder">Pre-Order</option>
        </select>

        <label>Image</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" name="add_product">Add</button>
    </form>
  </div>
</div>

<!-- Edit Product Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeEdit">&times;</span>
    <h3>Edit Product</h3>
    <form method="POST">
        <input type="hidden" name="id" id="editId">

        <label>Category</label>
        <input type="text" name="category" id="editCategory" required>

        <label>Product Name</label>
        <input type="text" name="name" id="editName" required>

        <label>Price</label>
        <input type="number" name="price" id="editPrice" step="0.01" required>

        <label>Stock</label>
        <input type="number" name="stock" id="editStock" required>

        <label>Status</label>
        <select name="status" id="editStatus">
            <option value="available">Available</option>
            <option value="preorder">Pre-Order</option>
        </select>

        <button type="submit" name="edit_product">Update</button>
    </form>
  </div>
</div>

<script>
// Add Modal
const addModal = document.getElementById("addModal");
document.getElementById("addBtn").onclick = () => addModal.style.display = "flex";
document.getElementById("closeAdd").onclick = () => addModal.style.display = "none";

// Edit Modal
const editModal = document.getElementById("editModal");
const closeEdit = document.getElementById("closeEdit");
document.querySelectorAll(".editBtn").forEach(btn => {
    btn.onclick = (e) => {
        e.preventDefault();
        document.getElementById("editId").value = btn.dataset.id;
        document.getElementById("editCategory").value = btn.dataset.category;
        document.getElementById("editName").value = btn.dataset.name;
        document.getElementById("editPrice").value = btn.dataset.price;
        document.getElementById("editStock").value = btn.dataset.stock;
        document.getElementById("editStatus").value = btn.dataset.status;
        editModal.style.display = "flex";
    };
});
closeEdit.onclick = () => editModal.style.display = "none";

// Close modals when clicking outside
window.onclick = (e) => {
  if (e.target === addModal) addModal.style.display = "none";
  if (e.target === editModal) editModal.style.display = "none";
};
</script>

</body>
</html>
