<?php
include 'config/db_connect.php';

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $address  = trim($_POST['address']);
    $contact  = trim($_POST['contact']);
    $password = $_POST['password'];
    $repass   = $_POST['re-password'];

    if ($password !== $repass) {
        $message = "Passwords do not match!";
        $message_type = "error";
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "This email is already registered.";
            $message_type = "error";
        } else {
            // Save user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, address, contact, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $address, $contact, $hashedPassword);

            if ($stmt->execute()) {
                $message = "Successfully registered!";
                $message_type = "success";
            } else {
                $message = "Error: " . $conn->error;
                $message_type = "error";
            }
            $stmt->close();
        }
        $check->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HarvestHub - Create Account</title>
  <link rel="stylesheet" href="css/log.css?v=<?= time() ?>"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
   <div class="login-container">
    <h2>Create Account</h2>
    <?php if (!empty($message)) : ?>
      <div class="notice <?= $message_type ?>">
        <?php if ($message_type === "success"): ?>
          <i class="fa-solid fa-circle-check"></i>
        <?php else: ?>
          <i class="fa-solid fa-circle-exclamation"></i>
        <?php endif; ?>
        <span><?= htmlspecialchars($message) ?></span>
        <?php if ($message_type === "success"): ?>
          <a href="login.php" style="margin-left:auto; font-size:14px; font-weight:600; color:#065f46; text-decoration:underline;">Log in</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php if ($message_type !== "success"): ?>
      <p class="account-link">
        <span>Already have an account?</span> 
        <a href="login.php">Log in here</a>
      </p>
      <form action="createaccount.php" method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="re-password" placeholder="Re-Enter Password" required>
        <button type="submit" class="btn-login">Sign Up</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
