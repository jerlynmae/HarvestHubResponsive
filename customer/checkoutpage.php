<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - HarvestHub</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/checkout.css?v=<?=time()?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">

  <!-- Header -->
  <div class="header">
    <a href="cart.php"><i class="fa-solid fa-arrow-left"></i></a>
    <span>Checkout</span>
  </div>

  <!-- Layout -->
  <div class="checkout-wrapper">

    <!-- Left -->
    <div class="left">
      <div class="card">
        <h3><i class="fa-solid fa-credit-card"></i> Checkout</h3>
        <p><i class="fa-regular fa-clock"></i> Deliver Today April 5, 2025 • 11am–12pm</p>
      </div>

      <div class="card">
        <h3><i class="fa-solid fa-location-dot"></i> Delivery Info</h3>
        <p>Deliver to: <a href="#">Laon, Mogpog Marinduque</a></p>
      </div>

      <div class="card">
        <h3><i class="fa-solid fa-wallet"></i> Payment Method</h3>
        <p>Pay with: <span id="payment-text" style="color:#007b55;font-weight:600;">Cash on Delivery</span></p>
        <p>+63 912 3456 789</p>
        <a href="#" onclick="openModal()">Change Payment Method</a>
      </div>

      <div class="card">
        <h3><i class="fa-regular fa-rectangle-list"></i> Review Order</h3>
        <div class="review-order">
          <img src="https://via.placeholder.com/48" alt="">
          <img src="https://via.placeholder.com/48" alt="">
          <img src="https://via.placeholder.com/48" alt="">
          <div class="more">+12</div>
        </div>
      </div>
    </div>

    <!-- Right -->
    <div class="right">
      <div class="summary">
        <h3>Order Summary</h3>
        <p><span>Delivery fee</span><span>₱5.00</span></p>
        <p><span>Service fee</span><span>₱5.00</span></p>
        <p><span>Items total</span><span>₱200.00</span></p>

        <h4>Customer’s Note</h4>
        <textarea placeholder="Add your note here..."></textarea>
        <p class="total"><span>Total</span><span>₱210.00</span></p>
            <form method="get" action="progressorder.php">
      <button type="submit" class="place-btn">Place Order</button>
    </form>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div class="modal" id="paymentModal">
  <div class="modal-content">
    <h4>Select Payment Method</h4>
    <label><input type="radio" name="payment" value="GCash"> GCash</label>
    <label><input type="radio" name="payment" value="Cash on Delivery" checked> Cash on Delivery</label>
    <label><input type="radio" name="payment" value="Cash on Pick-Up"> Cash on Pick-Up</label>
    <button onclick="savePayment()">Confirm</button>
  </div>
</div>

<script>
function openModal() {
  document.getElementById("paymentModal").style.display = "flex";
}
function savePayment() {
  let selected = document.querySelector('input[name="payment"]:checked').value;
  document.getElementById("payment-text").textContent = selected;
  document.getElementById("paymentModal").style.display = "none";
}
window.onclick = function(e) {
  let modal = document.getElementById("paymentModal");
  if (e.target === modal) modal.style.display = "none";
}
</script>

</body>
</html>
