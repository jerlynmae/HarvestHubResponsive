<?php
session_start();
include '../config/db_connect.php';

// redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle Add Input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_input'])) {
    $type = $_POST['type'] ?? '';
    $cost = $_POST['cost'] ?? 0;

    $stmt = $conn->prepare("INSERT INTO farm_inputs (user_id, type, cost) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $user_id, $type, $cost);
    $stmt->execute();
    $stmt->close();

    header("Location: farminput.php");
    exit;
}

// Handle Edit Input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_input'])) {
    $id   = $_POST['id'] ?? 0;
    $type = $_POST['type'] ?? '';
    $cost = $_POST['cost'] ?? 0;

    $stmt = $conn->prepare("UPDATE farm_inputs SET type=?, cost=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sdii", $type, $cost, $id, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: farminput.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM farm_inputs WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: farminput.php");
    exit;
}

// Fetch Inputs
$result = $conn->query("SELECT * FROM farm_inputs WHERE user_id = $user_id ORDER BY date_added DESC");

// Calculate total cost
$total_cost = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_cost += $row['cost'];
    }
    $result->data_seek(0);
}

include 'sidebar.php'; 
 
?>
<link rel="stylesheet" href="sidebar.css?v=<?=time()?>">
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Farm Inputs</title>
<link rel="stylesheet" href="../css/sidebar.css">
<link rel="stylesheet" href="../css/farm_inputs.css?v=<?=time()?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="main-content">
           <!-- 🌤️ Weather Card -->
  <div id="weatherContainer" class="weather-card">
    <p>Fetching weather data...</p>
  </div>
  <h2>Farm Inputs</h2>
  <h3>Total Expenses: ₱<?= number_format($total_cost, 2) ?></h3>
  <button class="add-btn" id="addBtn">Add Input</button>

  <table>
      <tr>
          <th>Type</th>
          <th>Cost</th>
          <th>Date</th>
          <th>Action</th>
      </tr>
      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>".htmlspecialchars($row['type'])."</td>
                      <td>₱".number_format($row['cost'],2)."</td>
                      <td>".htmlspecialchars($row['date_added'])."</td>
                      <td class='action-btns'>
                          <a href='#' class='editBtn' 
                             data-id='{$row['id']}'
                             data-type='".htmlspecialchars($row['type'])."'
                             data-cost='{$row['cost']}'>Edit</a> |
                          <a href='?delete={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Remove</a>
                      </td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No farm inputs added yet.</td></tr>";
      }
      ?>
  </table>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeAdd">&times;</span>
    <h3>Add Farm Input</h3>
    <form method="POST">
        <label for="type">Type</label><br>
        <input type="text" name="type" required><br><br>

        <label for="cost">Cost</label><br>
        <input type="number" name="cost" step="0.01" required><br><br>
        <button type="submit" name="add_input">Add</button>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeEdit">&times;</span>
    <h3>Edit Farm Input</h3>
    <form method="POST">
        <input type="hidden" name="id" id="editId">
        <label for="editType">Type</label><br>
        <input type="text" name="type" id="editType" required><br><br>

        <label for="editCost">Cost</label><br>
        <input type="number" name="cost" id="editCost" step="0.01" required><br><br>

        <button type="submit" name="edit_input">Update</button>
    </form>
  </div>
</div>

<script>
// Ask for user location
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(
    pos => {
      fetchWeather(pos.coords.latitude, pos.coords.longitude);
    },
    () => {
      document.getElementById("weatherContainer").innerHTML = "<p>Location access denied.</p>";
    }
  );
} else {
  document.getElementById("weatherContainer").innerHTML = "<p>Geolocation not supported.</p>";
}

// Add Modal
const addModal = document.getElementById("addModal");
const addBtn   = document.getElementById("addBtn");
const closeAdd = document.getElementById("closeAdd");

addBtn.onclick    = () => addModal.style.display = "flex";
closeAdd.onclick  = () => addModal.style.display = "none";
window.addEventListener("click", (e) => {
  if (e.target === addModal) addModal.style.display = "none";
});

// Edit Modal
const editModal = document.getElementById("editModal");
const closeEdit = document.getElementById("closeEdit");
const editBtns  = document.querySelectorAll(".editBtn");

editBtns.forEach(btn => {
  btn.addEventListener("click", (e) => {
    e.preventDefault(); // para hindi mag-refresh agad
    document.getElementById("editId").value   = btn.dataset.id;
    document.getElementById("editType").value = btn.dataset.type;
    document.getElementById("editCost").value = btn.dataset.cost;
    editModal.style.display = "flex";
  });
});

closeEdit.onclick = () => editModal.style.display = "none";
window.addEventListener("click", (e) => {
  if (e.target === editModal) editModal.style.display = "none";
});

// Confirm Delete
const deleteLinks = document.querySelectorAll("a[href*='?delete=']");
deleteLinks.forEach(link => {
  link.addEventListener("click", (e) => {
    if (!confirm("Are you sure you want to delete this input?")) {
      e.preventDefault();
    }
  });
});
</script>


</body>
</html>
