<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

if ($_SESSION['is_admin'] == 0) {
  header("Location: ../employees/index.php");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
      body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f9fa;
      }
      .page-header {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
      }
      .employee-card {
        background: white;
        border-radius: 15px;
        transition: transform 0.2s;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      }
      .employee-card:hover {
        transform: translateY(-5px);
      }
      .employee-avatar {
        width: 60px;
        height: 60px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
      }
      .employee-avatar i {
        font-size: 1.5rem;
        color: #00897B;
      }
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>Employee Management | Attendance System</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="page-header">
        <h2><i class="fas fa-users mr-3"></i>Employee Directory</h2>
        <p class="lead mb-0">Manage and view all employees in your organization</p>
      </div>

      <div class="row">
        <?php $getAllEmployees = getAllEmployees($pdo); ?>
        <?php foreach ($getAllEmployees as $row) { ?>
        <div class="col-md-4 mb-4">
          <div class="employee-card p-4">
            <div class="employee-avatar">
              <i class="fas fa-user"></i>
            </div>
            <h4><?php echo $row['last_name'] . ", " . $row['first_name'];?></h4>
            <p class="text-muted mb-2">
              <i class="fas fa-id-badge mr-2"></i>
              <?php echo $row['username'];?>
            </p>
            <p class="text-muted mb-0">
              <i class="fas fa-calendar-alt mr-2"></i>
              Joined: <?php echo date('M d, Y', strtotime($row['date_added'])); ?>
            </p>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>