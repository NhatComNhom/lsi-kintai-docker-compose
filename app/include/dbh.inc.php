<?php
$servername = "db";
$username = "lsi";
$password = "lsilsilsi";
$dbname = "lsi_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
mysqli_select_db($conn,$dbname);
?> 