<?php
    include "../include/dbh.inc.php";

    // Tạo câu truy vấn SQL
    $sql = "
        SELECT 
            tbl_employees.name AS name,
            check_time AS time,
            (CASE 
                WHEN action = 'check_in' THEN '出勤'
                WHEN action = 'check_out' THEN '退勤'
                WHEN action = 'start_break' THEN 'lunch開始'
                WHEN action = 'end_break' THEN 'lunch終了'
            END) AS action,
            (CASE WHEN remote = true THEN 1 ELSE 0 END) AS remote,
            latitude,
            longitude
        FROM tbl_checkinout 
        INNER JOIN tbl_employees ON tbl_checkinout.user_id = tbl_employees.id
        ORDER BY check_id desc LIMIT 30;
    ";

    // Thực hiện truy vấn SQL
    $result = pg_query($conn, $sql);
    if (!$result || pg_num_rows($result) == 0) {
        echo "情報を確認してください";
    } else {
        while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['time']}</td>";
            echo "<td>{$row['action']}</td>";
            if ($row['remote'] == 1) {
                echo "<td>会社</td>";
            } else {
                echo "<td>";
                echo "<div class='row'>";
                echo "<div class='col'>";
                echo "<p>在宅</p>";
                echo "</div>";
                echo "<div class='col'>";
                echo "<a href='https://google.com/maps?q={$row['latitude']},{$row['longitude']}&hl=es;14' target='_blank'>";
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

?>
