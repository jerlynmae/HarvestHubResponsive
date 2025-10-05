<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/customer/purchase.css?v=<?=time()?>">
  <link rel="stylesheet" href="../../css/customer/review_modal.css?v=<?=time()?>">
  <title>My Purchases</title>
</head>
<body>

  <?php include 'customer_sidebar.php'; ?>

  <!-- Main Content -->
  <div class="main">
    <!-- Floating Back Button -->
    <a href="customer_page.php" class="back-button">
      <i class="fa-solid fa-arrow-left"></i>
    </a>

    <h1>My Purchases</h1>

    <!-- Tabs -->
    <div class="tabs">
      <button class="active">All</button>
      <button>In Progress</button>
      <button>Delivered</button>
      <button>Cancelled</button>
      <button>Completed</button>
    </div>

    <!-- Order Delivered -->
    <div class="order-card">
      <div class="order-header">
        <div>
          <strong>Order Delivered</strong><br>
          <small>Apr 5, 2025, 10:07 AM</small>
        </div>
        <span class="order-status status-completed">Completed</span>
      </div>
      <div class="order-info">
        <span>₱200.00 · Paid with cash</span>
        <span>Items: 6x</span>
      </div>
      <div class="order-items">
        <img src="https://via.placeholder.com/40" alt="">
        <img src="https://via.placeholder.com/40" alt="">
        <img src="https://via.placeholder.com/40" alt="">
      </div>
      <div class="order-actions">
        <button class="btn btn-yellow" id="openReview">Rate your Order</button>
      </div>
    </div>

    <!-- Order Cancelled -->
    <div class="order-card">
      <div class="order-header">
        <div>
          <strong>Order Cancelled</strong><br>
          <small>Apr 5, 2025, 10:07 AM</small>
        </div>
        <span class="order-status status-cancelled">Cancelled</span>
      </div>
      <div class="order-info">
        <span>₱200.00 · Paid with cash</span>
        <span>Items: 6x</span>
      </div>
      <div class="order-items">
        <img src="https://via.placeholder.com/40" alt="">
        <img src="https://via.placeholder.com/40" alt="">
      </div>
    </div>

    <!-- Order In Progress -->
    <div class="order-card">
      <div class="order-header">
        <div>
          <strong>Order In Progress</strong><br>
          <small>Apr 5, 2025, 10:07 AM</small>
        </div>
        <span class="order-status status-progress">In Progress</span>
      </div>
      <div class="order-info">
        <span>₱200.00 · Paid with cash</span>
        <span>Items: 6x</span>
      </div>
      <div class="order-items">
        <img src="https://via.placeholder.com/40" alt="">
        <img src="https://via.placeholder.com/40" alt="">
        <div style="width:40px;height:40px;border:1px solid #ccc;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:12px;color:#555;">+12</div>
      </div>
      <div class="order-actions">
        <button class="btn btn-red">Return/Replacement</button>
        <button class="btn btn-green">Order Received</button>
      </div>
    </div>

  </div> <!-- end .main -->

  <!-- Review Modal -->
  <div class="modal" id="reviewModal">
    <div class="modal-content">
      <span class="close" id="closeReview">&times;</span>
      <h3>Rate Your Order</h3>

      <!-- Stars -->
      <div class="stars" id="starContainer">
        <i data-value="1">&#9733;</i>
        <i data-value="2">&#9733;</i>
        <i data-value="3">&#9733;</i>
        <i data-value="4">&#9733;</i>
        <i data-value="5">&#9733;</i>
      </div>

      <!-- Comment -->
      <textarea placeholder="Leave a comment..."></textarea>

      <!-- Upload Section -->
      <div class="upload-section">
        <label for="reviewImages" class="upload-label">+ Upload Images</label>
        <input type="file" id="reviewImages" accept="image/*" multiple hidden>
        <div class="preview-container" id="previewContainer"></div>
      </div>

      <!-- Submit -->
      <button class="submit-btn">Submit Review</button>
    </div>
  </div>

  <script>
    const openBtn = document.getElementById("openReview");
    const modal = document.getElementById("reviewModal");
    const closeBtn = document.getElementById("closeReview");
    const stars = document.querySelectorAll("#starContainer i");
    const fileInput = document.getElementById("reviewImages");
    const previewContainer = document.getElementById("previewContainer");

    // Open modal
    openBtn.addEventListener("click", () => {
      modal.style.display = "flex";
    });

    // Close modal
    closeBtn.addEventListener("click", () => {
      modal.style.display = "none";
      resetModal();
    });
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.style.display = "none";
        resetModal();
      }
    });

    // Star rating logic
    stars.forEach(star => {
      star.addEventListener("click", () => {
        let value = star.getAttribute("data-value");
        stars.forEach(s => s.classList.remove("active"));
        for (let i = 0; i < value; i++) {
          stars[i].classList.add("active");
        }
      });
    });

    // Image preview with remove option
    fileInput.addEventListener("change", () => {
      previewContainer.innerHTML = "";
      const files = Array.from(fileInput.files);

      files.forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
          const wrapper = document.createElement("div");
          wrapper.classList.add("preview");

          const img = document.createElement("img");
          img.src = e.target.result;

          const removeBtn = document.createElement("span");
          removeBtn.classList.add("remove");
          removeBtn.innerHTML = "&times;";
          removeBtn.onclick = () => wrapper.remove();

          wrapper.appendChild(img);
          wrapper.appendChild(removeBtn);
          previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
      });
    });

    // Reset modal content when closed
    function resetModal() {
      stars.forEach(s => s.classList.remove("active"));
      fileInput.value = "";
      previewContainer.innerHTML = "";
      document.querySelector("textarea").value = "";
    }
  </script>

</body>
</html>
