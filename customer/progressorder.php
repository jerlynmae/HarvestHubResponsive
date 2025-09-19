<?php
// Example order data (you can fetch this from your DB)
$order = [
    "id" => "#123-321",
    "status" => "In Progress",
    "date" => "Apr 5, 2022, 10:07 AM",
    "items" => [
        ["name" => "Pechay", "price" => 195.00, "old_price" => 200.00, "qty" => 12, "image" => "images/pechay.jpg"],
        ["name" => "Pechay", "price" => 195.00, "old_price" => 200.00, "qty" => 12, "image" => "images/pechay.jpg"],
        ["name" => "Pechay", "price" => 195.00, "old_price" => 200.00, "qty" => 12, "image" => "images/pechay.jpg"],
    ],
    "delivery_fee" => 200,
    "payment_method" => "Cash on Delivery",
    "address" => "Shopping in 07114"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Progress</title>
  <link rel="stylesheet" href="../css/progressorder.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<a href="customer_page.php" style="text-decoration:none; color:#333; font-size:20px;">
  <i class="fas fa-arrow-left"></i>
</a>

<div class="container">
  <!-- Left Section -->
  <div class="left">
    <div class="card">
      <div class="status">
        <div>
          <h3>Order In Progress</h3>
          <small>Order Arrived at <?= $order['date'] ?></small>
        </div>
        <span class="badge"><?= $order['status'] ?></span>
      </div>
      <div class="status-main">
        <i class="fas fa-check-circle"></i>
        <p>Order is Placed</p>
      </div>
    </div>

    <div class="card items">
      <table>
        <tr>
          <th>Items Name</th>
          <th>N. of items</th>
        </tr>
        <?php foreach($order['items'] as $item): ?>
        <tr>
          <td>
            <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
            <?= $item['name'] ?><br>
            ₱<?= number_format($item['price'], 2) ?> 
            <del style="color:#aaa;">₱<?= number_format($item['old_price'], 2) ?></del>
          </td>
          <td><?= $item['qty'] ?>x</td>
        </tr>
        <?php endforeach; ?>
      </table>
      <button class="cancel-btn">Cancel Order</button>
    </div>
  </div>

  <!-- Right Section -->
  <div class="right">
    <div class="card order-summary">
      <h4>Order Summary</h4>
      <div class="summary-item">
        <span>Order Number</span>
        <span class="highlight"><?= $order['id'] ?></span>
      </div>
      <div class="summary-item">
        <span>Delivery Fees</span>
        <span>₱<?= number_format($order['delivery_fee'], 2) ?></span>
      </div>
      <div class="summary-item">
        <span>Total</span>
        <strong>₱<?= number_format($order['delivery_fee'], 2) ?></strong>
      </div>
    </div>

    <div class="card">
      <h4>Pay With</h4>
      <p class="highlight"><?= $order['payment_method'] ?></p>
    </div>

    <div class="card">
      <h4>Delivery Address</h4>
      <p><i class="fas fa-map-marker-alt"></i> <?= $order['address'] ?></p>
    </div>
  </div>
</div>

</body>
</html>
