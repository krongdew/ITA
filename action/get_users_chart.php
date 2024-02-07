<?php
// เรียกใช้ไฟล์ connect.php เพื่อเชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';


try {
    // ปรับเปลี่ยนคิวรี SQL ใหม่เป็นคิวรีที่คุณต้องการใช้
    $sql = "SELECT sa_services.service_Access, sa_services.ID,
            SUM(CASE WHEN MONTH(Date) = 1 THEN number_people ELSE 0 END) as Jan,
            SUM(CASE WHEN MONTH(Date) = 2 THEN number_people ELSE 0 END) as Feb,
            SUM(CASE WHEN MONTH(Date) = 3 THEN number_people ELSE 0 END) as Mar,
            SUM(CASE WHEN MONTH(Date) = 4 THEN number_people ELSE 0 END) as Apr,
            SUM(CASE WHEN MONTH(Date) = 5 THEN number_people ELSE 0 END) as May,
            SUM(CASE WHEN MONTH(Date) = 6 THEN number_people ELSE 0 END) as Jun,
            SUM(CASE WHEN MONTH(Date) = 7 THEN number_people ELSE 0 END) as Jul,
            SUM(CASE WHEN MONTH(Date) = 8 THEN number_people ELSE 0 END) as Aug,
            SUM(CASE WHEN MONTH(Date) = 9 THEN number_people ELSE 0 END) as Sep,
            SUM(CASE WHEN MONTH(Date) = 10 THEN number_people ELSE 0 END) as Oct,
            SUM(CASE WHEN MONTH(Date) = 11 THEN number_people ELSE 0 END) as Nov,
            SUM(CASE WHEN MONTH(Date) = 12 THEN number_people ELSE 0 END) as `Dec`
            FROM sa_number_of_people 
            INNER JOIN sa_services ON sa_number_of_people.service_id = sa_services.ID
            GROUP BY sa_services.service_Access, sa_services.ID
            ORDER BY sa_services.service_Access, sa_services.ID";
    
    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
    $stmt = $conn->prepare($sql);
    $stmt->execute();
  
    
    // ดึงข้อมูลจากคิวรี
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ส่งข้อมูลในรูปแบบ JSON กลับไปยัง JavaScript
    echo json_encode($data);
} catch (PDOException $e) {
    // หากเกิดข้อผิดพลาดในการดึงข้อมูล
    echo json_encode(array('error' => $e->getMessage()));
}
?>
