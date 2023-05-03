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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>    
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
        <?php 
            include_once('./check_attendance.php'); 
        ?>
  </main>
  <?php 
      include_once('../view/footer.php'); 
  ?>
</body>
</html>
