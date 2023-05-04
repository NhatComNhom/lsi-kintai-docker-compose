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
  <script src="../js/pdfmake.min.js"></script>
  <script src="../js/vfs_fonts.js"></script>
  <script src="../js/custom.js"></script>
  <title>LSI勤怠管理ADMIN</title>
</head>
<body>
<header>
  <nav class="navbar navbar-expand-sm">
      <div class="container d-flex">
          <a class="navbar-brand" href="#">
              <h1 class="text-light">
                  LSI勤怠管理_ADMINページ
              </h1>
          </a>
          <div class="collapse navbar-collapse justify-content-end" id="navBarHeader">
              <ul class="navbar-nav ">
                  <?php
                      if (isset($_SESSION["username"])){
                          echo "<li class='nav-item'><p class='text-info mt-2 ml-1'>Hello there, ".$_SESSION["name"]."</p></li>";
                          echo "<li class='nav-item'><a href='../include/logout.inc.php' class='nav-link text-light'>ログアウト</a></li>";
                      } else  {
                          echo "<li class='nav-item'><a href='../login.php' class='nav-link text-light'>ログイン</a></li>";
                      }
                  ?>
              </ul>
          </div>
      </div>
  </nav>
  </header>
  <main>
        <h2 class="text-light">
          this is admin page!!
        </h2>
        <h1><?php echo $employee_name ?> - <?php echo $month ?>/<?php echo $year ?></h1>
        <div class="container">
            <div class="data_table">
                <table id="example" class="table table-striped table-bordered table-primary" style="width:100%">
                    <thead class="bg-light">
                        <tr class="table-primary">
                        <th scope="col">日付曜日</th>
                        <th scope="col">出勤</th>
                        <th scope="col">lunch開始</th>
                        <th scope="col">lunch終了</th>
                        <th scope="col">退勤</th>
                        <th scope="col">会社/在宅</th>
                        <th scope="col">備考欄</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = pg_fetch_assoc($result)): ?>
                        <tr>
                        <td><?php echo $row['day'] ?></td>
                        <td><?php echo $row['check_in'] ?></td>
                        <td><?php echo $row['start_break'] ?></td>
                        <td><?php echo $row['end_break'] ?></td>
                        <td><?php echo $row['check_out'] ?></td>
                        <td><?php echo $row['remote']==1?'会社':'在宅' ?></td>
                        <td></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

  </main>
  <?php 
      include_once('../view/footer.php'); 
  ?>
</body>
</html>
