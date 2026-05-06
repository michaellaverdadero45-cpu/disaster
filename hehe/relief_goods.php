<!DOCTYPE html>
<html>
  <head>
    <title>Relief Goods - DisasterOps</title>
    <style>
      * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
      }

      body {
      display: flex;
      background-color: #f0f4f8;
      }

      /* --- SIDEBAR --- */
      .sidebar {
      width: 280px;
      background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
      color: white;
      height: 100vh;
      padding: 20px 0;
      position: fixed;
      }

      .logo {
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 40px;
      padding: 10px;
      }

      .sidebar a {
      display: block;
      color: white;
      padding: 15px 30px;
      text-decoration: none;
      font-size: 18px;
      transition: background 0.3s;
      }

      .sidebar a:hover, .sidebar a.active {
      background-color: rgba(255, 255, 255, 0.2);
      border-left: 5px solid white;
      }

      .sidebar a.logout {
      background-color: #dc3545;
      margin-top: 20px;
      }

      /* --- MAIN CONTENT --- */
      .main-content {
      margin-left: 280px;
      width: 100%;
      padding: 30px;
      }

      /* --- FORM STYLING --- */
      .form-container {
      background: white;
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      overflow: hidden;
      }

      .form-header {
      background-color: #1e3c72;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
      }

      .form-body {
      padding: 30px;
      }

      .form-group {
      margin-bottom: 20px;
      }

      label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
      }

      input[type="text"],
      input[type="number"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
      }

      .button-group {
      display: flex;
      gap: 15px;
      margin-top: 30px;
      }

      .btn-add {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 12px 25px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 4px;
      flex: 1;
      }

      .btn-back {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 12px 25px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 4px;
      flex: 1;
      }

      /* --- MESSAGE BOX --- */
      .message {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
      text-align: center;
      }

      .success {
      background-color: #d4edda;
      color: #155724;
      }

      .error {
      background-color: #f8d7da;
      color: #721c24;
      }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
  <body>



<?php
$conn = mysqli_connect("localhost", "root", "", "login_system");

// CHECK CONNECTION
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ADD ITEM
if (isset($_POST['add_item'])) {
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];

    $query = "INSERT INTO relief_goods (item_name, category, quantity, unit)
              VALUES ('$item_name', '$category', '$quantity', '$unit')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Item added successfully!'); window.location='relief_goods.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


    <!-- SIDEBAR -->
    <div class="sidebar">
      <div class="logo">
        <i class="fas fa-shield-alt"></i> DisasterOps
      </div>
      <a href="dashboard.php">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="disaster_report.php">
        <i class="fas fa-exclamation-triangle"></i> Disaster Reports
      </a>
      <a href="evacuation_center.php" class="active">
        <i class="fas fa-map-marker-alt"></i> Evacuation Centers
      </a>
      <a href="affected_people.php">
        <i class="fas fa-users"></i> Affected People
      </a>
      <a href="relief_goods.php">
        <i class="fas fa-boxes"></i> Relief Goods
      </a>
      <a href="reports.php">
        <i class="fas fa-file-alt"></i> Reports
      </a>
      <a href="logout.php" class="logout">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  

       <!DOCTYPE html>
        <html>
         <head>
    <title>Relief Goods Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

  <body class="bg-light">

    <div class="container mt-5">
      <h2>Relief Goods Management</h2>

      <!-- BUTTON -->
      <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        + Add New Item
      </button>

      <!-- TABLE -->
      <table class="table table-bordered bg-white">
        <thead>
          <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Unit</th>
          </tr>
        </thead>
        <tbody>
          <?php
        $result = mysqli_query($conn, "SELECT * FROM relief_goods");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['item_id']}</td>
                    <td>{$row['item_name']}</td>
                    <td>{$row['category']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['unit']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="addModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <form method="POST">
            <div class="modal-header">
              <h5 class="modal-title">Add Item</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <input type="text" name="item_name" class="form-control mb-2" placeholder="Item Name" required="">
                <input type="text" name="category" class="form-control mb-2" placeholder="Category" required="">
                  <input type="number" name="quantity" class="form-control mb-2" placeholder="Quantity" required="">
                    <input type="text" name="unit" class="form-control mb-2" placeholder="Unit (e.g. pcs, kg)" required="">
        </div>

            <div class="modal-footer">
              <button type="submit" name="add_item" class="btn btn-success">Add Item</button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>