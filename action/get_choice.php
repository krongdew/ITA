<?php
include 'connect.php';

// ดึงข้อมูลจากตาราง sa_choice_name
$stmt = $conn->prepare("SELECT ID, choice_name FROM sa_choice_name");
$stmt->execute();
$choiceData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ส่งออกข้อมูลเป็น JSON
header('Content-Type: application/json');
echo json_encode($choiceData);

?>
