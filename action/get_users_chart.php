<?php
// เรียกใช้ไฟล์ connect.php เพื่อเชื่อมต่อกับฐานข้อมูล
require_once 'connect.php';

$userdepartment = isset($_GET['userdepartment']) ? $_GET['userdepartment'] : 0;
$selectedYear = isset($_GET['selectedYear']) ? intval($_GET['selectedYear']) : date('Y'); // ในกรณีที่ไม่ได้รับค่าให้ใช้ปีปัจจุบัน


// เช็คว่ามี userDepartmentCondition หรือไม่ ถ้ามีให้ใส่เงื่อนไขที่สร้างขึ้น ไม่งั้นให้ให้เป็นค่าว่าง
$userDepartmentCondition = ($userdepartment == 0) ? '' : "AND service_Access = $userdepartment";

try {



    // ปรับเปลี่ยนคิวรี SQL ใหม่เป็นคิวรีที่คุณต้องการใช้
    $query = "
    SELECT 
        sa_services.service_Access, 
        sa_services.ID, 
        sa_services.service_name, 
        sa_services.service_ea,
        COALESCE(num_people.Jan, 0) + COALESCE(respondents.Jan, 0) as Jan,
        COALESCE(num_people.Feb, 0) + COALESCE(respondents.Feb, 0) as Feb,
        COALESCE(num_people.Mar, 0) + COALESCE(respondents.Mar, 0) as Mar,
        COALESCE(num_people.Apr, 0) + COALESCE(respondents.Apr, 0) as Apr,
        COALESCE(num_people.May, 0) + COALESCE(respondents.May, 0) as May,
        COALESCE(num_people.Jun, 0) + COALESCE(respondents.Jun, 0) as Jun,
        COALESCE(num_people.Jul, 0) + COALESCE(respondents.Jul, 0) as Jul,
        COALESCE(num_people.Aug, 0) + COALESCE(respondents.Aug, 0) as Aug,
        COALESCE(num_people.Sep, 0) + COALESCE(respondents.Sep, 0) as Sep,
        COALESCE(num_people.Oct, 0) + COALESCE(respondents.Oct, 0) as Oct,
        COALESCE(num_people.Nov, 0) + COALESCE(respondents.Nov, 0) as Nov,
        COALESCE(num_people.Dec, 0) + COALESCE(respondents.Dec, 0) as `Dec`
    FROM 
        sa_services
    LEFT JOIN (
        SELECT 
            service_id,
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
        FROM 
            sa_number_of_people
        WHERE 
            YEAR(Date) = :selectedYear OR (MONTH(Date) BETWEEN MONTH(:startMonth) AND MONTH(:endMonth))
        GROUP BY 
            service_id
    ) num_people ON sa_services.ID = num_people.service_id
    LEFT JOIN (
        SELECT 
            service_id,
            SUM(CASE WHEN MONTH(SubmissionDate) = 1 THEN 1 ELSE 0 END) as Jan,
            SUM(CASE WHEN MONTH(SubmissionDate) = 2 THEN 1 ELSE 0 END) as Feb,
            SUM(CASE WHEN MONTH(SubmissionDate) = 3 THEN 1 ELSE 0 END) as Mar,
            SUM(CASE WHEN MONTH(SubmissionDate) = 4 THEN 1 ELSE 0 END) as Apr,
            SUM(CASE WHEN MONTH(SubmissionDate) = 5 THEN 1 ELSE 0 END) as May,
            SUM(CASE WHEN MONTH(SubmissionDate) = 6 THEN 1 ELSE 0 END) as Jun,
            SUM(CASE WHEN MONTH(SubmissionDate) = 7 THEN 1 ELSE 0 END) as Jul,
            SUM(CASE WHEN MONTH(SubmissionDate) = 8 THEN 1 ELSE 0 END) as Aug,
            SUM(CASE WHEN MONTH(SubmissionDate) = 9 THEN 1 ELSE 0 END) as Sep,
            SUM(CASE WHEN MONTH(SubmissionDate) = 10 THEN 1 ELSE 0 END) as Oct,
            SUM(CASE WHEN MONTH(SubmissionDate) = 11 THEN 1 ELSE 0 END) as Nov,
            SUM(CASE WHEN MONTH(SubmissionDate) = 12 THEN 1 ELSE 0 END) as `Dec`
        FROM 
            sa_respondent
        WHERE 
            YEAR(SubmissionDate) = :selectedYear OR (MONTH(SubmissionDate) BETWEEN MONTH(:startMonth) AND MONTH(:endMonth))
        GROUP BY 
            service_id
    ) respondents ON sa_services.ID = respondents.service_id
    WHERE 
        1 $userDepartmentCondition
    ORDER BY 
        sa_services.service_Access, sa_services.ID";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':selectedYear', $selectedYear);
        $stmt->bindParam(':startMonth', $startMonth);
        $stmt->bindParam(':endMonth', $endMonth);
        $stmt->execute();


    // ดึงข้อมูลจากคิวรี
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ส่งข้อมูลในรูปแบบ JSON กลับไปยัง JavaScript
    echo json_encode($data);
} catch (PDOException $e) {
    // หากเกิดข้อผิดพลาดในการดึงข้อมูล
    echo json_encode(array('error' => $e->getMessage()));
}
