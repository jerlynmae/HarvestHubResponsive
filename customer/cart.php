<?php
session_start();
include "../config/db_connect.php";

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

</style>
</head>
<body>

<!-- Header with Back Button -->
<div class="header">
  <a href="customer_page.php"><i class="fa-solid fa-arrow-left"></i></a>
  <span>My Cart</span>
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
    <form method="POST" action="checkoutpage.php">
    <button type="submit" name="place_order" class="checkout-btn">
        <i class="fas fa-credit-card"></i> Checkout
    </button>
</form>
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
