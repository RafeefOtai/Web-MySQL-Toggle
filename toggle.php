<?php
require "config.php";
header("Content-Type: application/json");

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

if ($id > 0) {
    // Read current status
    $stmt = $conn->prepare("SELECT status FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    $newStatus = $status == 1 ? 0 : 1;

    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStatus, $id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(["success" => true, "id" => $id, "status" => $newStatus]);
} else {
    echo json_encode(["success" => false]);
}
