<?php
session_start();
include 'config/db_connect.php'; 

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // verify password
        if (password_verify($password, $row['password'])) {
            // save user data in session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role']; 
            // redirect based on role
            if ($row['role'] === 'farmer') {
                header("Location: user/farmer/farmer_dashboard.php");
                exit;
            } elseif ($row['role'] === 'customer') {
                header("Location: user/customer/customer_page.php");
                exit;
            } else {
                // fallback
                header("Location: index.php");
                exit;
            }
        } else {
            $message = "Invalid password!";
            $message_type = "error";
        }
    } else {
        $message = "No account found with this email!";
        $message_type = "error";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HarvestHub - Login</title>
  <link rel="stylesheet" href="css/log.css?v=<?= time() ?>"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
   <div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($message)) : ?>
      <div class="notice <?= $message_type ?>">
        <i class="fa-solid fa-circle-exclamation"></i>
        <span><?= htmlspecialchars($message) ?></span>
      </div>
    <?php endif; ?>
    <p class="account-link">
      <span>Don’t have an account?</span> 
      <a href="createaccount.php">Sign up here</a>
    </p>
    <form action="login.php" method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" class="btn-login">Log In</button>
    </form>
    <a href="#">Forgot Password?</a>
    <a href="user/farmer/farmer_signup.php">Sell your Harvest?</a>
  </div>
</body>
</html>
