<?php
include 'connect.php';

// ดึงข้อมูลจากตาราง sa_department
$stmt = $conn->prepare("SELECT ID, name_surname FROM sa_users");
$stmt->execute();
$userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ส่งออกข้อมูลเป็น JSON
// header('Content-Type: application/json');
echo json_encode($userData);


?>