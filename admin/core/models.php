<?php  

require_once 'dbConfig.php';

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

		if ($stmt->execute([$username, $first_name, $last_name, true, $password])) {
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

function getAllEmployees($pdo) {
	$sql = "SELECT * FROM attendance_system_users 
			WHERE is_admin = 0";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function getAllDates($pdo) {
	$sql = "SELECT DISTINCT date_added FROM attendance_records ORDER BY date_added DESC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function getAllAttendancesByDate($pdo, $date_today) {
	$sql = "SELECT 
				attendance_system_users.first_name AS first_name, 
				attendance_system_users.last_name AS last_name,
				attendance_records.attendance_type AS attendance_type,
				attendance_records.timestamp_record_added AS timestamp_record_added
			FROM attendance_system_users
			JOIN attendance_records ON 
			attendance_system_users.user_id = attendance_records.user_id 
			WHERE attendance_records.date_added = ?
			ORDER BY 
				attendance_system_users.last_name 
			";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$date_today]);
	return $stmt->fetchAll();
}

function getUsersWithIncompleteAttendance($pdo, $date_today) {
	$sql = "SELECT
			  attendance_system_users.user_id AS user_id,
			  attendance_system_users.username AS username,
			  attendance_system_users.first_name AS first_name,
			  attendance_system_users.last_name AS last_name
			FROM attendance_system_users
			LEFT JOIN attendance_records
			  ON attendance_system_users.user_id = attendance_records.user_id
			  AND attendance_records.date_added = ?
			WHERE
			  attendance_records.user_id IS NULL 
			  AND attendance_system_users.is_admin = 0";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$date_today]);
	return $stmt->fetchAll();
}

function getAllLeaves($pdo) {
	$sql = "SELECT 
				attendance_system_users.first_name AS first_name,
				attendance_system_users.last_name AS last_name,
				leaves.leave_id AS leave_id,
				leaves.description AS description,
				leaves.date_start AS date_start,
				leaves.date_end AS date_end,
				leaves.date_added AS date_added,
				leaves.status AS status
			FROM attendance_system_users
			JOIN leaves ON 
				attendance_system_users.user_id = leaves.user_id
			ORDER BY leaves.date_added DESC
			";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function updateLeaveStatus($pdo, $status, $leave_id) {
	$sql = "UPDATE leaves SET status = ? WHERE leave_id = ?";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$status, $leave_id]);
}

function getAttendancesByDateGrouped($pdo, $date_today) {
	$sql = "SELECT 
				attendance_system_users.user_id AS user_id,
				attendance_system_users.first_name AS first_name, 
				attendance_system_users.last_name AS last_name,
				MAX(CASE WHEN attendance_records.attendance_type = 'time_in' THEN attendance_records.timestamp_record_added ELSE NULL END) AS time_in,
				MAX(CASE WHEN attendance_records.attendance_type = 'time_out' THEN attendance_records.timestamp_record_added ELSE NULL END) AS time_out
			FROM attendance_system_users
			LEFT JOIN attendance_records ON 
				attendance_system_users.user_id = attendance_records.user_id 
				AND attendance_records.date_added = ?
			WHERE attendance_system_users.is_admin = 0
			GROUP BY 
				attendance_system_users.user_id,
				attendance_system_users.first_name,
				attendance_system_users.last_name
			ORDER BY 
				attendance_system_users.last_name
			";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$date_today]);
	return $stmt->fetchAll();
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

function createLeaveStatusNotification($pdo, $user_id, $leave_id, $status) {
	$message = "Your leave request has been " . strtolower($status);
	return createNotification($pdo, $user_id, $message, 'leave_status', $leave_id);
}
