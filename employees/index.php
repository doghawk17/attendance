<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

if ($_SESSION['is_admin'] == 1) {
  header("Location: ../admin/index.php");
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
        margin-bottom: 2rem;
      }
      .time-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
      }
      .time-display {
        font-size: 3rem;
        font-weight: 700;
        color: #00897B;
        text-align: center;
        margin: 1rem 0;
      }
      .attendance-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      }
      .attendance-status {
        padding: 0.5em 1em;
        border-radius: 30px;
        font-weight: 500;
        display: inline-block;
      }
      .status-success {
        background-color: #4caf50;
        color: white;
      }
      .status-pending {
        background-color: #f44336;
        color: white;
      }
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>Employee Dashboard | Attendance System</title>
  </head>
  <body onload="startTime()">
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="welcome-card">
        <h2><i class="fas fa-user mr-3"></i>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p class="lead mb-0">Track your attendance and manage your leaves from one place.</p>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="time-card">
            <h4><i class="fas fa-clock mr-2"></i>Current Time</h4>
            <div class="time-display" id="txt"></div>
            <p class="text-center text-muted mb-0">Philippine Standard Time</p>
          </div>
        </div>

        <div class="col-md-6">
          <div class="attendance-card">
            <h4><i class="fas fa-calendar-check mr-2"></i>Today's Attendance</h4>
            <p class="text-muted">
              <?php 
                $date = date('Y-m-d H:i:s'); 
                echo date('F d, Y', strtotime($date));
              ?>
            </p>
            
            <div class="row mt-4">
              <div class="col-md-6">
                <h5>Time In</h5>
                <?php 
                $getTimeInOrOutForToday = getTimeInOrOutForToday($pdo, $_SESSION['user_id'], date('Y-m-d', strtotime($date)), "time_in");
                if (!empty($getTimeInOrOutForToday)) {
                  echo "<span class='attendance-status status-success'><i class='fas fa-check-circle mr-2'></i>" . 
                       date('h:i A', strtotime($getTimeInOrOutForToday['timestamp_record_added'])) . "</span>";
                } else {
                  echo "<span class='attendance-status status-pending'><i class='fas fa-times-circle mr-2'></i>Not yet recorded</span>";
                }
                ?>
              </div>
              
              <div class="col-md-6">
                <h5>Time Out</h5>
                <?php 
                $getTimeInOrOutForToday = getTimeInOrOutForToday($pdo, $_SESSION['user_id'], date('Y-m-d', strtotime($date)), "time_out");
                if (!empty($getTimeInOrOutForToday)) {
                  echo "<span class='attendance-status status-success'><i class='fas fa-check-circle mr-2'></i>" . 
                       date('h:i A', strtotime($getTimeInOrOutForToday['timestamp_record_added'])) . "</span>";
                } else {
                  echo "<span class='attendance-status status-pending'><i class='fas fa-times-circle mr-2'></i>Not yet recorded</span>";
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>