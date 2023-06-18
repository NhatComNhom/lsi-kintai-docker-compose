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
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col-md-4">
                    <select class="form-control" id="employee_name" name="employee_name"></select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="month" name="month">
                        <option value="" disabled selected>月</option>
                    <?php for ($i=1; $i<=12; $i++) {
                        $selected = $i;
                        printf('<option value="%02d" %s>%02d</option>', $i, $selected, $i);
                    } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="year" name="year">
                    <option value="" disabled selected>年</option>
                    <?php for ($i=date("Y"); $i>=2010; $i--) {
                        $selected = $i;
                        printf('<option value="%d" %s>%d</option>', $i, $selected, $i);
                    } ?>
                    </select>
                </div>
                <div class="col-md-2 justify-content-right">
                    <button type="submit" onclick="getInfo()" id="check" class="btn btn-primary" name="check">検索</button>
                </div>
            </div>
            <div class="data_table bg-light p-3">
                <h1 id="table_name" class="justify-content-center" style="display: flex; align-items: center; justify-content: center;">社員の名前と年月を入力してください</h1>
                <table id="example" class="table table-striped table-bordered table-primary" style="width:100%">
                    <thead>
                        <tr class="table-primary">
                        <th scope="col">日付曜日</th>
                        <th scope="col">出勤</th>
                        <th scope="col">lunch開始</th>
                        <th scope="col">lunch終了</th>
                        <th scope="col">退勤</th>
                        <th scope="col">位置情報</th>
                        <th scope="col">備考欄</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
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
        $.ajax({
            url: 'get_employee.php',
            method: 'POST',
            data: {query:''},
            dataType: 'json',
            success: function(data) {
                $('#employee_name').empty();
                if (data.length > 0) {
                    $.each(data, function(index, value) {
                        $('#employee_name').append('<option value="'+value+'">'+value+'</option>');
                    });
                } else {
                    $('#employee_name').append('<option value="">データなし</option>');
                }
            }
        });
    });


    function getInfo() {
        let employee_name = document.getElementById("employee_name").value;
        let month = document.getElementById("month").value;
        let year = document.getElementById("year").value;
        let table_name = year + month + "_" + employee_name;

        $.ajax({
            url: "check_attendance.php",
            method: "POST",
            data: {employee_name: employee_name, month: month, year: year},
            success: function(data) {
                // xử lý kết quả trả về
                var table = $('#example').DataTable();
                table.destroy();
                $("#table_body").html(data);
                if (data != 0){
                    $("#table_name").html(
                    table_name
                    );
                }
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            filename: table_name
                        },{
                            extend: 'excel',
                            filename: table_name
                        }
                    ],
                    searching: false, // tắt tính năng search
                    lengthChange: false, // tắt tính năng show entries
                    pageLength: 10, // thiết lập số entries mặc định là 10
                });
            },
            error: function(xhr, status, error) {
                // xử lý lỗi nếu có
                console.log(error);
            }
        });
    }

</script>
</body>

</html>
