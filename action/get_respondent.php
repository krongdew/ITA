<?php
// เรียกใช้ไฟล์ connect.php เพื่อเชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

try {
    // เตรียมคำสั่ง SQL สำหรับการนับจำนวนแถวในตาราง sa_respondent
    $sql = "SELECT COUNT(*) AS total_respondents FROM sa_respondent";
    
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
