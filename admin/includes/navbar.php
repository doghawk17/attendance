<?php
  // Get unread notifications count
  $unreadCount = countUnreadNotifications($pdo, $_SESSION['user_id']);
  // Get recent notifications
  $notifications = getNotificationsForUser($pdo, $_SESSION['user_id'], 5);
?>
<style>
.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  height: 100vh;
  width: 250px;
  background: linear-gradient(180deg, #004D40 0%, #00695C 100%);
  color: white;
  padding: 1rem;
  transition: all 0.3s ease;
  z-index: 1000;
}

.sidebar-header {
  padding: 1rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  margin-bottom: 1rem;
}

.sidebar-brand {
  color: white;
  font-size: 1.5rem;
  font-weight: 600;
  text-decoration: none;
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.sidebar-brand:hover {
  color: white;
  text-decoration: none;
}

.nav-item {
  margin-bottom: 0.5rem;
}

.nav-link {
  color: rgba(255, 255, 255, 0.8);
  padding: 0.8rem 1rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  transition: all 0.3s ease;
}

.nav-link:hover {
  color: white;
  background: rgba(255, 255, 255, 0.1);
}

.nav-link.active {
  background: rgba(255, 255, 255, 0.2);
  color: white;
}

.nav-link i {
  margin-right: 1rem;
  width: 20px;
  text-align: center;
}

.main-content {
  margin-left: 250px;
  padding: 2rem;
  transition: all 0.3s ease;
}

.notification-dropdown {
  min-width: 300px;
  padding: 0;
}

.notification-item {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid #e9ecef;
}

.notification-item:last-child {
  border-bottom: none;
}

.unread-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #dc3545;
  color: white;
  border-radius: 50%;
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
}

.user-section {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 1rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.user-info {
  display: flex;
  align-items: center;
  color: white;
  padding: 0.5rem 1rem;
}

.user-avatar {
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
}

.user-name {
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.user-role {
  font-size: 0.875rem;
  opacity: 0.8;
}
</style>

<div class="sidebar">
  <div class="sidebar-header">
    <a href="index.php" class="sidebar-brand">
      <i class="fas fa-shield-alt mr-2"></i>
      Admin Panel
    </a>
  </div>
  
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
        <i class="fas fa-home"></i>
        Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_attendances.php' ? 'active' : ''; ?>" href="all_attendances.php">
        <i class="fas fa-clock"></i>
        Attendance Records
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'leaves.php' ? 'active' : ''; ?>" href="leaves.php">
        <i class="fas fa-calendar-alt"></i>
        Leave Requests
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_users.php' ? 'active' : ''; ?>" href="all_users.php">
        <i class="fas fa-users"></i>
        Employees
      </a>
    </li>
    
    <li class="nav-item dropdown">
      <a class="nav-link" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell"></i>
        Notifications
        <?php if ($unreadCount > 0): ?>
          <span class="badge badge-danger ml-2"><?php echo $unreadCount; ?></span>
        <?php endif; ?>
      </a>
      <div class="dropdown-menu notification-dropdown" aria-labelledby="notificationDropdown">
        <h6 class="dropdown-header">Notifications</h6>
        <?php if (count($notifications) > 0): ?>
          <?php foreach ($notifications as $notification): ?>
            <a class="dropdown-item notification-item <?php echo $notification['is_read'] ? '' : 'bg-light'; ?>" 
               href="#" onclick="markAsRead(<?php echo $notification['notification_id']; ?>)">
              <?php echo $notification['message']; ?>
              <small class="text-muted d-block">
                <?php echo date('M d, Y h:i A', strtotime($notification['date_added'])); ?>
              </small>
            </a>
          <?php endforeach; ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-center" href="#" onclick="markAllAsRead()">Mark all as read</a>
        <?php else: ?>
          <div class="dropdown-item">No notifications</div>
        <?php endif; ?>
      </div>
    </li>
  </ul>

  <div class="user-section">
    <div class="user-info">
      <div class="user-avatar">
        <i class="fas fa-user"></i>
      </div>
      <div>
        <div class="user-name"><?php echo $_SESSION['username']; ?></div>
        <div class="user-role">Administrator</div>
      </div>
    </div>
    <a class="nav-link text-white-50" href="core/handleForms.php?logoutUserBtn=1">
      <i class="fas fa-sign-out-alt"></i>
      Logout
    </a>
  </div>
</div>

<div class="main-content">