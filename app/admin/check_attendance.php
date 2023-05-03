<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Trang của tôi</title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    
    <?php

    include "../include/dbh.inc.php";

    // Lấy giá trị người dùng nhập vào từ form
    $employee_name = "A氏";
    $month = 05;
    $year = 2023;

    // Tạo câu truy vấn SQL
    $sql = "
        SELECT
            tbl_employees.name,
            to_char(check_time, 'DD') AS day,
            MAX(CASE WHEN action = 'check_in' THEN check_time::time END) AS check_in,
            MAX(CASE WHEN action = 'start_break' THEN check_time::time END) AS start_break,
            MAX(CASE WHEN action = 'end_break' THEN check_time::time END) AS end_break,
            MAX(CASE WHEN action = 'check_out' THEN check_time::time END) AS check_out
        FROM tbl_checkinout
        INNER JOIN tbl_employees ON tbl_checkinout.user_id = tbl_employees.id
        WHERE tbl_employees.name = '$employee_name'
            AND EXTRACT(MONTH FROM check_time) = $month
            AND EXTRACT(YEAR FROM check_time) = $year
        GROUP BY tbl_employees.id, to_char(check_time, 'DD')
        ORDER BY to_char(check_time, 'DD') ASC;
    ";

    // Thực hiện truy vấn SQL
    $result = pg_query($conn, $sql);

    // Tạo bảng điểm danh
    echo "<h1>$employee_name - $month/$year</h1>";
    echo "<div class='table-responsive-lg'>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>Ngày</th><th>Check in</th><th>Bắt đầu giờ nghỉ</th><th>Kết thúc giờ nghỉ</th><th>Check out</th></tr></thead>";
    echo "<tbody>";
    while ($row = pg_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['day']}</td>";
    echo "<td>{$row['check_in']}</td>";
    echo "<td>{$row['start_break']}</td>";
    echo "<td>{$row['end_break']}</td>";
    echo "<td>{$row['check_out']}</td>";
    echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    pg_close($conn);
    ?>
</body>
</html>
