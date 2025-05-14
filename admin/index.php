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
      .welcome-card {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      .welcome-card h1 {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
      }
      .stats-container {
        margin-top: 2rem;
      }
      .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
      }
      .stat-card:hover {
        transform: translateY(-5px);
      }
      .stat-icon {
        font-size: 2rem;
        color: #00897B;
        margin-bottom: 1rem;
      }
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>Admin Dashboard | Attendance System</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="welcome-card">
        <h1><i class="fas fa-user-shield mr-3"></i>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p class="lead">Manage your organization's attendance and leave requests from one central dashboard.</p>
      </div>
      
      <div class="row stats-container">
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-users"></i>
            </div>
            <h3>Employees</h3>
            <p>View and manage all employee records</p>
            <a href="all_users.php" class="btn btn-outline-primary">Manage Employees</a>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-clock"></i>
            </div>
            <h3>Attendance</h3>
            <p>Track daily attendance records</p>
            <a href="all_attendances.php" class="btn btn-outline-primary">View Attendance</a>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Leave Requests</h3>
            <p>Manage employee leave applications</p>
            <a href="leaves.php" class="btn btn-outline-primary">Handle Leaves</a>
          </div>
        </div>
      </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>