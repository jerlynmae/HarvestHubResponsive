<?php
session_start();
include '../../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// ===== Filter by status =====
$status_filter = $_GET['status'] ?? 'All';
$status_sql = "";
$params = [];
if ($status_filter != 'All' && $status_filter != 'Reviews') {
    $status_sql = "WHERE status = ?";
    $params[] = $status_filter;
}

// ===== Fetch Orders =====
if ($status_sql) {
    $stmt = $conn->prepare("SELECT * FROM orders $status_sql ORDER BY order_id DESC");
    $stmt->bind_param("s", ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM orders ORDER BY order_id DESC");
}

// ===== Accept/Decline Order =====
if (isset($_GET['action']) && isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];
    $action = $_GET['action'];

    if ($action === 'accept') {
        $stmt = $conn->prepare("UPDATE orders SET status='Completed' WHERE order_id=?");
    } elseif ($action === 'decline') {
        $stmt = $conn->prepare("UPDATE orders SET status='Cancelled' WHERE order_id=?");
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    header("Location: orders.php?status=$status_filter");
    exit;
}

// Include sidebar
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orders</title>
<link rel="stylesheet" href="../../css/farmer/farmers_dashboard.css?v=<?=time()?>">
<link rel="stylesheet" href="../../css/farmer/orders.css?v=<?=time()?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="main-content">
    <h2>Orders</h2>

    <div class="status-btns">
        <?php
        $statuses = ['All','Pending','Completed','Cancelled','Reviews'];
        foreach($statuses as $status):
        ?>
        <button class="<?= $status_filter==$status?'active':'' ?>" 
                onclick="window.location.href='?status=<?= $status ?>'"><?= $status ?></button>
        <?php endforeach; ?>
    </div>
    <div class="table-responsive">
    <table>
        <tr>
            <th>Product Name & Category</th>
            <th>Name of Buyer</th>
            <th>Address</th>
            <th>Lot Size</th>
            <th>Contact Number</th>
            <th>Payment Method</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php if($result->num_rows>0): ?>
            <?php while($row=$result->fetch_assoc()): ?>
            <tr>
                <td>Example Product (Vegetable)</td> 
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['lot_size'] ?? '1 lot') ?></td>
                <td><?= htmlspecialchars($row['contact_number']) ?></td>
                <td><?= htmlspecialchars($row['mode_of_payment']) ?></td>
                <td><?= htmlspecialchars($row['date_time']) ?></td>
                <td>
                    <?php if($row['status']=='Pending'): ?>
                        <a href="?action=accept&id=<?= $row['order_id'] ?>&status=<?= $status_filter ?>"><i class='fa fa-check-circle'></i></a> 
                        <a href="?action=decline&id=<?= $row['order_id'] ?>&status=<?= $status_filter ?>"><i class='fa fa-times-circle'></i></a> 
                    <?php endif; ?>
                    <a href="#" class="viewBtn"
                        data-name="<?= htmlspecialchars($row['name']) ?>"
                        data-address="<?= htmlspecialchars($row['address']) ?>"
                        data-contact="<?= htmlspecialchars($row['contact_number']) ?>"
                        data-payment="<?= htmlspecialchars($row['mode_of_payment']) ?>"
                        data-date="<?= htmlspecialchars($row['date_time']) ?>"
                        data-status="<?= htmlspecialchars($row['status']) ?>"
                        data-lot="<?= htmlspecialchars($row['lot_size'] ?? '1 lot') ?>"><i class='fa fa-eye'></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">No orders found.</td></tr>
        <?php endif; ?>
    </table>
</div>

<div id="viewModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeView">&times;</span>
    <h3>Order Details</h3>
    <p><strong>Buyer:</strong> <span id="viewName"></span></p>
    <p><strong>Address:</strong> <span id="viewAddress"></span></p>
    <p><strong>Contact:</strong> <span id="viewContact"></span></p>
    <p><strong>Payment:</strong> <span id="viewPayment"></span></p>
    <p><strong>Date:</strong> <span id="viewDate"></span></p>
    <p><strong>Status:</strong> <span id="viewStatus"></span></p>
    <p><strong>Lot Size:</strong> <span id="viewLot">1 lot</span></p>
  </div>
</div>

<script>
const viewModal = document.getElementById("viewModal");
const closeView = document.getElementById("closeView");

document.querySelectorAll(".viewBtn").forEach(btn => {
    btn.onclick = (e) => {
        e.preventDefault();
        document.getElementById("viewName").textContent = btn.dataset.name;
        document.getElementById("viewAddress").textContent = btn.dataset.address;
        document.getElementById("viewContact").textContent = btn.dataset.contact;
        document.getElementById("viewPayment").textContent = btn.dataset.payment;
        document.getElementById("viewDate").textContent = btn.dataset.date;
        document.getElementById("viewStatus").textContent = btn.dataset.status;
        document.getElementById("viewLot").textContent = btn.dataset.lot;
        viewModal.style.display = "flex";
    };
});

closeView.onclick = () => viewModal.style.display = "none";
window.onclick = (e) => { if(e.target===viewModal) viewModal.style.display = "none"; };
</script>

</body>
</html>
