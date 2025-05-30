<?php  

require_once 'dbConfig.php';


// User entity

function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM attendance_system_users WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO attendance_system_users (username, first_name, last_name, is_admin, password) 
		VALUES (?,?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, false, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM attendance_system_users";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

// Attendance Entity

function insertNewAttendance($pdo, $user_id, $attendance_type, $date_added) {
	$sql = "INSERT INTO attendance_records 
			(user_id, attendance_type, date_added) 
			VALUES (?,?,?)";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$user_id, $attendance_type, $date_added]);
}

function checkIfTimeInOrOutAlready($pdo, $user_id, $attendance_type, $date_today) {

	$sql = "SELECT * FROM attendance_records WHERE attendance_type = ? AND date_added = ? AND user_id = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$attendance_type, $date_today, $user_id])) {
		if ($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
}

function getTimeInOrOutForToday($pdo, $user_id, $date_today, $attendance_type) {
	$sql = "SELECT * FROM attendance_records WHERE 
			user_id = ? AND date_added = ? 
			AND attendance_type = ?";
			
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id, $date_today, $attendance_type]);
	return $stmt->fetch();
}


// Leaves entity

function getLeavesByUserId($pdo, $user_id) {
	$sql = "SELECT * FROM leaves WHERE user_id = ? 
			ORDER BY date_added DESC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id]);
	return $stmt->fetchAll();
}

function insertNewLeave($pdo, $description, $user_id, $date_start, $date_end) {
	$sql = "INSERT INTO leaves (description, user_id, date_start, date_end) 
			VALUES (?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$description, $user_id, $date_start, $date_end]);
}

function updateLeaveDescription($pdo, $description, $date_start, $date_end, $leave_id) {
	$sql = "UPDATE leaves SET description = ?, date_start = ?, date_end = ? 
			WHERE leave_id = ?";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$description, $date_start, $date_end, $leave_id]);
}

function deleteLeave($pdo, $leave_id) {
	$sql = "DELETE FROM leaves WHERE leave_id = ?";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$leave_id]);	
}

// Notification functions
function createNotification($pdo, $user_id, $message, $related_to, $related_id) {
	$sql = "INSERT INTO notifications (user_id, message, related_to, related_id) 
			VALUES (?, ?, ?, ?)";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$user_id, $message, $related_to, $related_id]);
}

function getNotificationsForUser($pdo, $user_id, $limit = 5) {
	$sql = "SELECT * FROM notifications 
			WHERE user_id = ? 
			ORDER BY date_added DESC
			LIMIT " . intval($limit);
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id]);
	return $stmt->fetchAll();
}

function getAllNotificationsForUser($pdo, $user_id) {
	$sql = "SELECT * FROM notifications 
			WHERE user_id = ? 
			ORDER BY date_added DESC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id]);
	return $stmt->fetchAll();
}

function markNotificationAsRead($pdo, $notification_id) {
	$sql = "UPDATE notifications SET is_read = TRUE WHERE notification_id = ?";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$notification_id]);
}

function markAllNotificationsAsRead($pdo, $user_id) {
	$sql = "UPDATE notifications SET is_read = TRUE WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$user_id]);
}

function countUnreadNotifications($pdo, $user_id) {
	$sql = "SELECT COUNT(*) as count FROM notifications 
			WHERE user_id = ? AND is_read = FALSE";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id]);
	$result = $stmt->fetch();
	return $result['count'];
}

function createLeaveNotificationForAdmins($pdo, $leave_id, $employee_name) {
	// Get all admin users
	$sql = "SELECT user_id FROM attendance_system_users WHERE is_admin = 1";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$admins = $stmt->fetchAll();
	
	$message = "New leave request from " . $employee_name;
	
	// Create notification for each admin
	foreach ($admins as $admin) {
		createNotification($pdo, $admin['user_id'], $message, 'leave', $leave_id);
	}
}
