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
      .attendance-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      }
      .attendance-header {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        color: white;
        padding: 1.5rem;
      }
      .attendance-body {
        padding: 2rem;
      }
      .btn-record {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 30px;
        font-weight: 500;
        transition: transform 0.2s;
      }
      .btn-record:hover {
        transform: translateY(-2px);
        color: white;
      }
      .alert {
        border-radius: 10px;
        border: none;
      }
      .alert-success {
        background-color: #e8f5e9;
        color: #2e7d32;
      }
      .alert-danger {
        background-color: #ffebee;
        color: #c62828;
      }
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>Record Attendance | Attendance System</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="attendance-card mt-4">
            <div class="attendance-header">
              <h3><i class="fas fa-clock mr-2"></i>Record Attendance</h3>
              <p class="lead mb-0">Log your daily time in and time out</p>
            </div>
            
            <div class="attendance-body">
              <?php  
                if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
                  if ($_SESSION['status'] == "200") {
                    echo "<div class='alert alert-success'><i class='fas fa-check-circle mr-2'></i>{$_SESSION['message']}</div>";
                  } else {
                    echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle mr-2'></i>{$_SESSION['message']}</div>";
                  }
                }
                unset($_SESSION['message']);
                unset($_SESSION['status']);
              ?>
              
              <form action="core/handleForms.php" method="POST">
                <div class="form-group">
                  <label for="attendance_type"><i class="fas fa-clipboard-list mr-2"></i>Select Record Type</label>
                  <select class="form-control" name="attendance_type" id="attendance_type">
                    <option value="time_in">Time In</option>
                    <option value="time_out">Time Out</option>
                
                  </select>
                  <input type="hidden" name="date_today" value="<?php $date = date('Y-m-d H:i:s'); echo date('Y-m-d', strtotime($date)); ?>">
                </div>
                <button type="submit" class="btn btn-record float-right" name="insertNewAttendanceBtn">
                  <i class="fas fa-save mr-2"></i>Record Attendance
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>