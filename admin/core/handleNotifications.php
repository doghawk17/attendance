<?php
require_once 'dbConfig.php';
require_once 'models.php';

// Handle marking a notification as read
if (isset($_POST['action']) && $_POST['action'] == 'mark_read' && isset($_POST['notification_id'])) {
    $notification_id = $_POST['notification_id'];
    markNotificationAsRead($pdo, $notification_id);
    echo json_encode(['success' => true]);
}

// Handle marking all notifications as read
if (isset($_POST['action']) && $_POST['action'] == 'mark_all_read' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    markAllNotificationsAsRead($pdo, $user_id);
    echo json_encode(['success' => true]);
}
