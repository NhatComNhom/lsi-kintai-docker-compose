<?php
    include "../include/dbh.inc.php";

    // Lấy giá trị người dùng nhập vào từ form
    if(isset($_POST['employee_name']) && isset($_POST['month']) && isset($_POST['year'])) {
        $employee_name = $_POST['employee_name'];
        $month = $_POST['month'];
        $year = $_POST['year'];
    }
    // Tạo câu truy vấn SQL
    if(isset($employee_name) && isset($month) && isset($year) && !empty($employee_name) && !empty($month) && !empty($year)){
        $sql = "
            SELECT
                tbl_employees.name,
                to_char(check_time, 'DD') AS day,
                MAX(CASE WHEN action = 'check_in' THEN check_time::time END) AS check_in,
                MAX(CASE WHEN action = 'start_break' THEN check_time::time END) AS start_break,
                MAX(CASE WHEN action = 'end_break' THEN check_time::time END) AS end_break,
                MAX(CASE WHEN action = 'check_out' THEN check_time::time END) AS check_out,
                MAX(CASE WHEN action = 'check_in' THEN remote END) AS remote,
                MAX(CASE WHEN action = 'check_in' THEN latitude END) AS cin_latitude,
                MAX(CASE WHEN action = 'check_in' THEN longitude END) AS cin_longitude
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
        if (!$result || pg_num_rows($result) == 0) {
            echo "情報を確認してください";
        } else {
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['day']}</td>";
                echo "<td>{$row['check_in']}</td>";
                echo "<td>{$row['start_break']}</td>";
                echo "<td>{$row['end_break']}</td>";
                echo "<td>{$row['check_out']}</td>";
                if ($row['remote'] == 1) {
                    echo "<td>会社</td>";
                } else {
                    echo "<td>";
                    echo "<div class='row'>";
                    echo "<div class='col'>";
                    echo "<p>在宅</p>";
                    echo "</div>";
                    echo "<div class='col'>";
                    echo "<a href='https://google.com/maps?q={$row['cin_latitude']},{$row['cin_longitude']}&hl=es;14' target='_blank'>";
                    echo "<img class='location_icon' src='../image/location.png'>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</td>";
                }                
                echo "<td></td>";
                echo "</tr>";
            }
        }
        pg_close($conn);
    }

?>
