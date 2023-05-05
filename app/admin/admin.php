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
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: ['csv', 'excel', 'pdf', 'print'],
                searching: false, // tắt tính năng search
                lengthChange: false, // tắt tính năng show entries
                pageLength: 10 // thiết lập số entries mặc định là 10
            });
        });

    </script>
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
                    <li class='nav-item'><p class='text-info mt-2 ml-1'>Hello there, ADMIN</p></li>";
                    <li class='nav-item'><a href='../include/logout.inc.php' class='nav-link text-light'>ログアウト</a></li>";
                </ul>
            </div>
        </div>
    </nav>
    </header>
    <main>
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="社員の名前">
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="month" name="month">
                        <option value="" disabled selected>月</option>
                    <?php for ($i=1; $i<=12; $i++) {
                        //$selected = ($i == $month) ? 'selected' : '';
                        $selected = $i;
                        printf('<option value="%02d" %s>%02d</option>', $i, $selected, $i);
                    } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="year" name="year">
                    <option value="" disabled selected>年</option>
                    <?php for ($i=date("Y"); $i>=2010; $i--) {
                        //$selected = ($i == $year) ? 'selected' : '';
                        $selected = $i;
                        printf('<option value="%d" %s>%d</option>', $i, $selected, $i);
                    } ?>
                    </select>
                </div>
                <div class="col-md-2 justify-content-right align-self-end">
                    <button type="submit" id="check" class="btn btn-primary" name="check">検索</button>
                </div>
            </div>
            <div id="table_result">
                <div class="data_table">
                    <h1 class="justify-content-center" style="display: flex; align-items: center; justify-content: center;"><?php echo $employee_name ?> - <?php echo $month ?>/<?php echo $year ?></h1>
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

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
  </main>
  <?php 
      include_once('../view/footer.php'); 
  ?>
</body>
</html>
