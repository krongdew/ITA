<?php
// เรียกใช้ไฟล์ connect.php เพื่อเชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

$userdepartment = isset($_GET['userdepartment']) ? $_GET['userdepartment'] : 0;
// เช็คว่ามี userDepartmentCondition หรือไม่ ถ้ามีให้ใส่เงื่อนไขที่สร้างขึ้น ไม่งั้นให้ให้เป็นค่าว่าง
$userDepartmentCondition = ($userdepartment == 0) ? '' : " AND service_Access = $userdepartment";

try {
    if ($userdepartment == 0) {
        $sql = "SELECT SUM(number_people) AS total_respondents 
                FROM sa_number_of_people 
                WHERE YEAR(Date) = YEAR(CURDATE())";
    } else {
        $sql = "SELECT s.service_Access, SUM(number_people) AS total_respondents 
                FROM sa_number_of_people np
                INNER JOIN sa_services s ON np.service_id = s.ID 
                WHERE YEAR(Date) = YEAR(CURDATE()) $userDepartmentCondition";
    }
    
    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
    $stmt = $conn->query($sql);
    
    // ดึงข้อมูลจำนวนผู้ทำแบบประเมิน
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // ส่งค่าจำนวนผู้ทำแบบประเมินกลับไปยัง JavaScript
    echo json_encode($result);
} catch (PDOException $e) {
    // หากเกิดข้อผิดพลาดในการดึงข้อมูล
    echo json_encode(array('error' => $e->getMessage()));
}
?>
