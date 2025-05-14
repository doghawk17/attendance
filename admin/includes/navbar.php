<?php
  // Get unread notifications count
  $unreadCount = countUnreadNotifications($pdo, $_SESSION['user_id']);
  // Get recent notifications
  $notifications = getNotificationsForUser($pdo, $_SESSION['user_id'], 5);
?>
<nav class="navbar navbar-expand-lg navbar-dark p-4" style="background-color: #008080;">
  <a class="navbar-brand" href="#">Admin Panel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="all_attendances.php">All Attendances</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="leaves.php">Leaves</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="all_users.php">All Users</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-bell"></i>
          <?php if ($unreadCount > 0): ?>
            <span class="badge badge-danger"><?php echo $unreadCount; ?></span>
          <?php endif; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
          <h6 class="dropdown-header">Notifications</h6>
          <?php if (count($notifications) > 0): ?>
            <?php foreach ($notifications as $notification): ?>
              <a class="dropdown-item <?php echo $notification['is_read'] ? '' : 'bg-light'; ?>" href="#" onclick="markAsRead(<?php echo $notification['notification_id']; ?>)">
                <?php echo $notification['message']; ?>
                <small class="text-muted d-block"><?php echo date('M d, Y h:i A', strtotime($notification['date_added'])); ?></small>
              </a>
            <?php endforeach; ?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-center" href="#" onclick="markAllAsRead()">Mark all as read</a>
          <?php else: ?>
            <div class="dropdown-item">No notifications</div>
          <?php endif; ?>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="core/handleForms.php?logoutUserBtn=1">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Add JavaScript for notification actions -->
<script>
  function markAsRead(notificationId) {
    $.ajax({
      url: 'core/handleNotifications.php',
      type: 'POST',
      data: {
        action: 'mark_read',
        notification_id: notificationId
      },
      success: function(response) {
        // Refresh the page to update notification count
        location.reload();
      }
    });
  }
  
  function markAllAsRead() {
    $.ajax({
      url: 'core/handleNotifications.php',
      type: 'POST',
      data: {
        action: 'mark_all_read',
        user_id: <?php echo $_SESSION['user_id']; ?>
      },
      success: function(response) {
        // Refresh the page to update notification count
        location.reload();
      }
    });
  }
</script>
