<?php
// Start session
session_start();

include "dbh.inc.php";

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Get action from button pressed
if (isset($_POST['check_in'])) {
    $action = "check_in";
} elseif (isset($_POST['start_break'])) {
    $action = "start_break";
} elseif (isset($_POST['end_break'])) {
    $action = "end_break";
} elseif (isset($_POST['check_out'])) {
    $action = "check_out";
} else {
    header("Location: ../attendance.php");
    exit();
}

// Get location from dropdown
//$location = $_POST['location'];

// Get current date and time
$datetime = date("Y-m-d H:i:s");
$time = date("H:i");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user ID from session
$username = $_SESSION['username'];
$sql = "SELECT id FROM tbl_employees WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$user_id = $row['id'];

// Get GPS coordinates
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Insert attendance record into database
$sql = "INSERT INTO tbl_checkinout (user_id, action, check_time, latitude, longitude) VALUES ('$user_id', '$action', '$datetime', '$latitude', '$longitude')";

if (mysqli_query($conn, $sql)) {
    $_SESSION['message'] = "Attendance recorded successfully.";
} else {
    $_SESSION['message'] = "Error: " . mysqli_error($conn);
}

//Redirect to attendance page
if (isset($_POST['check_in'])) {
    echo "check_in Successfully at ".$time."! Location is latitude = ".$latitude." and longitude = ".$longitude;
} elseif (isset($_POST['start_break'])) {
    echo "start_break Successfully at ".$time."! Location is latitude = ".$latitude." and longitude = ".$longitude;
} elseif (isset($_POST['end_break'])) {
    echo "end_break Successfully at ".$time."! Location is latitude = ".$latitude." and longitude = ".$longitude;
} elseif (isset($_POST['check_out'])) {
    echo "check_out Successfully at ".$time."! Location is latitude = ".$latitude." and longitude = ".$longitude;
}

echo '"<iframe src="https://google.com/maps?q='.$latitude.','.$longitude.'&hl=es;14&output=embed" style="width: 100%; height: 100%"></iframe>';
// Close database connection
mysqli_close($conn);
exit();
?>
