<?php
    include "../include/dbh.inc.php";

    if (isset($_POST['query'])) {
        $query = $_POST['query'];
        $sql = "SELECT name FROM tbl_employees WHERE name != 'ADMIN'";
        $result = pg_query($conn, $sql);
        
        $response = array();
        while ($row = pg_fetch_assoc($result)) {
            $response[] = $row['name'];
        }
        
        echo json_encode($response);

        exit;
    }
?>
