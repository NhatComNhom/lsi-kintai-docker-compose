<?php
    include "../include/dbh.inc.php";

    // Lấy giá trị người dùng nhập vào từ form
    $employee_name = "A氏";
    $month = 05;
    $year = 2023;

    // Tạo câu truy vấn SQL
    if(isset($employee_name) && isset($month) && isset($year)){
        $sql = "
            SELECT
                tbl_employees.name,
                to_char(check_time, 'DD') AS day,
                MAX(CASE WHEN action = 'check_in' THEN check_time::time END) AS check_in,
                MAX(CASE WHEN action = 'start_break' THEN check_time::time END) AS start_break,
                MAX(CASE WHEN action = 'end_break' THEN check_time::time END) AS end_break,
                MAX(CASE WHEN action = 'check_out' THEN check_time::time END) AS check_out,
                MAX(CASE WHEN action = 'check_in' THEN CASE WHEN remote = true THEN 1 ELSE 0 END END) AS remote 
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
    }
    pg_close($conn);
?>

