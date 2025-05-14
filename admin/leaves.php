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
      .leave-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
      }
      .leave-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
      }
      .leave-body {
        padding: 1.5rem;
      }
      .leave-footer {
        background-color: #f8f9fa;
        padding: 1rem 1.5rem;
        border-top: 1px solid #e9ecef;
      }
      .status-badge {
        padding: 0.5em 1em;
        border-radius: 30px;
        font-weight: 500;
      }
      .status-pending { background-color: #ffd54f; color: #000; }
      .status-accepted { background-color: #4caf50; color: white; }
      .status-rejected { background-color: #f44336; color: white; }
      .date-badge {
        background-color: #e9ecef;
        padding: 0.5em 1em;
        border-radius: 30px;
        margin-right: 1rem;
      }
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>Leave Management | Attendance System</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="page-header">
        <h2><i class="fas fa-calendar-alt mr-3"></i>Leave Requests</h2>
        <p class="lead mb-0">Manage and process employee leave applications</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-10">
          <?php $getAllLeaves = getAllLeaves($pdo); ?>
          <?php foreach ($getAllLeaves as $row) { ?>
            <div class="leave-card">
              <div class="leave-header">
                <div class="d-flex justify-content-between align-items-center">
                  <h4 class="mb-0">
                    <i class="fas fa-user mr-2"></i>
                    <?php echo $row['last_name'] . ", " . $row['first_name']; ?>
                  </h4>
                  <span class="status-badge <?php 
                    echo $row['status'] == 'Rejected' ? 'status-rejected' : 
                         ($row['status'] == 'Accepted' ? 'status-accepted' : 'status-pending'); 
                  ?>">
                    <i class="fas <?php 
                      echo $row['status'] == 'Rejected' ? 'fa-times-circle' : 
                           ($row['status'] == 'Accepted' ? 'fa-check-circle' : 'fa-clock'); 
                    ?> mr-1"></i>
                    <?php echo $row['status']; ?>
                  </span>
                </div>
              </div>
              
              <div class="leave-body">
                <div class="mb-3">
                  <span class="date-badge">
                    <i class="fas fa-calendar-plus mr-1"></i>
                    Start: <?php echo date('M d, Y', strtotime($row['date_start'])); ?>
                  </span>
                  <span class="date-badge">
                    <i class="fas fa-calendar-minus mr-1"></i>
                    End: <?php echo date('M d, Y', strtotime($row['date_end'])); ?>
                  </span>
                </div>
                
                <p class="mb-0">
                  <strong><i class="fas fa-comment-alt mr-2"></i>Description:</strong><br>
                  <?php echo $row['description']; ?>
                </p>
              </div>

              <div class="leave-footer">
                <form action="core/handleForms.php" method="POST">
                  <input type="hidden" class="leave_id" value="<?php echo $row['leave_id']; ?>">
                  <div class="form-group mb-0">
                    <select class="form-control leaveStatus">
                      <option value="">Update Status</option>
                      <option value="Pending">Pending</option>
                      <option value="Accepted">Accept</option>
                      <option value="Rejected">Reject</option>
                    </select>
                  </div>
                </form>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <script>
      $('.leaveStatus').on('change', function (event) {
        var formData = {
          leave_id: $(this).closest('form').find('.leave_id').val(),
          leave_status: $(this).val(),
          updateLeaveStatus: 1
        }

        if (formData.leave_id != "" && formData.leave_status != "") {
          $.ajax({
            type: "POST",
            url: "core/handleForms.php",
            data: formData,
            success: function (data) {
              location.reload();
            }
          })
        } else {
          alert("Please select a status!");
        }
      })
    </script>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>