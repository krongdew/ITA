<?php
// เรียกใช้ไฟล์ connect.php เพื่อเชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

$userdepartment = isset($_GET['userdepartment']) ? $_GET['userdepartment'] : 0;
// เช็คว่ามี userDepartmentCondition หรือไม่ ถ้ามีให้ใส่เงื่อนไขที่สร้างขึ้น ไม่งั้นให้ให้เป็นค่าว่าง
$userDepartmentCondition = ($userdepartment == 0) ? '' : " AND service_Access = $userdepartment";



try {
    if($userdepartment == 0){
        
    $sql = "SELECT SUM(number_people) AS total_respondents FROM sa_number_of_people WHERE DATE_FORMAT(Date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";
    
    $sql2 = "SELECT COUNT(service_id) AS total_person FROM sa_respondent WHERE DATE_FORMAT(SubmissionDate, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";  
     
    }else {
        
    $sql = "SELECT s.service_Access, SUM(number_people) AS total_respondents 
    FROM sa_number_of_people np
    INNER JOIN sa_services s ON np.service_id = s.ID 
    WHERE DATE_FORMAT(Date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') $userDepartmentCondition
    ";
    
     $sql2 = "SELECT COUNT(service_id) AS total_person FROM sa_respondent r
     INNER JOIN sa_services s ON r.service_id = s.ID 
     WHERE DATE_FORMAT(SubmissionDate, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')  $userDepartmentCondition";
    }
    
    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
    $stmt = $conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_respondents = isset($result['total_respondents']) ? $result['total_respondents'] : 0;
    
    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
    $stmt2 = $conn->query($sql2);
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $total_person = isset($result2['total_person']) ? $result2['total_person'] : 0;
    
    // คำนวณผลรวม
    $total = $total_respondents + $total_person;
    
    // ส่งค่าจำนวนผู้ทำแบบประเมินกลับไปยัง JavaScript
    echo json_encode(array('total' => $total));
    
} catch (PDOException $e) {
    // หากเกิดข้อผิดพลาดในการดึงข้อมูล
    echo json_encode(array('error' => $e->getMessage()));
}
?>
