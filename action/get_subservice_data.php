<?php
include 'connect.php';

// ดึงข้อมูลจากตาราง sa_department
$stmt = $conn->prepare("SELECT ID, subservice_name FROM sa_subservices");
$stmt->execute();
$subserviceData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ส่งออกข้อมูลเป็น JSON
// header('Content-Type: application/json');
echo json_encode($subserviceData);


?>