<?php
$host = "sql200.infinityfree.com";
$db_user = "if0_42432320";
$db_pass = "pRdJsdP0oP";
$db_name = "if0_42432320_task2";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
