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
      .attendance-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
      }
      .attendance-header {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        color: white;
        padding: 1.5rem;
      }
      .attendance-body {
        padding: 1.5rem;
      }
      .table {
        margin-bottom: 0;
      }
      .table thead th {
        border-top: none;
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
        color: #495057;
      }
      .text-danger {
        color: #dc3545 !important;
      }
      .badge {
        padding: 0.5em 1em;
        border-radius: 30px;
      }
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>Attendance Records | Attendance System</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <?php $getAllDates = getAllDates($pdo); ?>
      <?php foreach ($getAllDates as $row) { ?>
      <div class="attendance-card">
        <div class="attendance-header">
          <h3><i class="fas fa-calendar-day mr-2"></i><?php echo date('F d, Y', strtotime($row['date_added'])); ?></h3>
        </div>
        <div class="attendance-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th><i class="fas fa-user mr-2"></i>Employee Name</th>
                  <th><i class="fas fa-sign-in-alt mr-2"></i>Time In</th>
                  <th><i class="fas fa-sign-out-alt mr-2"></i>Time Out</th>
                </tr>
              </thead>
              <tbody>
              <?php $getAttendancesByDateGrouped = getAttendancesByDateGrouped($pdo, $row['date_added']); ?>
              <?php foreach ($getAttendancesByDateGrouped as $innerRow) { ?>
                <tr>
                  <td>
                    <strong><?php echo $innerRow['last_name'] . ', ' . $innerRow['first_name']; ?></strong>
                  </td>
                  <td>
                    <?php if ($innerRow['time_in']): ?>
                      <span class="badge badge-success">
                        <i class="fas fa-clock mr-1"></i>
                        <?php echo date('h:i A', strtotime($innerRow['time_in'])); ?>
                      </span>
                    <?php else: ?>
                      <span class="badge badge-danger">
                        <i class="fas fa-times mr-1"></i>
                        No time in
                      </span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($innerRow['time_out']): ?>
                      <span class="badge badge-success">
                        <i class="fas fa-clock mr-1"></i>
                        <?php echo date('h:i A', strtotime($innerRow['time_out'])); ?>
                      </span>
                    <?php else: ?>
                      <span class="badge badge-danger">
                        <i class="fas fa-times mr-1"></i>
                        No time out
                      </span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>