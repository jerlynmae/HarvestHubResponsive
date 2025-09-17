<?php
session_start();
include "../config/db_connect.php";

// Initialize cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle quantity update and removal
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['update_qty'])) {
        $id = $_POST['id'];
        $action = $_POST['action'];

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $id) {
                if ($action === "plus") $item['quantity']++;
                elseif ($action === "minus" && $item['quantity'] > 1) $item['quantity']--;
                break;
            }
        }
        unset($item);
    }

    if (isset($_POST['remove_item'])) {
        $id = $_POST['id'];
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart - HarvestHub</title>
<link rel="stylesheet" href="../css/cart.css?v=<?=time()?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* Mobile Responsive Cart - vertical stacking */
@media (max-width: 768px) {
  .cart-container {
    display: flex !important;
    flex-direction: column !important;
    gap: 20px !important;
  }
  .cart-items { order: 1 !important; width: 100% !important; }
  .order-summary { order: 2 !important; width: 100% !important; }
  .cart-items table {
    display: block !important;
    width: 100% !important;
    overflow-x: auto !important;
    border-collapse: collapse !important;
  }
  .cart-items table th, .cart-items table td {
    font-size: 14px !important;
    padding: 8px !important;
    white-space: nowrap !important;
  }
}
/* Remove button style */
.remove-btn {
  background: #ff4d4f;
  border: none;
  color: #fff;
  padding: 4px 8px;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s;
}
.remove-btn:hover { background: #e60000; }
/* Back button & header */
.cart-header {
  display: flex;
  align-items: center;
  gap: 12px;
  background-color: white;
  height: 50px;
  margin-bottom: 20px;
  padding: 0 10px;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.back-btn {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  color: #333;
  text-decoration: none;
}

/* Confirmation modal styles */
.confirm-modal {
  display: none;
  position: fixed;
  top:0; left:0;
  width: 100%; height:100%;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.confirm-content {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  text-align: center;
  max-width: 320px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}
.confirm-buttons {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
  gap: 10px;
}
.confirm-yes, .confirm-no {
  padding: 8px 16px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  font-weight: 600;
}
.confirm-yes { background: #004d2c; color: #fff; }
.confirm-no { background: #ff4d4f; color: #fff; }
</style>
</head>
<body>

<!-- Header with Back Button -->
<div class="cart-header">
  <a href="customer_page.php" class="back-btn"><i class="fas fa-arrow-left"></i></a>
  <h2>My Cart</h2>
</div>

<?php if (!empty($_SESSION['cart'])): ?>
<div class="cart-container">

  <!-- Cart Items -->
  <div class="cart-items">
    <table>
      <tr>
        <th><input type="checkbox"></th>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
      </tr>
      <?php 
      $grand_total = 0;
      foreach ($_SESSION['cart'] as $item): 
        $total = $item['product_price'] * $item['quantity'];
        $grand_total += $total;
      ?>
      <tr>
        <td><input type="checkbox" checked></td>
        <td><img src="../img/<?php echo $item['product_image']; ?>" width="60"></td>
        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
        <td>₱<?php echo number_format($item['product_price'], 2); ?></td>
        <td>
          <div class="qty-container">
            <form method="post" style="display:inline;">
              <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
              <input type="hidden" name="action" value="minus">
              <button type="submit" name="update_qty" class="qty-btn"><i class="fas fa-minus"></i></button>
            </form>

            <span class="qty-number"><?php echo $item['quantity']; ?></span>

            <form method="post" style="display:inline;">
              <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
              <input type="hidden" name="action" value="plus">
              <button type="submit" name="update_qty" class="qty-btn"><i class="fas fa-plus"></i></button>
            </form>
          </div>
        </td>
        <td>₱<?php echo number_format($total, 2); ?></td>
        <td>
          <form method="post" class="remove-form">
            <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
            <button type="button" class="remove-btn"><i class="fas fa-trash"></i></button>
            <input type="hidden" name="remove_item" value="1">
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <!-- Order Summary -->
  <div class="order-summary">
    <h3>Order Summary</h3>
    <p><span>Items total</span> <span>₱<?php echo number_format($grand_total, 2); ?></span></p>
    <p><span>Delivery fee</span> <span>₱50.00</span></p>
    <p class="subtotal"><span>Subtotal</span> <span>₱<?php echo number_format($grand_total + 50, 2); ?></span></p>
    <button class="checkout-btn"><i class="fas fa-credit-card"></i> Checkout</button>
  </div>

</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="confirm-modal">
  <div class="confirm-content">
    <p>Are you sure you want to remove this product?</p>
    <div class="confirm-buttons">
      <button id="confirmYes" class="confirm-yes">Yes</button>
      <button id="confirmNo" class="confirm-no">No</button>
    </div>
  </div>
</div>

<?php else: ?>
  <p>Your cart is empty.</p>
<?php endif; ?>

<script>
let currentForm = null;

// Show modal when remove button is clicked
document.querySelectorAll('.remove-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    currentForm = this.closest('.remove-form');
    document.getElementById('confirmModal').style.display = 'flex';
  });
});

// Confirm removal
document.getElementById('confirmYes').addEventListener('click', function() {
  if(currentForm) currentForm.submit();
});

// Cancel removal
document.getElementById('confirmNo').addEventListener('click', function() {
  document.getElementById('confirmModal').style.display = 'none';
  currentForm = null;
});
</script>

</body>
</html>
