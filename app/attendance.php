<?php
// ob_start();
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: ../login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <script src="./js/bootstrap.bundle.min.js"></script>
    <title>LSI勤怠管理</title>
    <link href="./css/style.css" rel="stylesheet">
    <title>Attendance</title>
    <style>
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body onload="getLocation()">
    <?php 
        include_once('./view/header.php'); 
    ?>
    <div class="container loading">
        <h2 class="text-info">Loading...</h2>
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="container d-flex justify-content-center hidden">
        <div class="content">
            <h1 class="text-primary">LSI勤怠管理へようこそ</h1>
            <form method="POST" action="./include/attendance_submit.php" id="attendance-form">
                <div class="row mt-3 mb-3">
                    <button type="submit" id="check_in" class="btn btn-primary" name="check_in">出勤</button>
                </div>
                <div class="row mt-3 mb-3">
                    <button type="submit" id="start_break" class="btn btn-primary" name="start_break">lunch開始</button>
                </div>
                <div class="row mt-3 mb-3">
                    <button type="submit" id="end_break" class="btn btn-primary" name="end_break">lunch終了</button>
                </div>
                <div class="row mt-3 mb-3">
                    <button type="submit" id="check_out" class="btn btn-primary" name="check_out">退勤</button>
                </div>
                <input type="hidden" name="latitude" id="latitude" value="">
                <input type="hidden" name="longitude" id="longitude" value="">

            </form>
        </div>
    </div>
    <?php 
        include_once('./view/footer.php'); 
    ?>

</body>
<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lon;
        document.querySelector('.loading').style.display = 'none';
        document.querySelector('.hidden').style.display = 'initial';
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
            case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
            case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
            case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
        }
    }
</script>
</html>
<?php //ob_end_flush(); ?>