<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$fullname = $_SESSION['fullname'] ?? 'Jessieca Sadiwa';
$email    = $_SESSION['email'] ?? 'jessieca@example.com';
$phone    = $_SESSION['phone'] ?? '+63 912 345 6789';
$address  = $_SESSION['address'] ?? '123 Green Street, Manila';
$member   = $_SESSION['member_since'] ?? 'April 2024';
$avatar   = $_SESSION['avatar'] ?? '../../uploads/default-avatar.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Profile</title>
  <link rel="stylesheet" href="../../css/customer/profile.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="../../css/customer/customer_sidebar.css"> 
</head>
<body>

<?php include 'customer_sidebar.php'; ?> 


<div class="main-content">
  <!-- Floating Back Button -->
    <a href="customer_page.php" class="back-button">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
  <!-- Profile Header -->
  <section class="profile-banner" style="text-align:center;">
    <div class="avatar-wrap">
      <img src="<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="avatar">
    </div> 
    <h1><?= htmlspecialchars($fullname) ?></h1>
    <p class="subtitle">Customer</p>
    <button class="btn-edit" id="editBtn">Edit Profile</button>
  </section>

  
  <!-- Info Cards -->
  <section class="info-section">
    <div class="info-card"><span>Email</span><h3><?= htmlspecialchars($email) ?></h3></div>
    <div class="info-card"><span>Phone</span><h3><?= htmlspecialchars($phone) ?></h3></div>
    <div class="info-card"><span>Address</span><h3><?= htmlspecialchars($address) ?></h3></div>
    <div class="info-card"><span>Member Since</span><h3><?= htmlspecialchars($member) ?></h3></div>
  </section>

  <!-- Recent Orders -->
  <section class="orders-section">
    <h2>Recent Orders</h2>
    <table class="orders-table">
      <thead>
        <tr>
          <th>Order ID</th><th>Date</th><th>Status</th><th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>#1001</td>
          <td>Sept 20, 2025</td>
          <td><span class="status delivered">Delivered</span></td>
          <td>₱1,250</td>
        </tr>
        <tr>
          <td>#1002</td>
          <td>Sept 18, 2025</td>
          <td><span class="status pending">Pending</span></td>
          <td>₱850</td>
        </tr>
      </tbody>
    </table>
  </section>
</div>

<!-- ✅ Edit Profile Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <h3>Edit Profile</h3>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
      <label>Profile Picture</label>
      <input type="file" name="avatar" accept="image/*">

      <label>Full Name</label>
      <input type="text" name="fullname" value="<?= htmlspecialchars($fullname) ?>" required>

      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

      <label>Phone</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>">

      <label>Address</label>
      <textarea name="address" rows="3"><?= htmlspecialchars($address) ?></textarea>

      <button type="submit">Save Changes</button>
    </form>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const editBtn   = document.getElementById("editBtn");
  const editModal = document.getElementById("editModal");
  const closeBtn  = document.getElementById("closeModal");

  editBtn.addEventListener("click", () => {
    editModal.classList.add("active");
  });

  closeBtn.addEventListener("click", () => {
    editModal.classList.remove("active");
  });

  window.addEventListener("click", (e) => {
    if(e.target === editModal) {
      editModal.classList.remove("active");
    }
  });
});
</script>

</body>
</html>
