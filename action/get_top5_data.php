<?php
include 'connect.php';

$userdepartment = isset($_GET['userdepartment']) ? $_GET['userdepartment'] : 0;

// เช็คว่ามี userDepartmentCondition หรือไม่ ถ้ามีให้ใส่เงื่อนไขที่สร้างขึ้น ไม่งั้นให้ให้เป็นค่าว่าง
$userDepartmentCondition = ($userdepartment == 0) ? '' : " AND service_Access = $userdepartment";

// คำสั่ง SQL สำหรับหาผลรวมของบริการที่มี service_id เดียวกันในเดือนปัจจุบัน และแสดงผลเพียง 5 อันดับ
$sql = "SELECT s.service_name, s.service_Access, SUM(np.number_people) AS total_users
        FROM sa_number_of_people np
        INNER JOIN sa_services s ON np.service_id = s.ID
        WHERE (MONTH(np.date) = MONTH(CURRENT_DATE()) AND YEAR(np.date) = YEAR(CURRENT_DATE())) $userDepartmentCondition
        GROUP BY np.service_id, s.service_Access
        ORDER BY total_users DESC
        LIMIT 5";

// ดึงข้อมูลจากฐานข้อมูลโดยใช้ PDO
$stmt = $conn->query($sql);

// เตรียมข้อมูลให้เป็นรูปแบบ JSON
$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// ส่งข้อมูลในรูปแบบ JSON response
header('Content-Type: application/json');
echo json_encode($data);


?>
