<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
if (isset($_SESSION['role'])&&!($_SESSION['role'])) {
  header("Location: ../index.php");
  exit();
}
include_once('./check_attendance.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/datatables.min.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.6.4.min.js"></script>
    <script src="../js/datatables.min.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <title>LSI勤怠管理ADMIN</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <h1 class="text-light">
                        LSI勤怠管理_ADMINページ
                    </h1>
                </a>
                <div class="container">
                    <div class="row justify-content-right align-self-end">
                        <ul class="navbar-nav">
                            <div class="col">
                                <li><a href='recently_action.php' class='nav-link text-light'>最近活動</a></li>
                            </div>
                            <div class="col">
                                <li><a href='attendance_table.php' class='nav-link text-light'>勤怠確認</a></li>
                            </div>
                            <div class="col">
                                <li><a href='work_location.php' class='nav-link text-light'>会社位置</a></li>
                            </div>
                            <div class="col">
                                <li><p class='text-info mt-2 ml-1'>Hello there, ADMIN</p></li>
                            </div>
                            <div class="col">
                                <li><a href='../include/logout.inc.php' class='nav-link text-light'>ログアウト</a></li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
    <div class="container d-flex bg-secondary mt-3">
        <div class="row">
            <h1 class="text-light justify-content-center">現在の職場</h1>
            <div>
                <?php
                    include "../include/dbh.inc.php";

                    // Tạo câu truy vấn SQL
                    $sql_location = "SELECT * FROM tbl_work_location";
                    $result_location = pg_query($conn, $sql_location);
                    $row_location = pg_fetch_assoc($result_location);
                    echo "<iframe src='https://google.com/maps?q={$row_location['latitude']},{$row_location['longitude']}&hl=es;14&output=embed' style='width: 100%; height: 100%'></iframe>";
                    pg_close($conn);
                ?>
            </div>
            <h1 class="text-light justify-content-center">会社の職場を更新する</h1>
            <form action="./change_work_location.php" method="post">
                <div class="container">
                    <div class="row mt-4 mb-4">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="緯度を入力" name="lat">
                        </div>
                        <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="経度を入力" name="lon">
                        </div>
                        <div class="col-md-4 justify-content-right align-self-end">
                            <button type="input" name="submit" class="btn btn-primary" id="form-submit">確認</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </main>
  <?php 
      include_once('../view/footer.php'); 
  ?>
</body>

</html>
