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
      .leave-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      }
      .leave-header {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        color: white;
        padding: 1.5rem;
      }
      .leave-body {
        padding: 2rem;
      }
      .form-control {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 0.8rem;
      }
      .form-control:focus {
        border-color: #00897B;
        box-shadow: 0 0 0 0.2rem rgba(0, 137, 123, 0.25);
      }
      .btn-submit {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 30px;
        font-weight: 500;
        transition: transform 0.2s;
      }
      .btn-submit:hover {
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
    <title>Request Leave | Attendance System</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="leave-card mt-4">
            <div class="leave-header">
              <h3><i class="fas fa-calendar-alt mr-2"></i>Request Leave</h3>
              <p class="lead mb-0">Submit your leave application</p>
            </div>
            
            <div class="leave-body">
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
                  <label for="description"><i class="fas fa-comment-alt mr-2"></i>Leave Description</label>
                  <textarea class="form-control" id="description" name="description" rows="4" placeholder="Please provide details about your leave request"></textarea>
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="date_start"><i class="fas fa-calendar-plus mr-2"></i>Start Date</label>
                      <input type="date" class="form-control" id="date_start" name="date_start">
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="date_end"><i class="fas fa-calendar-minus mr-2"></i>End Date</label>
                      <input type="date" class="form-control" id="date_end" name="date_end">
                    </div>
                  </div>
                </div>
                
                <button type="submit" class="btn btn-submit float-right" name="insertNewLeaveBtn">
                  <i class="fas fa-paper-plane mr-2"></i>Submit Request
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