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
        <div class="container mt-3">
            <div class="data_table bg-light p-3">
                <h1 id="table_name" class="justify-content-center" style="display: flex; align-items: center; justify-content: center;">社員の名前と年月を入力してください</h1>
                <table id="example" class="table table-striped table-bordered table-primary" style="width:100%">
                    <thead>
                        <tr class="table-primary">
                        <th scope="col">名前</th> 
                        <th scope="col">時刻</th>
                        <th scope="col">活動</th>
                        <th scope="col">会社/在宅</th>
                        <th scope="col">備考欄</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <?php 
                            include_once('./get_recently_action.php'); 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
  </main>
  <?php 
      include_once('../view/footer.php'); 
  ?>
  <script>
    $(document).ready(function() {
        $('#example').DataTable({
            ordering: false
        });
    });

  </script>
</body>

</html>
