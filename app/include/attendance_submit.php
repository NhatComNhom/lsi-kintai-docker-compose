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
    $date = date("H:i:s");
    $time = date('H:i');
    // Check connection
    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }

    // Get user ID from session
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM tbl_employees WHERE username='$username'";
    $result = pg_query($conn, $sql);
    $row = pg_fetch_assoc($result);
    $user_id = $row['id'];

    // Get GPS coordinates
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    //get kaisha GPS coordinates
    $sql_location = "SELECT * FROM tbl_work_location";
    $result_location = pg_query($conn, $sql_location);
    $row_location = pg_fetch_assoc($result_location);
    $centerLat = $row_location['latitude'];
    $centerLng = $row_location['longitude'];
    $radiusInMeters = $row_location['radiusinmeters'];

    //check location 
    $distance = 6371000 * acos(cos(deg2rad($centerLat)) * cos(deg2rad($latitude)) * cos(deg2rad($longitude) - deg2rad($centerLng)) + sin(deg2rad($centerLat)) * sin(deg2rad($latitude)));
    $remote = $distance <= $radiusInMeters ? true : false;
    $remote_bool = boolval($remote);

    // Insert attendance record into database
    $sql = "INSERT INTO tbl_checkinout (user_id, action, check_time, latitude, longitude, remote) VALUES ('$user_id', '$action', '$datetime', '$latitude', '$longitude', '$remote_bool')";

    if (pg_query($conn, $sql)) {
        $_SESSION['message'] = "Attendance recorded successfully.";
    } else {
        $_SESSION['message'] = "Error: " . pg_last_error($conn);
    }

    $return_message = "";
    //Redirect to attendance page
    if (isset($_POST['check_in'])) {
        $return_message = "出勤しました。時刻は".$time."です。";
    } elseif (isset($_POST['start_break'])) {
        $return_message = "lunch開始しました。時刻は".$time."です。";
    } elseif (isset($_POST['end_break'])) {
        $return_message = "lunch終了しました。時刻は".$time."です。";
    } elseif (isset($_POST['check_out'])) {
        $return_message = "退勤しました。時刻は".$time."です。";
    }
    if (!$remote_bool) {
        $return_message = $return_message."テレワーク中、距離は ".$distance;
    } else {
        $return_message = $return_message."テレワークなし、距離は ".$distance;
    }
    pg_close($conn);

    echo "<script>alert('{$return_message}');window.location.href='../attendance.php';</script>";
    // Close database connection
    exit();
?>
