<html>
  <head>
    <title>Affected People - DisasterOps</title>
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

      .btn-save {
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
session_start();
include 'db.php';



$success = "";
$error = "";

// Handle form submission - EXACT FIELD NAMES
if(isset($_POST['save'])){

    // Get values using EXACT names from your design
    $person_id             = trim($_POST['person_id']);
    $name                  = trim($_POST['name']);
    $age                   = trim($_POST['age']);
    $evacuation_center     = trim($_POST['evacuation_center']);

    // Check duplicate entry based on PERSON ID
    $check_stmt = $conn->prepare("SELECT * FROM affected_people WHERE person_id = ?");
    $check_stmt->bind_param("s", $person_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if($result->num_rows > 0){
        $error = "Person ID already exists! Use unique ID.";
    } else {
        // Insert into database - EXACT COLUMN NAMES MATCHING YOUR ATTRIBUTES
        $insert_stmt = $conn->prepare("INSERT INTO affected_people (person_id, name, age, evacuation_center) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("ssis", $person_id, $name, $age, $evacuation_center);

        if($insert_stmt->execute()){
            $success = "Record saved successfully!";
        } else {
            $error = "Error saving data: " . $conn->error;
        }
        $insert_stmt->close();
    }
    $check_stmt->close();
}
?>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        <i class="fas fa-shield-alt"></i> DisasterOps
    </div>
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="disaster_report.php"><i class="fas fa-exclamation-triangle"></i> Disaster Reports</a>
    <a href="evacuation_center.php"><i class="fas fa-map-marker-alt"></i> Evacuation Centers</a>
    <a href="affected_people.php" class="active"><i class="fas fa-users"></i> Affected People</a>
    <a href="relief_goods.php"><i class="fas fa-boxes"></i> Relief Goods</a>
    <a href="reports.php"><i class="fas fa-file-alt"></i> Reports</a>
    <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="form-container">
        <div class="form-header">
            AFFECTED PEOPLE
        </div>

        <div class="form-body">

            <?php if(!empty($success)): ?>
                <div class="message success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if(!empty($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>
			  
			  <form method="POST" action="save_people.php">

            <form method="POST" action="">
                <!-- EXACT FIELDS & LABELS AS PROVIDED IN YOUR DIAGRAM -->
                <div class="form-group">
                    <label>PERSON ID:</label>
                    <input type="text" name="person_id" required>
                </div>

                <div class="form-group">
                    <label>NAME:</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>AGE:</label>
                    <input type="number" name="age" min="1" max="120" required>
                </div>

                <div class="form-group">
                    <label>EVACUATION CENTER:</label>
                    <input type="text" name="evacuation_center" required>
                </div>

                <!-- EXACT BUTTON LABELS -->
                <div class="button-group">
                    <button type="submit" name="save" class="btn-save">SAVE</button>
                    <button type="button" class="btn-back" onclick="history.back()">BACK</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>