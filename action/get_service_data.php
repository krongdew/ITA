<?php
include 'connect.php';

// ดึงข้อมูลจากตาราง sa_department
$stmt = $conn->prepare("SELECT ID, service_name FROM sa_services");
$stmt->execute();
$serviceData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ส่งออกข้อมูลเป็น JSON
// header('Content-Type: application/json');
echo json_encode($serviceData);


?>