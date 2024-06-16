<?php
session_start();

// Check if user is logged in and user_id is set in session
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['user_id'])) {
    echo 'User not logged in or user ID not found';
    exit();
}

require_once "dbcon.php"; // Assuming dbcon.php contains your database connection

// Sanitize inputs
$user_id = $_SESSION['user_id'];
$full_name = htmlspecialchars($_POST['full_name']);
$check_in = $_POST['check_in_date'];
$check_out = $_POST['check_out_date'];
$room_id = $_POST['room_id']; // Assuming room_id is sent via POST

// Validate room_id exists in rooms table
$sql_check_room = "SELECT COUNT(*) AS count FROM rooms WHERE room_id = ?";
$stmt_check_room = $conn->prepare($sql_check_room);
$stmt_check_room->bind_param("i", $room_id);
$stmt_check_room->execute();
$result_check_room = $stmt_check_room->get_result();
$row_check_room = $result_check_room->fetch_assoc();

if ($row_check_room['count'] == 0) {
    echo 'Invalid room ID'; // Handle case where room_id doesn't exist
    exit();
}

// Prepare SQL statement for reservation insertion
$sql_insert_reservation = "INSERT INTO reservation (user_id, room_id, check_in, check_out, full_name)
                           VALUES (?, ?, ?, ?, ?)";

$stmt_insert_reservation = $conn->prepare($sql_insert_reservation);
$stmt_insert_reservation->bind_param("iisss", $user_id, $room_id, $check_in, $check_out, $full_name);

// Execute SQL statement
if ($stmt_insert_reservation->execute()) {
    header("Location: rooms.php");
} else {
    echo 'Error: ' . $stmt_insert_reservation->error;
}

// Close statements and connection
$stmt_insert_reservation->close();
$stmt_check_room->close();
$conn->close();
?>
