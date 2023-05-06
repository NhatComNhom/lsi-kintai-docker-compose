<?php 
    include "../include/dbh.inc.php";

    if(isset($_POST['submit'])){
        $latitude = $_POST["lat"];
        $longitude = $_POST["lon"];

        $update = "UPDATE tbl_work_location SET latitude = $1, longitude = $2 WHERE id = 1";
        $stmt = pg_prepare($conn, "update_location", $update);
        $result = pg_execute($conn, "update_location", array($latitude, $longitude));
        if (!$result) {
            echo "Update failed: " . pg_last_error($conn);
        }

        echo "<script>alert('職場の場所を更新しました！！');window.location.href='./work_location.php';</script>";
        exit();
    }
    else {
        header('location:./work_location.php');
        exit();
    }
?>