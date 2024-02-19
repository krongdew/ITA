<?php
// เรียกใช้ไฟล์ connect.php เพื่อเชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

$userdepartment = isset($_GET['userdepartment']) ? $_GET['userdepartment'] : 0;
$selectedYear = isset($_GET['selectedYear']) ? intval($_GET['selectedYear']) : date('Y'); // ในกรณีที่ไม่ได้รับค่าให้ใช้ปีปัจจุบัน


// เช็คว่ามี userDepartmentCondition หรือไม่ ถ้ามีให้ใส่เงื่อนไขที่สร้างขึ้น ไม่งั้นให้ให้เป็นค่าว่าง
$userDepartmentCondition = ($userdepartment == 0) ? '' : "AND service_Access = $userdepartment";

try {



    // ปรับเปลี่ยนคิวรี SQL ใหม่เป็นคิวรีที่คุณต้องการใช้
    $sql = "SELECT sa_services.service_Access, sa_services.ID,sa_services.service_name,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 1 THEN sa_number_of_people.number_people ELSE 0 END) AS Jan,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 2 THEN sa_number_of_people.number_people ELSE 0 END) AS Feb,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 3 THEN sa_number_of_people.number_people ELSE 0 END) AS Mar,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 4 THEN sa_number_of_people.number_people ELSE 0 END) AS Apr,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 5 THEN sa_number_of_people.number_people ELSE 0 END) AS May,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 6 THEN sa_number_of_people.number_people ELSE 0 END) AS Jun,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 7 THEN sa_number_of_people.number_people ELSE 0 END) AS Jul,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 8 THEN sa_number_of_people.number_people ELSE 0 END) AS Aug,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 9 THEN sa_number_of_people.number_people ELSE 0 END) AS Sep,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 10 THEN sa_number_of_people.number_people ELSE 0 END) AS Oct,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 11 THEN sa_number_of_people.number_people ELSE 0 END) AS Nov,
    SUM(CASE WHEN MONTH(sa_number_of_people.Date) = 12 THEN sa_number_of_people.number_people ELSE 0 END) AS `Dec`
    FROM sa_number_of_people 
    INNER JOIN sa_services ON sa_number_of_people.service_id = sa_services.ID
    WHERE (YEAR(sa_number_of_people.Date) = :selectedYear) $userDepartmentCondition
    GROUP BY sa_services.service_Access, sa_services.ID
    ORDER BY sa_services.service_Access, sa_services.ID";;

    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':selectedYear', $selectedYear);
    $stmt->execute();


    // ดึงข้อมูลจากคิวรี
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ส่งข้อมูลในรูปแบบ JSON กลับไปยัง JavaScript
    echo json_encode($data);
} catch (PDOException $e) {
    // หากเกิดข้อผิดพลาดในการดึงข้อมูล
    echo json_encode(array('error' => $e->getMessage()));
}
