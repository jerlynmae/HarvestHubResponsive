<?php
// include db connection kung meron ka na
include '../config/db_connect.php';

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $farm_name     = trim($_POST['farm_name'] ?? '');
    $farm_location = trim($_POST['farm_location'] ?? '');
    $farm_type     = trim($_POST['farm_type'] ?? '');
    $farm_size     = trim($_POST['farm_size'] ?? '');

    if ($farm_name && $farm_location && $farm_type && $farm_size) {
        $stmt = $conn->prepare("INSERT INTO farms (farm_name, farm_location, farm_type, farm_size) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $farm_name, $farm_location, $farm_type, $farm_size);
        if ($stmt->execute()) {
            $message = " Farm registered successfully!";
        } else {
            $message = " Error: " . $stmt->error;
        }
        $message = "Form submitted successfully.";
    } else {
        $message = " Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register Farm</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/registerfarm.css?v=<?= time() ?>">
</head>
<body>
  <div class="form-container">
    <h2>Register Your Farm</h2>

    <?php if ($message): ?>
      <div class="message <?php echo strpos($message, '') !== false ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="form-group">
        <label for="farm_name">Farm Name</label>
        <input type="text" id="farm_name" name="farm_name" required>
      </div>

      <div class="form-group">
        <label for="farm_location">Farm Location</label>
        <input type="text" id="farm_location" name="farm_location" required>
      </div>

      <div class="form-group">
        <label for="farm_type">Farm Type</label>
        <input type="text" id="farm_type" name="farm_type" required>
      </div>

      <div class="form-group">
        <label for="farm_size">Farm Size (e.g. 2 hectares)</label>
        <input type="text" id="farm_size" name="farm_size" required>
      </div>
      
      <button type="submit">Register Farm</button> <a href="farmer_dashboard.php"> Back to Home Page </a>
    </form>
  </div>
</body>
</html>
