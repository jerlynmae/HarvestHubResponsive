<?php
session_start();
include "../../config/db_connect.php";

// Fetch only PRE-ORDER products (assuming you have a column `status` = 'preorder')
$sql = "SELECT * FROM products WHERE status = 'preorder'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HarvestHub - Pre Orders</title>
  <link rel="stylesheet" href="../../css/customer/preorder.css?v=<?= time() ?>">
  <link rel="stylesheet" href="../../css/customer/customer_sidebar.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'customer_sidebar.php'; ?> 

<div class="main-content" style="padding:20px; margin-left:230px;">
  <h2 style="margin:20px 0; color:#16a085;">Pre-Order Harvests</h2>
  <p style="margin-bottom:20px; color:#555;">Reserve your share of upcoming fresh harvests! Order now and we’ll notify you once they are ready for pickup or delivery.</p>

  <div class="products-grid">
    <?php
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
    ?>
    <div class="card">
      <img src="../img/<?php echo htmlspecialchars($row['image']); ?>" 
           alt="<?php echo htmlspecialchars($row['name']); ?>">

      <div class="card-content">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p class="stocks">Expected Harvest: <?= htmlspecialchars($row['expected_date'] ?? "TBA"); ?></p>
        <div class="price-row">
          <span class="price">₱<?php echo number_format($row['price'], 2); ?> / kg</span>
          <form method="post" action="cart_handler.php" class="add-to-cart-form">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
            <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn add-to-cart">Pre-Order</button>
          </form>
        </div>
      </div>
    </div>
    <?php
      }
    } else {
      echo "<p style='text-align:center;'>No pre-order harvests available right now. 🌾</p>";
    }
    ?>
  </div>
</div>

<script>
// AJAX Add to Cart (Pre-orders)
document.querySelectorAll('.add-to-cart-form').forEach(form => {
  form.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch(this.action, { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        showToast("Added to Pre-Order Cart!");
        document.getElementById('cart-count').textContent = data.cart_count;
      } else {
        showToast("Error adding pre-order");
      }
    })
    .catch(err => { console.error(err); showToast("Something went wrong!"); });
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
</script>

</body>
</html>
