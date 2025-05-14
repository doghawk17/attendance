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
        transition: transform 0.2s;
      }
      .leave-card:hover {
        transform: translateY(-5px);
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
        display: inline-block;
        margin-bottom: 0.5rem;
      }
      .edit-form {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 1rem;
      }
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>My Leaves | Attendance System</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="page-header">
        <h2><i class="fas fa-calendar-alt mr-3"></i>My Leave Requests</h2>
        <p class="lead mb-0">View and manage your leave applications</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-10">
          <?php $getLeavesByUserId = getLeavesByUserId($pdo, $_SESSION['user_id']); ?>
          <?php foreach ($getLeavesByUserId as $row) { ?>
            <div class="leave-card">
              <div class="leave-header">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Leave Request</h5>
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
                
                <p class="mb-2">
                  <strong><i class="fas fa-comment-alt mr-2"></i>Description:</strong><br>
                  <?php echo $row['description']; ?>
                </p>
                
                <small class="text-muted">
                  <i class="fas fa-clock mr-1"></i>
                  Submitted on <?php echo date('M d, Y h:i A', strtotime($row['date_added'])); ?>
                </small>

                <form action="core/handleForms.php" class="edit-form d-none editLeaveForm">
                  <h5><i class="fas fa-edit mr-2"></i>Edit Leave Request</h5>
                  <input type="hidden" id="leave_id" value="<?php echo $row['leave_id']; ?>">
                  
                  <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" id="description" rows="3" name="description"><?php echo $row['description']; ?></textarea>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" class="form-control" name="date_start" value="<?php echo $row['date_start']; ?>" id="date_start">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>End Date</label>
                        <input type="date" class="form-control" name="date_end" value="<?php echo $row['date_end']; ?>" id="date_end">
                      </div>
                    </div>
                  </div>
                  
                  <button type="submit" class="btn btn-primary" name="editLeaveBtn">
                    <i class="fas fa-save mr-2"></i>Save Changes
                  </button>
                </form>
              </div>
              
              <div class="leave-footer">
                <button class="btn btn-link text-muted edit-toggle">
                  <i class="fas fa-edit mr-1"></i>Edit Request
                </button>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <script>
      $('.edit-toggle').on('click', function() {
        $(this).closest('.leave-card').find('.editLeaveForm').toggleClass('d-none');
      });

      $('.editLeaveForm').on('submit', function(event) {
        event.preventDefault();

        var formData = {
          description: $(this).find('#description').val(),
          date_start: $(this).find('#date_start').val(),
          date_end: $(this).find('#date_end').val(),
          leave_id: $(this).find('#leave_id').val(),
          editLeaveBtn: 1
        }

        if (formData.description != "" && formData.date_start != "" && formData.date_end != "") {
          $.ajax({
            type: "POST",
            url: "core/handleForms.php",
            data: formData,
            success: function(data) {
              location.reload();
            }
          })
        } else {
          alert("Please fill in all fields!");
        }
      });
    </script>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>